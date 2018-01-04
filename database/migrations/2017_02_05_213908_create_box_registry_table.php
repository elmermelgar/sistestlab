<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBoxRegistryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('box_registry', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sucursal_id');
            $table->date('date')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->time('time')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->integer('account_id')->nullable();
            $table->integer('state')->default(0);
            $table->decimal('cash', 8, 2)->default(0);
            $table->decimal('debit', 8, 2)->default(0);
            $table->decimal('debt', 8, 2)->default(0);
            $table->decimal('cost', 8, 2)->default(0);
            $table->decimal('payment', 8, 2)->default(0);
            $table->decimal('charge', 8, 2)->default(0);
            $table->decimal('billing', 8, 2)->default(0);
            $table->foreign('sucursal_id')->references('id')->on('sucursales');
            $table->foreign('account_id')->references('id')->on('accounts');
        });

        // Añade restricción
        DB::statement('
        alter table box_registry add constraint chk_registry_amounts check 
        ( debit >= 0 and debt >= 0 and cost >= 0 and payment >=0 and charge >=0 and billing >= 0);
        ');

        // Vista para el registro de caja
        DB::statement('
        create view registry_vw as select b.sucursal_id, b.date, b.time, 
            a.first_name||\' \'||coalesce(a.last_name,\'\') as name, 
            case b.state when 0 then \'Cerrada\' when 1 then \'Abierta\' end state, 
            b.cash, b.debit, b.debt, b.cost, b.payment, b.charge, b.billing 
            from box_registry b join accounts a on b.account_id=a.id;
        ');

        // Verifica si la caja de una sucursal está abierta
        DB::statement('
        create or replace function is_open(s_id int) returns bool as $$
        declare
            sucursal int;
            state integer;
        begin
            perform check_branch(s_id);
            select b.state from box_registry b where b.sucursal_id = s_id order by (date, time) desc limit 1 into state;
            if not found or state=0 then
                return false;
            end if;
            return true;
        end
        $$ language plpgsql;
        ');

        // Abre la caja de una sucursal
        DB::statement('
        create or replace function open_box(s_id int, a_id int, cash numeric(8,2)) returns bool as $$
        begin
            perform check_branch(s_id);
            if is_open(s_id) then
                return false;
            else
                -- open state = 1
                insert into box_registry(sucursal_id, account_id, state, cash) values(s_id, a_id, 1, cash);
                return true;
            end if;
        end;
        $$ language plpgsql;
        ');

        // Cierra la caja de una sucursal
        DB::statement('
        create or replace function close_box(s_id int, a_id int default 0) returns bool as $$
        declare
        	open_timestamp timestamp(0) without time zone; 
            close_timestamp timestamp(0) without time zone = current_timestamp;
            billing numeric(8,2)=0;
            payment numeric(8,2)=0;
        begin
            perform check_branch(s_id);
            if is_open(s_id) then
            	select date+time from box_registry b where b.sucursal_id=s_id and b.state=1 
                	order by (date, time) desc limit 1 into open_timestamp;
                billing=get_billing(s_id, open_timestamp, close_timestamp);
                payment=get_payment(s_id, open_timestamp, close_timestamp);
                -- close state = 0                
                insert into box_registry(sucursal_id, account_id, state, billing, payment, charge, cash, debit, debt, cost) 
                	values(s_id, a_id, 0, billing, payment,
                           get_charge(s_id, open_timestamp, close_timestamp),
                           get_cash(s_id, open_timestamp, close_timestamp),
                           get_debit(s_id, open_timestamp, close_timestamp),
                           billing-payment,
                           get_cost(s_id, open_timestamp, close_timestamp)
                          );
                return true;
            else
				return false;
            end if;
        end;
        $$ language plpgsql;
        ');

        // Obtiene el efectivo durante la apertura y cierre de caja
        DB::statement('
        create or replace function get_cash(s_id int, open_datetime timestamp(0) without time zone, 
            close_datetime timestamp(0) without time zone) returns numeric(8,2) as $$
        declare
            sucursal int;
            open_cash numeric(8,2);
            transact_cash numeric(8,2);
        begin
            perform check_branch(s_id);
            -- efectivo al abrir caja
            select cash from box_registry where sucursal_id=s_id and date+time=open_datetime into open_cash;
            -- efectivo por pagos en facturación y cobros
            -- cash type = 0
            select coalesce(sum(amount),0) cash from transactions where sucursal_id=s_id and type=0 
                and date+time between open_datetime and close_datetime into transact_cash;
            return open_cash+transact_cash;
        end
        $$ language plpgsql;
        ');

        // Obtiene los pagos con débito realizados durante la apertura y cierre de caja
        DB::statement('
        create or replace function get_debit(s_id int, open_datetime timestamp(0) without time zone, 
            close_datetime timestamp(0) without time zone) returns numeric(8,2) as $$
        declare
            sucursal int;
            debit numeric(8,2);
        begin
            perform check_branch(s_id);
            -- debito por pagos en facturación y cobros
            -- debit type = 1
            select coalesce(sum(amount),0) debit from transactions where sucursal_id=s_id and type=1 
                and date+time between open_datetime and close_datetime into debit;
            return debit;
        end
        $$ language plpgsql;
        ');

        // Obtiene los costos incurridos durante la apertura y cierre de caja
        DB::statement('
        create or replace function get_cost(s_id int, open_datetime timestamp(0) without time zone, 
            close_datetime timestamp(0) without time zone) returns numeric(8,2) as $$
        declare
            sucursal int;
            cost numeric(8,2);
        begin
            perform check_branch(s_id);
            -- costos por bonos a mensajeros
            select coalesce(-1*sum(amount),0) as cost from transactions where sucursal_id=s_id and amount<0 
                and date+time between open_datetime and close_datetime into cost;
            return cost;
        end
        $$ language plpgsql;
        ');

        // Obtiene los pagos en efectivo y débito realizados durante la facturación
        DB::statement('
        create or replace function get_payment(s_id int, open_datetime timestamp(0) without time zone, 
            close_datetime timestamp(0) without time zone) returns numeric(8,2) as $$
        declare
            sucursal int;
            payment numeric(8,2);
        begin
            perform check_branch(s_id);
            -- pagos en facturación
            -- efectivo + débito al facturar
            select coalesce(sum(p.amount),0) payment from payments_vw p join facturas f on p.factura_id=f.id
            	where p.date+p.time between open_datetime and close_datetime 
            	and f.sucursal_id=s_id and f.date+f.time between open_datetime and close_datetime 
                and f.estado_id in (select id from estados where tipo=\'factura\' and name=\'abierta\' or name=\'cerrada\') 
                into payment;
            return payment;
        end
        $$ language plpgsql;
        ');

        // Obtiene los cobros en efectivo y débito realizados durante la apertura y cierre de caja
        DB::statement('
        create or replace function get_charge(s_id int, open_datetime timestamp(0) without time zone, 
            close_datetime timestamp(0) without time zone) returns numeric(8,2) as $$
        declare
            sucursal int;
            charge numeric(8,2);
        begin
            perform check_branch(s_id);
            -- cobros
            select coalesce(sum(p.amount),0) charge from payments_vw p join facturas f on p.factura_id=f.id
            	where p.date+p.time between open_datetime and close_datetime 
            	and f.sucursal_id=s_id and f.date+f.time not between open_datetime and close_datetime 
                and f.estado_id in (select id from estados where tipo=\'factura\' and name=\'abierta\' or name=\'cerrada\') 
                into charge;
            return charge;
        end
        $$ language plpgsql;
        ');

        // Obtiene la facturación durante la apertura y cierre de caja
        DB::statement('
		create or replace function get_billing(s_id int, open_datetime timestamp(0) without time zone, 
            close_datetime timestamp(0) without time zone) returns numeric(8,2) as $$
        declare
            sucursal int;
            billing numeric(8,2);
        begin
            perform check_branch(s_id);
            -- facturación
            select coalesce(sum(total),0) billing from facturas where sucursal_id=s_id 
            	and date+time between open_datetime and close_datetime and estado_id in
            	(select id from estados where tipo=\'factura\' and name=\'abierta\' or name=\'cerrada\') 
                into billing;
            return billing;
        end
        $$ language plpgsql;
        ');

        // Obtiene el estado actual completo de la caja
        DB::statement('
        create or replace function get_box(s_id int) 
        returns table(
            sucursal_id integer,
            open_date date,
            open_time time,
            open_account_id integer,
            close_date date,
            close_time time,
            close_account_id integer,
            state integer,
            cash numeric(8,2),
            debit numeric(8,2),
            debt numeric(8,2),
            cost numeric(8,2),
            payment numeric(8,2),
            charge numeric(8,2),
            billing numeric(8,2)
        )
        as $$
        declare 
            opening box_registry%rowtype;
            closing box_registry%rowtype;
        begin
            perform check_branch(s_id);
            sucursal_id=s_id;
            
            -- open state = 1
            select * from box_registry b where b.sucursal_id=s_id and b.state=1 
                order by (date, time) desc limit 1 into opening;
            if not found then
                return;
            end if;
            
            -- filling opening
            open_date=opening.date;
            open_time=opening.time;
            open_account_id=opening.account_id;
                
            -- close state = 0
            select * from box_registry b where b.sucursal_id=s_id and b.state=0
                and date+time > opening.date+opening.time order by (date, time) desc
                limit 1 into closing;
            if found then
                close_date=closing.date;
                close_time=closing.time;
                close_account_id=closing.account_id;
                state=0;
                billing=closing.billing;
                payment=closing.payment;
                charge=closing.charge;
                cash=closing.cash;
                debit=closing.debit;
                debt=billing-payment;
                cost=closing.cost;
            else
                state=1;
                closing.date=current_date;
                closing.time=current_time;
                billing=get_billing(s_id, open_date+open_time, closing.date+closing.time);
                payment=get_payment(s_id, open_date+open_time, closing.date+closing.time);
                charge=get_charge(s_id, open_date+open_time, closing.date+closing.time);
                cash=get_cash(s_id, open_date+open_time, closing.date+closing.time);
                debit=get_debit(s_id, open_date+open_time, closing.date+closing.time);
                debt=billing-payment;
                cost=get_cost(s_id, open_date+open_time, closing.date+closing.time);
                closing.date=null;
                closing.time=null;
            end if;
            return next;
        end;
        $$ language plpgsql;
        ');

        // Obtiene el registro de caja por paginación
        DB::statement('
        create or replace function get_registry(s_id int, paginate int default 6, page int default 1) 
        returns setof registry_vw
        as $$
        declare 
            closing registry_vw%rowtype;
            "offset" int;
        begin
            perform check_branch(s_id);
            if paginate<=0 then raise exception \'La paginación debe ser mayor a cero\'; end if;
            if page<=0 then raise exception \'La página debe ser mayor a cero\'; end if;
            "offset"=paginate*(page-1);
            if is_open(s_id) then
                if "offset"=0 then
                    closing.date=current_date;
                    paginate=paginate-1;
                    return next closing;
                else
                    "offset"="offset"-1;
                end if;
            end if;
            return query select * from registry_vw where sucursal_id=s_id 
                order by (date,time) desc limit paginate offset "offset";
        end;
        $$ language plpgsql;
        ');

        // Obtiene el registro de caja de una sucursal en un rango de fechas
        DB::statement('
        create or replace function get_registry_by_date(s_id int, start_date date, end_date date) 
        returns setof registry_vw as $registry$
        declare
            x registry_vw%rowtype;
            y registry_vw%rowtype;
            r cursor for select * from registry_vw where sucursal_id=$1 and date between $2 and $3 order by (date, time) desc;
        begin
                open r;
                fetch first from r into x;
                if x.state = \'Abierta\' then 
                    select * from registry_vw where sucursal_id=$1 and date > $3 order by (date, time) asc
                        limit 1 into x;
                    if found then
                        return next x;
                    else
                        y.sucursal_id=$1; y.date=$3;
                        return next y;
                    end if;
                end if;
                close r;
                
                for x in r loop 
                    return next x;
                end loop;
                
                open r;
                fetch last from r into x;
                if x.state = \'Cerrada\' then
                    return query select * from registry_vw where sucursal_id=$1 and date < $2 order by (date, time) desc
                        limit 1;
                end if;
                close r;
                    
        end
        $registry$ language plpgsql;
        ');

        // Añade restricción de estado de caja
        DB::statement('
        create or replace function chk_registry_state() returns trigger as $func$
        declare state integer;
         begin
            select b.state from box_registry b where b.sucursal_id = new.sucursal_id order by date desc, time desc 
                limit 1 into state;
            if new.state=state then 
                raise exception \'No se puede registrar un estado de caja igual que el anterior: %\', new.state;
            end if;
            return new;
         end;
         $func$
         language plpgsql;
        ');

        // Añade restricción de estado de caja
        DB::statement('
        create trigger chk_registry_state before insert on box_registry
            for each row execute procedure chk_registry_state();
        ');

        // Índices
        DB::statement('
          create unique index box_registry_date_time_unique on box_registry(sucursal_id, date desc, "time" desc);
        ');

        DB::statement('
          create index box_registry_date_index on box_registry(date desc);
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('drop trigger chk_registry_state on box_registry;');
        DB::statement('drop function chk_registry_state();');
        DB::statement('drop function get_registry_by_date(int, date, date);');
        DB::statement('drop function get_registry(int, int, int);');
        DB::statement('drop function get_box(int);');
        DB::statement('drop function get_billing(int, timestamp(0), timestamp(0));');
        DB::statement('drop function get_charge(int, timestamp(0), timestamp(0));');
        DB::statement('drop function get_payment(int, timestamp(0), timestamp(0));');
        DB::statement('drop function get_cost(int, timestamp(0), timestamp(0));');
        DB::statement('drop function get_debit(int, timestamp(0), timestamp(0));');
        DB::statement('drop function get_cash(int, timestamp(0), timestamp(0));');
        DB::statement('drop function close_box(int, int);');
        DB::statement('drop function open_box(int, int, numeric(8,2));');
        DB::statement('drop function is_open(int);');
        DB::statement('drop view registry_vw;');
        Schema::dropIfExists('box_registry');
    }
}

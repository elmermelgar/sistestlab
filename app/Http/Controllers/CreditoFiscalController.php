<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Estado;
use App\Factura;
use App\InvoiceProfile;
use App\TaxCredit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Jleon\LaravelPnotify\Notify;

class CreditoFiscalController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        return view('credito_fiscal.index', [
            'creditos_fiscales' => TaxCredit::filter($request->get('numero'))->paginate(10),
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function customers()
    {
        $clientes = Customer::join('facturas', 'customers_vw.id', '=', 'facturas.customer_id')
            ->where('facturas.credito_fiscal', true)->where('facturas.tax_credit_id', null)
            ->select(DB::raw('customers_vw.id, customers_vw.nit, customers_vw.name, 
            count(facturas) as cantidad_facturas, sum(facturas.total) as total'))
            ->groupBy(['customers_vw.id', 'customers_vw.nit', 'customers_vw.name'])->get();
        return view('credito_fiscal.customers', ['clientes' => $clientes]);
    }

    /**
     * Se muestra el credito fiscal como una factura normal, para lo cual es necesario asignar
     * el cliente, un estado de factura y confirmar el atributo credito_fiscal.
     * Se agrupan todos los perfiles de exámenes de las facturas correspondientes al crédito fiscal
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        if ($credito_fiscal = TaxCredit::find($id)) {
            $credito_fiscal->customer = $credito_fiscal->facturas()->first()->customer;
            /**
             * se debe asignar el estado de factura CERRADA para omitir los procesos inherentes a
             * una factura normal, así solo se cargarán los de modificar y terminar el crédito fiscal
             */
            $credito_fiscal->estado = Estado::where('name', 'cerrada')->where('tipo', 'factura')->first();
            $credito_fiscal->credito_fiscal = true;
            $profiles = InvoiceProfile::whereIn('factura_id', $credito_fiscal->facturas()->pluck('id')->all())
                ->get()->groupBy('profile_id');
            Notify::info('Usted está viendo un comprobante de crédito fiscal');
            return view('factura.show', [
                'factura' => $credito_fiscal,
                'sucursal' => $credito_fiscal->account->sucursal,
                'facturador' => $credito_fiscal->account,
                'centro_origen' => false,
                'edit' => false,
                'profiles' => $profiles,
                'suma' => $credito_fiscal->facturas()->first()->payments()->sum('amount'),
                'credito_fiscal' => true,
            ]);
        }
        return abort(404);
    }

    /**
     * @param $cliente_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create($cliente_id)
    {
        if ($cliente = Customer::find($cliente_id)) {
            $facturas = Factura::where('tax_credit_id', null)
                ->where('credito_fiscal', true)
                ->where('customer_id', $cliente_id)
                ->orderBy('date')->orderBy('time')->get();
            return view('credito_fiscal.edit', [
                'credito_fiscal' => null,
                'sucursal' => Auth::user()->account->sucursal,
                'cliente' => $cliente,
                'facturas' => $facturas,
                'user' => Auth::user()->account,
            ]);
        }
        return abort(404);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        if ($credito_fiscal = TaxCredit::find($id)) {
            if ($credito_fiscal->closed) {
                Notify::warning('Éste crédito fiscal no puede modificarse');
                return redirect()->action('CreditoFiscalController@show', ['id' => $credito_fiscal->id]);
            }
            $cliente = $credito_fiscal->customer;
            $facturas = Factura::where('tax_credit_id', null)->where('customer_id', $cliente->id)
                ->where('credito_fiscal', true)->orWhere('tax_credit_id', $credito_fiscal->id)
                ->orderBy('date')->orderBy('time')->get();
            return view('credito_fiscal.edit', [
                'credito_fiscal' => $credito_fiscal,
                'sucursal' => $credito_fiscal->account->sucursal,
                'cliente' => $cliente,
                'facturas' => $facturas,
                'user' => $credito_fiscal->account,
            ]);
        }
        return abort(404);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'tax_credit_id' => 'integer',
            'account_id' => 'required|integer|min:1',
            'customer_id' => 'required|integer|min:1',
            'factura_id' => 'required|array|min:1',
        ]);

        if (count($request->factura_id) <= 0) {
            Notify::error('Debe seleccionar al menos una factura para registrar el crédito fiscal');
            return redirect()->back()->withInput();
        }
        $estado_cerrada = \App\Estado::select('id')->where('name', 'cerrada')->where('tipo', 'factura')->first();
        $abiertas = \App\Factura::whereIn('id', $request->factura_id)
            ->where('estado_id', '<>', $estado_cerrada->id)->pluck('id');
        if (count($abiertas)) {
            Notify::error('No puede agregar facturas pendientes o abiertas a un comprobante de crédito fiscal. 
            Por favor cierre las facturas.');
            return redirect()->back()->withInput();
        }

        DB::beginTransaction();
        try {
            if ($credito_fiscal = TaxCredit::find($request->tax_credit_id)) {
                $credito_fiscal->update($request->all());
                foreach ($credito_fiscal->facturas as $factura) {
                    $factura->tax_credit()->dissociate();
                    $factura->save();
                }
            } else {
                $credito_fiscal = TaxCredit::create($request->all());
            }

            $total = 0;
            $facturas = Factura::whereIn('id', $request->factura_id)->where('customer_id', $request->customer_id)->get();
            foreach ($facturas as $factura) {
                $factura->tax_credit()->associate($credito_fiscal);
                $factura->save();
                $total += $factura->total;
            }
            $credito_fiscal->total = $total;
            $credito_fiscal->save();

            //Exito, hace efectivos todos los cambios en la base de datos
            DB::commit();

        } catch (\Exception $e) {
            //Ocurre algun error, revierte todos los cambios en la base de datos y responde con un mensaje
            DB::rollBack();
            \Log::error($e);
            Notify::error("Ocurrió un error al registrar el crédito fiscal");
            return back()->withInput();
        }

        Notify::success('El crédito fiscal se guardó correctamente');
        return redirect()->action('CreditoFiscalController@show', ['id' => $credito_fiscal->id]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function close(Request $request)
    {
        DB::beginTransaction();
        try {
            if ($credito_fiscal = TaxCredit::find($request->tax_credit_id)) {
                $credito_fiscal->closed = true;
                $credito_fiscal->save();
            } else {
                Notify::error('No se confirmó ningun crédito fiscal');
                return redirect()->back();
            }

            //Exito, hace efectivos todos los cambios en la base de datos
            DB::commit();

        } catch (\Exception $e) {
            //Ocurre algun error, revierte todos los cambios en la base de datos y responde con un mensaje
            DB::rollBack();
            \Log::error($e);
            Notify::error("Ocurrió un error al confirmar el crédito fiscal");
            return back()->withInput();
        }

        Notify::success('El crédito fiscal fue confirmado correctamente');
        return redirect()->action('CreditoFiscalController@show', ['id' => $credito_fiscal->id]);
    }
}

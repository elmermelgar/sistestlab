<?php

namespace App\Services;


use App\BoxRegistry;
use App\Estado;
use App\Factura;
use App\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class SucursalService
{

    /**
     * Constante para el estado de caja cerrada
     */
    const CLOSED = 0;

    /**
     * Constante para el estado de caja abierta
     */
    const OPEN = 1;

    /**
     * Verifica si la caja de una sucursal esta abierta
     * @param $sucursal_id
     * @return bool
     */
    public static function isOpen($sucursal_id)
    {
        $caja = BoxRegistry::where('sucursal_id', $sucursal_id)
            ->latest('date')->latest('time')->first();
        if ($caja && $caja->state == self::OPEN) {
            return true;
        }
        return false;
    }

    /**
     * Abre la caja de la sucursal especificada
     * @param $sucursal_id
     * @param $account_id
     * @param $cash
     * @return bool
     */
    public function abrirCaja($sucursal_id, $account_id, $cash = 0)
    {
        if (!$this->isOpen($sucursal_id)) {
            BoxRegistry::create([
                'sucursal_id' => $sucursal_id,
                'account_id' => $account_id,
                'state' => self::OPEN,
                'cash' => $cash,
            ]);
            return true;
        }
        return false;
    }

    /**
     * Cierra la caja de la sucursal especificada
     * @param $sucursal_id
     * @param $account_id
     * @return bool
     */
    public function cerrarCaja($sucursal_id, $account_id = null)
    {
        if ($this->isOpen($sucursal_id)) {
            $opening = BoxRegistry::where('sucursal_id', $sucursal_id)
                ->where('state', self::OPEN)
                ->latest('date')
                ->latest('time')->first();
            BoxRegistry::create([
                'sucursal_id' => $sucursal_id,
                'account_id' => $account_id,
                'state' => self::CLOSED,
                'cash' => $this->getCash($sucursal_id, $opening),
                'debit' => $this->getDebit($sucursal_id, $opening),
                'debt' => $this->getSale($sucursal_id, $opening) - $this->getPayment($sucursal_id, $opening),
                'cost' => $this->getCost($sucursal_id, $opening)
            ]);
            return true;
        }
        return false;
    }

    /**
     * Retorna la caja actual de la sucursal especificada
     * @param $sucursal_id
     * @return array
     */
    public function getCaja($sucursal_id)
    {
        $caja = [
            'opening' => null,
            'closing' => null,
            'sale' => null,
            'cash' => null,
            'debit' => null,
            'debt' => null,
            'cost' => null
        ];
        $opening = BoxRegistry::where('sucursal_id', $sucursal_id)
            ->where('state', self::OPEN)
            ->latest('date')
            ->latest('time')->first();
        if ($opening) {
            $closing = BoxRegistry::where('sucursal_id', $sucursal_id)
                ->where('state', self::CLOSED)
                ->where('date', '>', $opening->date)
                ->where('time', '>', $opening->time)->first();
            $caja['opening'] = $opening;
            $caja['closing'] = $closing;
            $caja['sale'] = $this->getSale($sucursal_id, $opening);
            $caja['cash'] = $this->getCash($sucursal_id, $opening);
            $caja['debit'] = $this->getDebit($sucursal_id, $opening);
            $caja['debt'] = $caja['sale'] - $this->getPayment($sucursal_id, $opening);
            $caja['cost'] = $this->getCost($sucursal_id, $opening);
        }
        return $caja;
    }

    /**
     * @param $sucursal_id
     * @param $paginate
     * @return array
     */
    public function getRegistro($sucursal_id, $paginate = 5, $page = 1)
    {
        if (!$this->isOpen($sucursal_id) && ($paginate % 2) == 1) {
            $paginate += 1;
        }
        $registros = BoxRegistry::where('sucursal_id', $sucursal_id)
            ->orderBy('date', 'desc')->orderBy('time', 'desc')
            ->paginate($paginate, ['*'], 'page', $page)->all();
        $registro = [];
        $count = count($registros);

//        DB::enableQueryLog();

        for ($i = 0; $i < $count; $i++) {
            if ($i + 1 < $count && $registros[$i]->state == \App\Services\SucursalService::CLOSED
            ) {
                $registro[] = [
                    'closing' => $registros[$i],
                    'opening' => $registros[$i + 1],
                    'sale' => $this->getSale($sucursal_id, $registros[$i + 1], $registros[$i])
                ];
                $i++;
            } else {
                $registro[] = [
                    'opening' => $registros[$i],
                    'sale' => $this->getSale($sucursal_id, $registros[$i])
                ];
            }
        }

//        dump(
//            DB::getQueryLog()
//        );

        return $registro;
    }

    /**
     * Obtiene el efectivo actual de la caja
     * @param $sucursal_id
     * @param BoxRegistry $opening
     * @param BoxRegistry $closing
     * @return int
     */
    private function getCash($sucursal_id, BoxRegistry $opening, BoxRegistry $closing = null)
    {
        if (is_null($closing)) {
            $closing = new BoxRegistry();
            $closing->time = Carbon::now()->toTimeString();
        }
        //Efectivo al abrir caja
        $cash = $opening->cash;
        //Más las ventas en efectivo
        $cash = $cash + DB::table('transactions')
                ->where('sucursal_id', $sucursal_id)
                ->where('date', $opening->date)
                ->whereBetween('time', [$opening->time, $closing->time])
                ->where('type', Transaction::CASH)
                ->selectRaw("sum(amount)")->first()->sum;
        return $cash ? $cash : 0;
    }

    /**
     * Obtiene el debito actual de la caja
     * @param $sucursal_id
     * @param BoxRegistry $opening
     * @param BoxRegistry $closing
     * @return int
     */
    private function getDebit($sucursal_id, BoxRegistry $opening, BoxRegistry $closing = null)
    {
        if (is_null($closing)) {
            $closing = new BoxRegistry();
            $closing->time = Carbon::now()->toTimeString();
        }
        //ventas en débito
        $debit = DB::table('transactions')
            ->where('sucursal_id', $sucursal_id)
            ->where('date', $opening->date)
            ->whereBetween('time', [$opening->time, $closing->time])
            ->where('type', Transaction::DEBIT)
            ->selectRaw("coalesce(sum(amount),0) debit")->first()->debit;
        return $debit;
    }

    /**
     * Obtiene los pagos actuales de la caja para calcular la deuda
     * @param $sucursal_id
     * @param BoxRegistry $opening
     * @param BoxRegistry $closing
     * @return int
     */
    private function getPayment($sucursal_id, BoxRegistry $opening, BoxRegistry $closing = null)
    {
        if (is_null($closing)) {
            $closing = new BoxRegistry();
            $closing->time = Carbon::now()->toTimeString();
        }
        $payment = DB::table('transactions')
            ->where('sucursal_id', $sucursal_id)
            ->where('amount', '>', 0)
            ->where('date', $opening->date)
            ->whereBetween('time', [$opening->time, $closing->time])
            ->selectRaw("coalesce(sum(amount),0) payment")->first()->payment;
        return $payment;
    }

    /**
     * Obtiene la venta actual desde que la caja fue abierta
     * @param $sucursal_id
     * @param BoxRegistry $opening
     * @param BoxRegistry $closing
     * @return int
     */
    private function getSale($sucursal_id, BoxRegistry $opening, BoxRegistry $closing = null)
    {
        if (is_null($closing)) {
            $closing = new BoxRegistry();
            $closing->date = Carbon::now()->toDateString();
            $closing->time = Carbon::now()->toTimeString();
        }
        $estado_anulada = Estado::where('name', Factura::ANULADA)->where('tipo', 'factura')->first();
        $sale = DB::table('facturas')
            ->where('sucursal_id', $sucursal_id)
            ->whereBetween('date', [$opening->date, $closing->date])
            ->whereBetween('time', [$opening->time, $closing->time])
            ->where('estado_id', '<>', $estado_anulada->id)
            ->selectRaw("coalesce(sum(total),0) sale")->first()->sale;
        return $sale;
    }

    /**
     * Obtiene el costo actual desde que la caja fue abierta
     * @param $sucursal_id
     * @param BoxRegistry $opening
     * @param BoxRegistry $closing
     * @return int
     */
    private function getCost($sucursal_id, BoxRegistry $opening, BoxRegistry $closing = null)
    {
        if (is_null($closing)) {
            $closing = new BoxRegistry();
            $closing->date = Carbon::now()->toDateString();
            $closing->time = Carbon::now()->toTimeString();
        }
        $cost = DB::table('transactions')
            ->where('sucursal_id', $sucursal_id)
            ->where('amount', '<', 0)
            ->whereBetween('date', [$opening->date, $closing->date])
            ->whereBetween('time', [$opening->time, $closing->time])
            ->selectRaw('coalesce(-1*sum(amount),0) "cost"')->first()->cost;
        return $cost;
    }

}
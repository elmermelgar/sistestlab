<?php

namespace App\Services;


use App\BoxRegistry;
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
            //->whereDate('date', Carbon::now()->toDateString())
            ->latest('date')->latest('time')->first();
        if ($caja && $caja->state == self::OPEN) {
            return true;
        }
        return false;
    }

    /**
     * Abre la caja de la sucursal especificada
     * @param $sucursal_id
     * @param $user_id
     * @param $cash
     * @return bool
     */
    public function abrirCaja($sucursal_id, $user_id, $cash = 0)
    {
        if (!$this->isOpen($sucursal_id)) {
            BoxRegistry::create([
                'sucursal_id' => $sucursal_id,
                'user_id' => $user_id,
                'state' => self::OPEN,
                'cash' => $cash,
            ]);
            return true;
        } else {
            return false;
        }
    }

    /**
     * Cierra la caja de la sucursal especificada
     * @param $sucursal_id
     * @param $user_id
     * @return bool
     */
    public function cerrarCaja($sucursal_id, $user_id = null)
    {
        if ($this->isOpen($sucursal_id)) {
            $opening = BoxRegistry::where('sucursal_id', $sucursal_id)
                //->whereDate('date', Carbon::now()->toDateString())
                ->where('state', self::OPEN)
                ->latest('date')
                ->latest('time')->first();
            BoxRegistry::create([
                'sucursal_id' => $sucursal_id,
                'user_id' => $user_id,
                'state' => self::CLOSED,
                'cash' => $this->getCash($sucursal_id, $opening),
                'debit' => $this->getDebit($sucursal_id, $opening),
                'debt' => $this->getSale($sucursal_id, $opening) - $this->getPayment($sucursal_id, $opening)
            ]);
            return true;
        } else {
            return false;
        }
    }

    /**
     * Retorna la caja actual de la sucursal especificada
     * @param $sucursal_id
     * @return array
     */
    public function getCaja($sucursal_id)
    {
        $caja = ['opening' => null, 'closing' => null, 'sale' => null, 'cash' => null, 'debit' => null, 'debt' => null];
        $opening = BoxRegistry::where('sucursal_id', $sucursal_id)
            //->whereDate('date', Carbon::now()->toDateString())
            ->where('state', self::OPEN)
            ->latest('date')
            ->latest('time')->first();
        if ($opening) {
            $closing = BoxRegistry::where('sucursal_id', $sucursal_id)
                //->whereDate('date', Carbon::now()->toDateString())
                ->where('state', self::CLOSED)
                ->latest('date')
                ->where('time', '>', $opening->time)->first();
            $caja['opening'] = $opening;
            $caja['closing'] = $closing;
            $caja['sale'] = $this->getSale($sucursal_id, $opening);
            $caja['cash'] = $this->getCash($sucursal_id, $opening);
            $caja['debit'] = $this->getDebit($sucursal_id, $opening);
            $caja['debt'] = $caja['sale'] - $this->getPayment($sucursal_id, $opening);
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
        for ($i = 0; $i < $count; $i++) {
            if ($i + 1 < $count && $registros[$i]->time > $registros[$i + 1]->time &&
                $registros[$i]->state == \App\Services\SucursalService::CLOSED
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
        $cash = $opening->cash;
        $cash = $cash + DB::table('transactions')
                ->where('sucursal_id', $sucursal_id)
                ->where('date', $opening->date)
                ->where('time', '>=', $opening->time)
                ->where('time', '<=', $closing->time)
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
        $debit = DB::table('transactions')
            ->where('sucursal_id', $sucursal_id)
            ->where('date', $opening->date)
            ->where('time', '>=', $opening->time)
            ->where('time', '<=', $closing->time)
            ->where('type', Transaction::DEBIT)
            ->selectRaw("sum(amount)")->first()->sum;
        return $debit ? $debit : 0;
    }

    /**
     * Obtiene los pagos actuales de la caja
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
            ->where('date', $opening->date)
            ->where('time', '>=', $opening->time)
            ->where('time', '<=', $closing->time)
            ->selectRaw("sum(amount)")->first()->sum;
        return $payment ? $payment : 0;
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
        $opening->time = Carbon::createFromFormat('Y-m-d H:i:s', "$opening->date $opening->time");
        if (is_null($closing)) {
            $closing = new BoxRegistry();
            $closing->time = Carbon::now();
        } else {
            $closing->time = Carbon::createFromFormat('Y-m-d H:i:s', "$closing->date $closing->time");
        }
        $sale = DB::table('facturas')
            ->where('sucursal_id', $sucursal_id)
            ->where('updated_at', '>=', $opening->time)
            ->where('updated_at', '<=', $closing->time)
            ->selectRaw("sum(total)")->first()->sum;
        return $sale ? $sale : 0;
    }

}
<?php

namespace App\Services;


use App\CajaRegistro;
use App\User;
use Carbon\Carbon;

class SucursalService
{

    /**
     * Constante para el estado de caja cerrada
     */
    const CERRADA = 0;

    /**
     * Constante para el estado de caja abierta
     */
    const ABIERTA = 1;

    /**
     * Verifica si la caja de una sucursal esta abierta
     * @param $sucursal_id
     * @return bool
     */
    public static function isOpen($sucursal_id)
    {
        $caja = CajaRegistro::where('sucursal_id', $sucursal_id)
            ->whereDate('stamp', Carbon::now()->toDateString())
            ->latest('stamp')
            ->first();
        if ($caja && $caja->estado == self::ABIERTA) {
            return true;
        }
        return false;
    }

    /**
     * Verifica si la caja de una sucursal puede ser abierta en la fecha actual
     * @param $sucursal_id
     * @return bool
     */
    public static function canBeOpened($sucursal_id)
    {
        $caja = CajaRegistro::where('sucursal_id', $sucursal_id)
            ->whereDate('stamp', Carbon::now()->toDateString())
            ->latest('stamp')
            ->first();
        if ($caja && $caja->estado == self::ABIERTA) {
            return false;
        }
        return true;
    }

    /**
     * Abre la caja de la sucursal especificada
     * @param $sucursal_id
     * @param User $user
     * @return bool
     */
    public function abrirCaja($sucursal_id, User $user)
    {
        if ($this->canBeOpened($sucursal_id)) {
            $registro = new CajaRegistro();
            $registro->sucursal()->associate($sucursal_id);
            $registro->user()->associate($user);
            $registro->stamp = Carbon::now();
            $registro->estado = self::ABIERTA;
            $registro->save();
            return true;
        } else {
            return false;
        }
    }

    /**
     * Cierra la caja de la sucursal especificada
     * @param $sucursal_id
     * @param User $user
     * @return bool
     */
    public function cerrarCaja($sucursal_id, User $user = null)
    {
        if ($this->isOpen($sucursal_id)) {
            $registro = new CajaRegistro();
            $registro->sucursal()->associate($sucursal_id);
            if ($user) {
                $registro->user()->associate($user);
            }
            $registro->stamp = Carbon::now();
            $registro->estado = self::CERRADA;
            $registro->efectivo = $this->getEfectivo($sucursal_id);
            $registro->save();
            return true;
        } else {
            return false;
        }
    }

    /**
     * Retorna la caja actual de la sucursal especificada
     * @param $sucursal_id
     * @return CajaRegistro
     */
    public function getCaja($sucursal_id)
    {
        $caja = new CajaRegistro();
        $apertura = CajaRegistro::where('sucursal_id', $sucursal_id)
            ->whereDate('stamp', Carbon::now()->toDateString())
            ->where('estado', self::ABIERTA)
            ->oldest('stamp')->first();
        $cierre = CajaRegistro::where('sucursal_id', $sucursal_id)
            ->whereDate('stamp', Carbon::now()->toDateString())
            ->where('estado', self::CERRADA)
            ->latest('stamp')->first();
        if ($apertura) {
            $caja->open_time = $apertura->stamp;
        }
        if ($cierre) {
            $caja->close_time = $cierre->stamp;
        }
        $caja->efectivo = $this->getEfectivo($sucursal_id);
        return $caja;
    }

    /**
     * @param $sucursal_id
     * @return array
     */
    public function getRegistro($sucursal_id)
    {
        $registro = CajaRegistro::where('sucursal_id', $sucursal_id)
            ->orderBy('stamp', 'desc')->get();
        return $registro;
    }

    /**
     * Obtiene el efectivo actual de la caja
     * @param $sucursal_id
     * @return int
     */
    private function getEfectivo($sucursal_id)
    {
        return 0;
    }

}
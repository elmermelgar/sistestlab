<?php

namespace App\Services;


use App\CajaRegistro;
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
            ->where('fecha', Carbon::now()->toDateString())->first();
        if ($caja && $caja->estado) {
            return true;
        }
        return false;
    }

    /**
     * Verifica si la caja de una sucursal puede ser abierta en al fecha actual
     * @param $sucursal_id
     * @return bool
     */
    public static function canBeOpened($sucursal_id)
    {
        $caja = CajaRegistro::where('sucursal_id', $sucursal_id)
            ->where('fecha', Carbon::now()->toDateString())
            ->where('estado', self::ABIERTA)
            ->first();
        if ($caja && $caja->estado) {
            return false;
        }
        return true;
    }

    /**
     * Abre la caja de la sucursal especificada
     * @param $sucursal_id
     * @return bool
     */
    public function abrirCaja($sucursal_id)
    {
        if ($this->canBeOpened($sucursal_id)) {
            $registro = new CajaRegistro();
            $registro->sucursal()->associate($sucursal_id);
            $registro->fecha = Carbon::now()->toDateString();
            $registro->estado = self::ABIERTA;
            $registro->hora = Carbon::now()->toTimeString();
            $registro->save();
            return true;
        } else {
            return false;
        }
    }

    /**
     * Cierra la caja de la sucursal especificada
     * @param $sucursal_id
     * @return bool
     */
    public function cerrarCaja($sucursal_id)
    {
        if ($this->isOpen($sucursal_id)) {
            $registro = new CajaRegistro();
            $registro->sucursal()->associate($sucursal_id);
            $registro->fecha = Carbon::now()->toDateString();
            $registro->estado = self::CERRADA;
            $registro->hora = Carbon::now()->toTimeString();
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
            ->where('fecha', Carbon::now()->toDateString())
            ->where('estado', self::ABIERTA)->first();
        $cierre = CajaRegistro::where('sucursal_id', $sucursal_id)
            ->where('fecha', Carbon::now()->toDateString())
            ->where('estado', self::CERRADA)->first();
        if ($apertura) {
            $caja->is_open = true;
            $caja->open_time = $apertura->hora;
        }
        if ($cierre) {
            $caja->is_open = false;
            $caja->close_time = $cierre->hora;
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
            ->where('fecha', Carbon::now()->toDateString())->get();
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
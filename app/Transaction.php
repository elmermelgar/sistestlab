<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    /**
     * Constante para el tipo de transaccion en efectivo
     */
    const CASH = 0;

    /**
     * Constante para el tipo de transaccion con debito
     */
    const DEBIT = 1;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sucursal_id', 'amount', 'type',
    ];

    /**
     * Sucursal correspondiente a la transaccion
     */
    public function sucursal()
    {
        return $this->belongsTo('App\Sucursal');
    }

    /**
     * Obtiene, si corresponde, el pago de una factura asociado a la transaccion
     */
    public function payment()
    {
        return $this->hasOne('App\Payment');
    }

}

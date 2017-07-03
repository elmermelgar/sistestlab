<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'payments_vw';

    /**
     * The primary key associated with the model.
     *
     * @var array
     */
    protected $primaryKey = ['transaction_id', 'factura_id'];

    /**
     * Is the primary key an incrementing integer value
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sucursal_id', 'transaction_id', 'factura_id', 'amount', 'type'
    ];

    /**
     * Obtiene la transaccion correspondiente al pago.
     */
    public function transaction()
    {
        return $this->belongsTo('App\Transaction');
    }

    /**
     * Obtiene la factura correspondiente al pago.
     */
    public function factura()
    {
        return $this->belongsTo('App\Factura');
    }

}

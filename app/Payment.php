<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{

    /**
     * @var string
     */
    #public $table = 'payments';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'factura_id', 'amount', 'type',
    ];

    /**
     * Obtiene la factura correspondiente al pago.
     */
    public function factura()
    {
        return $this->belongsTo('App\Factura');
    }

}

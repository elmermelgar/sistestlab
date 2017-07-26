<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    /**
     * Constantes para estados de factura
     */
    const BORRADOR = 'borrador';
    const ABIERTA = 'abierta';
    const CERRADA = 'cerrada';
    const ANULADA = 'anulada';

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
        'sucursal_id', 'cliente_id', 'user_id', 'recolector_id', 'estado_id', 'centro_origen',
        'numero', 'total', 'credito_fiscal'
    ];

    /**
     * Cliente de la factura
     */
    public function cliente()
    {
        return $this->belongsTo('App\Cliente');
    }

    /**
     * Usuario que factura
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Recolector de muestras
     */
    public function recolector()
    {
        return $this->belongsTo('App\Recolector');
    }

    /**
     * Sucursal a la que se facturo
     */
    public function sucursal()
    {
        return $this->belongsTo('App\Sucursal');
    }

    /**
     * Perfiles facturados.
     */
    public function profiles()
    {
        return $this->hasMany('App\InvoiceProfile');
    }

    /**
     * Perfiles facturados.
     */
    public function payments()
    {
        return $this->hasMany('App\Payment');
    }

    /**
     * Estado de la factura
     */
    public function estado()
    {
        return $this->belongsTo('App\Estado');
    }

    /**
     * Credito fiscal de la factura
     */
    public function tax_credit()
    {
        return $this->belongsTo('App\TaxCredit');
    }

    //Busqueda de facturas
    public function scopeFilter($query, $numero)
    {
        if (trim($numero) != "") {
            $query->where('numero', "~*", $numero);
        }
    }

}

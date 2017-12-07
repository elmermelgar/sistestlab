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
        'sucursal_id', 'customer_id', 'account_id', 'recolector_id', 'estado_id', 'centro_origen',
        'numero', 'total', 'credito_fiscal'
    ];

    /**
     * Cliente de la factura
     */
    public function customer()
    {
        return $this->belongsTo('App\Customer');
    }

    /**
     * Usuario que factura
     */
    public function facturador()
    {
        return $this->belongsTo('App\Account', 'account_id');
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

    /**
     * @param $query
     * @param array $params
     */
    public function scopeFilter($query, array $params)
    {
        if (array_key_exists('fecha_inicio', $params) && array_key_exists('fecha_fin', $params)
            && trim($params['fecha_inicio']) != "" && trim($params['fecha_fin']) != "") {
            $query->whereBetween('date', [$params['fecha_inicio'], $params['fecha_fin']]);
        } else {
            $init_date = \Carbon\Carbon::now()->subDays(7)->toDateString();
            $query->whereBetween('date', [$init_date, \Carbon\Carbon::now()->toDateString()]);
        }
        if (array_key_exists('numero', $params) && trim($params['numero']) != "") {
            $query->where('numero', "~*", $params['numero']);
        }
        if (array_key_exists('estado', $params) && trim($params['estado']) != "") {
            $estado = Estado::select('id')->where('name', $params['estado'])->where('tipo', 'factura')->first();
            $query->where('estado_id', $estado->id);
        } else {
            $estado_cerrada = Estado::select('id')->where('name', Factura::CERRADA)->where('tipo', 'factura')->first();
            $query->orWhere('estado_id', '<>', $estado_cerrada->id);
        }
    }

}

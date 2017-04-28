<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sucursal_id', 'cliente_id', 'user_id', 'recolector_id', 'estado_id', 'centro_origen',
        'numero', 'efectivo', 'debito', 'deuda', 'total', 'credito_fiscal'
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
     * Examenes facturados.
     */
    public function examen_paciente()
    {
        return $this->hasMany('App\ExamenPaciente');
    }

}

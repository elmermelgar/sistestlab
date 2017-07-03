<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recolector extends Model
{
    /**
     * @var string
     */
    public $table = 'recolectores';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'dui', 'nit', 'nombre', 'apellido', 'activo',
    ];

    /**
     * Devuelve el nombre completo del paciente
     * @return string
     */
    public function getFullName()
    {
        return $this->nombre . ' ' . $this->apellido;
    }

    /**
     * Relacion de muchos a muchos con Bono.
     */
    public function bonos()
    {
        return $this->belongsToMany('App\Bono', 'bono_recolector_vw')
            ->withPivot(['transaction_id', 'sucursal_id', 'amount', 'type', 'date']);
    }

    /**
     * Obtiene las facturas para las que ha recolectado muestras.
     */
    public function facturas()
    {
        return $this->hasMany('App\Factura');
    }

}

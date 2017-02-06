<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sucursal extends Model
{
    /**
     * @var string
     */
    public $table='sucursales';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'display_name','telefono','direccion',
    ];

    /**
     * Imagen de sucursal
     */
    public function imagen()
    {
        return $this->belongsTo('App\Imagen','imagen_id');
    }

    public function activos(){
        return $this->hasMany('App\Activo');
    }

    /**
     * Registro de aperturas y cierres de caja.
     */
    public function registro()
    {
        return $this->hasMany('App\CajaRegistro');
    }

}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    /**
     * @var string
     */
    protected $table='proveedors';

    /**
     *
     * @var array
     */
    protected $fillable = ['nombre', 'telefono', 'rubro', 'ubicacion', 'email','otros'];

    /**
     * @var boolean
     */
    public $timestamps=false;


    public function activos(){
        return $this->hasMany('App\Activo');
    }
}

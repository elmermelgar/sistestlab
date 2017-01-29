<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sucursal extends Model
{
    /**
     * @var string
     */
    public $table='sucursales';


    public function imagen()
    {
        return $this->belongsTo('App\Imagen','imagen_id');
    }

    public function activos(){
        return $this->hasMany('App\Activo');
    }

}

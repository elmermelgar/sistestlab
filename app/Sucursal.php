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
     * @var boolean
     */
    public $timestamps=false;

    public function activos(){
        return $this->hasMany('App\Activo');
    }

}

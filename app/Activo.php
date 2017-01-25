<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activo extends Model
{
    /**
     * @var string
     */
    protected $table='activos';

    /**
     *
     * @var array
     */
    protected $fillable = ['nombre_activo', 'fecha_adq', 'precio', 'num_lote', 'ubicacion','tipo','marca','modelo','serie','unidades','proveedor_id','sucursal_id','estado_id'];

    /**
     * @var boolean
     */
    public $timestamps=false;


    public function proveedor(){
        return $this->belongsTo('App\Proveedor');
    }

    public function estado(){
        return $this->belongsTo('App\Estado');
    }

    public function sucursal(){
        return $this->belongsTo('App\Sucursal');
    }

    public function inventario(){
        return $this->hasOne('App\Inventario');
    }
}

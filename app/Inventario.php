<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inventario extends Model
{
    /**
     * @var string
     */
    protected $table='inventarios';

    /**
     *
     * @var array
     */
    protected $fillable = ['cod_inventario', 'existencia', 'cantidad_minima', 'cantidad_maxima', 'fecha_cargado','fecha_vencimiento','activo_id'];

    /**
     * @var boolean
     */
     public $timestamps=false;

    public function activo(){
        return $this->belongsTo('App\Activo');
    }
}

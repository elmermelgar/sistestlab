<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Imagen extends Model
{
    /**
     * @var string
     */
    public $table='imagenes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'description','file_name','default',
    ];

    /**
     * Obtiene la imagen por defecto para sucursales y logos
     */
    public static function getDefaultImage(){
        return Imagen::where('default',true)->first();
    }

}

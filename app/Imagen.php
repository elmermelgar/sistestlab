<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Imagen extends Model
{
    /**
     * @var string
     */
    public $table = 'imagenes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'description', 'file_name', 'imagen_categoria_id',
    ];

    /**
     * Obtiene la imagen por defecto para sucursales y logos
     */
    public static function getDefaultImage()
    {
        return Imagen::where('default', true)->first();
    }

    /**
     * Obtiene las sucursales que estan ocupando la imagen.
     */
    public function sucursales()
    {
        return $this->hasMany('App\Sucursal');
    }

    /**
     * Categoria de la imagen
     */
    public function categoria()
    {
        return $this->belongsTo('App\ImagenCategoria','imagen_categoria_id');
    }

}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ImagenCategoria extends Model
{

    /**
     * @var string
     */
    protected $table = 'imagen_categoria';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','display_name','description'
    ];

    /**
     * Imagenes con la categoria correspondiente
     */
    public function imagenes()
    {
        return $this->$this->hasMany('App\Imagen');
    }

}

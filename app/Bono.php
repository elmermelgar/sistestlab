<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bono extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'monto', 'descripcion',
    ];

    /**
     * Relacion de muchos a muchos con Recolector.
     */
    public function recolectores()
    {
        return $this->belongsToMany('App\Recolector')->withPivot('fecha');
    }
}

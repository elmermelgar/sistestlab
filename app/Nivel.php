<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nivel extends Model
{
    /**
     * @var string
     */
    public $table = 'niveles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'porcentaje', 'descripcion',
    ];
}

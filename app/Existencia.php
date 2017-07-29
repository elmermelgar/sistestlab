<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Existencia extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sucursal_id', 'activo_id', 'fecha_adquisicion', 'fecha_vencimiento', 'cantidad', 'lote', 'precio'
    ];

}

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
        'sucursal_id', 'activo_id', 'cantidad', 'precio', 'lote', 'fecha_adquisicion', 'fecha_vencimiento'
    ];

    /**
     * Inventario correspondiente
     */
    public function inventario()
    {
        return \App\Inventario::where('sucursal_id', $this->sucursal_id)
            ->where('activo_id', $this->activo_id)->first();
    }

}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inventario extends Model
{
    /**
     * The primary key associated with the model.
     *
     * @var array
     */
    protected $primaryKey = ['sucursal_id', 'activo_id'];

    /**
     * Is the primary key an incrementing integer value
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     *
     * @var array
     */
    protected $fillable = [
        'sucursal_id', 'activo_id', 'codigo', 'minimo', 'maximo', 'ubicacion'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sucursal()
    {
        return $this->belongsTo('App\Sucursal');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function activo()
    {
        return $this->belongsTo('App\Activo');
    }

}

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
        'sucursal_id', 'activo_id', 'estado_id', 'ubicacion', 'minimo', 'maximo'
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

    /**
     * Estado del activo en la sucursal correspondiente
     */
    public function estado()
    {
        return $this->belongsTo('App\Estado');
    }

    /**
     * Estado del activo en la sucursal correspondiente
     */
    public function existencias()
    {
        return \App\Existencia::where('sucursal_id', $this->sucursal_id)
            ->where('activo_id', $this->activo_id)->orderBy('fecha_adquisicion')->get();
    }

    /**
     * Asigna las llaves para guardar una consulta de actualizacion
     * Esto es una correción para las tablas con llaves compuestas
     * TODO: Investigar esto más adelante
     * https://github.com/laravel/framework/issues/5355
     * https://github.com/laravel/framework/issues/5517
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function setKeysForSaveQuery(\Illuminate\Database\Eloquent\Builder $query)
    {
        if (is_array($this->primaryKey)) {
            foreach ($this->primaryKey as $pk) {
                $query->where($pk, '=', $this->original[$pk]);
            }
            return $query;
        } else {
            return parent::setKeysForSaveQuery($query);
        }
    }

}

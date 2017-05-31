<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CajaRegistro extends Model
{
    /**
     * @var string
     */
    public $table = 'caja_registro';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = ['sucursal_id', 'stamp'];

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var boolean
     */
    public $timestamps = false;

    /**
     * Obtiene la sucursal correspondiente al registro.
     */
    public function sucursal()
    {
        return $this->belongsTo('App\Sucursal');
    }

    /**
     * Obtiene el usuario correspondiente al registro.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

}

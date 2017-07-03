<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sucursal extends Model
{
    /**
     * @var string
     */
    public $table = 'sucursales';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'display_name', 'telefono', 'direccion',
    ];

    /**
     * Imagen de sucursal
     */
    public function imagen()
    {
        return $this->belongsTo('App\Imagen', 'imagen_id');
    }

    /**
     * Activos de la sucursal
     */
    public function activos()
    {
        return $this->hasMany('App\Activo');
    }

    /**
     * Examenes por sucursal
     */
    public function exams()
    {
        return $this->hasMany('App\Exam');
    }

    /**
     * Transacciones
     */
    public function transactions()
    {
        return $this->hasMany('App\Transaction');
    }

    /**
     * Perfiles asociados
     */
    public function perfiles()
    {
        return $this->belongsToMany('App\Profile', 'profile_sucursal');
    }

    /**
     * Registro de aperturas y cierres de caja.
     */
    public function registro()
    {
        return $this->hasMany('App\CajaRegistro');
    }

}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{

    /**
     * @var string
     */
    public $table = 'clientes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'persona_juridica', 'razon_social', 'dui', 'nit', 'nrc', 'giro', 'telefono', 'direccion', 'descripcion', 'seguro',
    ];

    /**
     * Usuario del cliente
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Relacion de muchos a muchos con Paciente.
     */
    public function pacientes()
    {
        return $this->belongsToMany('App\Paciente');
    }

    /**
     * Obtiene, si corresponde, el registro de centro de centro-origen.
     */
    public function origen()
    {
        return $this->hasOne('App\CentroOrigen', 'id');
    }

}

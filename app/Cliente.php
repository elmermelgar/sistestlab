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
        'persona_juridica', 'centro_origen', 'razon_social', 'dui', 'nit', 'nrc', 'giro', 'telefono',
        'email', 'direccion', 'descripcion',
    ];

    /**
     * Usuario del cliente
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Obtiene, si corresponde, el registro de cliente del usuario.
     */
    public function facturas()
    {
        return $this->hasMany('App\Factura');
    }

    /**
     * Relacion de muchos a muchos con Paciente.
     */
    public function pacientes()
    {
        return $this->belongsToMany('App\Paciente');
    }

}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{

    /**
     * @var string
     */
    public $table='clientes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'documento_identidad', 'razon_social','direccion', 'telefono','user_id',
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

}

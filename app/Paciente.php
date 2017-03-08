<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'documento_identidad', 'nombre', 'apellido', 'fecha_nacimiento', 'direccion', 'telefono',
        'genero', 'email', 'profesion', 'observacion', 'procedencia',
    ];

    /**
     * Devuelve el nombre completo del paciente
     * @return string
     */
    public function getFullName()
    {
        return $this->nombre . ' ' . $this->apellido;
    }

    /**
     * Relacion de muchos a muchos con Cliente.
     */
    public function clientes()
    {
        return $this->belongsToMany('App\Cliente');
    }

}

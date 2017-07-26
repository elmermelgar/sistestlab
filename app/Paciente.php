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
        'dui', 'nombre', 'apellido', 'fecha_nacimiento', 'direccion', 'telefono',
        'sexo', 'email', 'profesion', 'observacion', 'procedencia',
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

    /**
     * Examenes facturados.
     */
    public function examen_paciente()
    {
        return $this->hasMany('App\ExamenPaciente');
    }

    //Busqueda de Pacientes
    public function scopeFilter($query, $nombre)
    {
        if (trim($nombre) != "") {
            $query->where('nombre', "~*", $nombre);
        }
    }

}

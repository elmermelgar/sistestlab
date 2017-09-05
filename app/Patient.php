<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    /**
     * @var string
     */
    public $table = 'patients_vw';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'account_id', 'sucursal_id', 'identity_document', 'first_name', 'last_name', 'phone_number', 'address',
        'birth_date', 'sex', 'profession', 'comment'
    ];

    /**
     * Cuenta del paciente
     */
    public function account()
    {
        return $this->belongsTo('App\Account');
    }

    /**
     * Relacion de muchos a muchos con Cliente.
     */
    public function clients()
    {
        return $this->belongsToMany('App\Client');
    }

    /**
     * Examenes facturados.
     */
    public function examen_paciente()
    {
        return $this->hasMany('App\ExamenPaciente');
    }

    //Busqueda de Pacientes
    public function scopeFilter($query, $name)
    {
        if (trim($name) != "") {
            $query->where('name', "~*", $name);
        }
    }

}

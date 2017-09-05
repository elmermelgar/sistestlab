<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sucursal_id', 'first_name', 'last_name', 'identity_document', 'phone_number', 'address', 'comment'
    ];

    /**
     * Devuelve el nombre completo del usuario
     * @return string
     */
    public function name()
    {
        if ($this->last_name) {
            return $this->first_name . ' ' . $this->last_name;
        }
        return $this->first_name;
    }

    /**
     * Obtiene el usuario si corresponde.
     */
    public function user()
    {
        return $this->hasOne('App\User');
    }

    /**
     * Obtiene la sucursal a la que pertenece el usuario.
     */
    public function sucursal()
    {
        return $this->belongsTo('App\Sucursal');
    }

    /**
     * Obtiene, si corresponde, el registro de cliente del usuario.
     */
    public function cliente()
    {
        return $this->hasOne('App\Customer');
    }

    /**
     * Obtiene, si corresponde, el registro de paciente del usuario.
     */
    public function patient()
    {
        return $this->hasOne('App\Patient');
    }

    /**
     * Obtiene las facturas realizadas por el usuario.
     */
    public function facturas()
    {
        return $this->hasMany('App\Factura');
    }

    /**
     * Obtiene los créditos fiscales otorgados por el usuario.
     */
    public function tax_credits()
    {
        return $this->hasMany('App\TaxCredit');
    }

    /**
     * Obtiene, si corresponde, los examenes validados por un profesional
     */
    public function examen_paciente()
    {
        return $this->hasMany('App\ExamenPaciente');
    }

}

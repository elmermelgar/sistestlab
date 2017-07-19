<?php

namespace App;

use App\Notifications\ResetPassword;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends Authenticatable implements CanResetPassword
{
    use Notifiable;

    use EntrustUserTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'surname', 'email', 'password', 'sucursal_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Devuelve el nombre completo del usuario
     * @return string
     */
    public function getFullName()
    {
        if ($this->surname) {
            return $this->name . ' ' . $this->surname;
        }
        return $this->name;
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
        return $this->hasOne('App\Cliente');
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

    /**
     * Send the password reset notification.
     *
     * @param  string $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }
}

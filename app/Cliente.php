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
        'documento_identidad', 'razon_social','direccion', 'telefono',
    ];

    /**
     * Usuario del cliente
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Many-to-Many relations with Paciente.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function pacientes()
    {
        return $this->belongsToMany('App\Paciente');
    }

}

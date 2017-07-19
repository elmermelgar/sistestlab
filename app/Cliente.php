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
     * Obtiene, si corresponde, las facturas del cliente.
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

    //Busqueda de clientes
    public function scopeFilter($query, $razon_social)
    {
        if (trim($razon_social) != "") {
            $query->where('razon_social', "~*", $razon_social);
        }
    }

}

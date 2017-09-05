<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{

    /**
     * @var string
     */
    public $table = 'customers_vw';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'account_id','sucursal_id', 'identity_document', 'first_name', 'last_name', 'phone_number', 'address',
        'juridical_person', 'origin_center', 'nit', 'nrc', 'business', 'comment',
    ];

    /**
     * Cuenta del cliente
     */
    public function account()
    {
        return $this->belongsTo('App\Account');
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
    public function patients()
    {
        return $this->belongsToMany('App\Patient');
    }

    //Busqueda de clientes
    public function scopeFilter($query, $name)
    {
        if (trim($name) != "") {
            $query->where('name', "~*", $name);
        }
    }

}

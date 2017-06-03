<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'display_name', 'type', 'description', 'enabled'
    ];

    //Busqueda de Perfiles
    public function scopeFilter($query, $name)
    {
        if (trim($name) != "") {
            $query->where('display_name', "~*", $name);
        }

    }

    /**
     * Examenes asociados
     */
    public function exams()
    {
        return $this->belongsToMany('App\Exam');
    }

    /**
     * Facturas asociadas
     */
    public function invoices()
    {
        return $this->hasMany('App\InvoiceProfile');
    }

    /**
     * Sucursales asociadas
     */
    public function sucursales()
    {
        return $this->belongsToMany('App\Sucursal', 'profile_sucursal')->withPivot('price');
    }

}

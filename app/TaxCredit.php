<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaxCredit extends Model
{
    /**
     * @var string
     */
    public $table = 'tax_credits';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'numero', 'total', 'closed',
    ];

    /**
     * Obtiene, si corresponde, el registro de cliente del usuario.
     */
    public function facturas()
    {
        return $this->hasMany('App\Factura');
    }

    /**
     * Usuario que otorga el crédito fiscal
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    //Busqueda de créditos fiscales
    public function scopeFilter($query, $numero)
    {
        if (trim($numero) != "") {
            $query->where('numero', "~*", $numero);
        }
    }


}

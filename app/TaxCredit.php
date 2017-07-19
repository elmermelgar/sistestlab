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

}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvoiceProfile extends Model
{

    /**
     * @var string
     */
    public $table = 'invoice_profile';

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
        'factura_id', 'profile_id', 'price'
    ];

    /**
     * Facturas
     */
    public function factura()
    {
        return $this->belongsTo('App\Factura');
    }

    /**
     * Perfiles
     */
    public function profile()
    {
        return $this->belongsTo('App\Profile');
    }

    /**
     * Examenes facturados.
     */
    public function examen_paciente()
    {
        return $this->hasMany('App\ExamenPaciente');
    }

}

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
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'factura_id', 'profile_id',
    ];

    /**
     * Facturas
     */
    public function facturas()
    {
        return $this->belongsTo('App\Factura');
    }

    /**
     * Perfiles
     */
    public function profiles()
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

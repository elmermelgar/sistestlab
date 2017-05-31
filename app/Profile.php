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
        'name', 'display_name', 'price', 'description',
    ];

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

}

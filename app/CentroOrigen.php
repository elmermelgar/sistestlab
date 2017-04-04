<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CentroOrigen extends Model
{
    /**
     * @var string
     */
    public $table = 'centro_origen';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','display_name','email'
    ];

    /**
     * Cliente del centro de centro-origen
     */
    public function cliente()
    {
        return $this->belongsTo('App\Cliente','id');
    }
}

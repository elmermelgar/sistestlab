<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Spermogram extends Model
{
    /**
     * @var string
     */
    protected $table='spermogram_modality';

    /**
     *
     * @var array
     */
    protected $fillable = ['name'];

    /**
     * @var boolean
     */
    public $timestamps=false;

    public function activos(){
        return $this->hasMany('App\Results');
    }
}

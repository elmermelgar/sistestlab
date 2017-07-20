<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Antibiotico extends Model
{
    /**
     * @var string
     */
    protected $table='antibioticos';

    /**
     *
     * @var array
     */
    protected $fillable = ['name'];

    /**
     * @var boolean
     */
    public $timestamps=false;

    /**
     * Registros de Antibioticos
     */
    public function register_antibioticos(){
        return $this->hasMany('App\Register_antibiotico');
    }
}

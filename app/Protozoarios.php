<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Protozoarios extends Model
{
    /**
     * @var string
     */
    protected $table='protozoarios_type';

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

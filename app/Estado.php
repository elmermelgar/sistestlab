<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{
    /**
     * @var string
     */
    protected $table='estados';

    /**
     *
     * @var array
     */
    protected $fillable = ['name', 'display_name', 'tipo'];

    /**
     * @var boolean
     */
    public $timestamps=false;

    public function activos(){
        return $this->hasMany('App\Activo');
    }

    public function exams(){
        return $this->hasMany('App\Exam');
    }
}

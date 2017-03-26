<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sample extends Model
{
    /**
     * @var string
     */
    protected $table='samples';

    /**
     *
     * @var array
     */
    protected $fillable = ['name', 'display_name', 'description'];

    /**
     * @var boolean
     */
    public $timestamps=true;


    public function exams(){
        return $this->hasMany('App\Exam');
    }
}

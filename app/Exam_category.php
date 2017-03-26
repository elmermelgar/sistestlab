<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exam_category extends Model
{
    /**
     * @var string
     */
    protected $table='exam_categories';

    /**
     *
     * @var array
     */
    protected $fillable = ['name', 'description'];

    /**
     * @var boolean
     */
    public $timestamps=true;


    public function exams(){
        return $this->hasMany('App\Exam');
    }
}

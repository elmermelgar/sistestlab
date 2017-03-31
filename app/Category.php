<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
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


    public function exams(){
        return $this->hasMany('App\Exam');
    }
}

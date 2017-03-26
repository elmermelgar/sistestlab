<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Grouping extends Model
{
    /**
     * @var string
     */
    protected $table='groupings';

    /**
     *
     * @var array
     */
    protected $fillable = ['name', 'display_name'];

    /**
     * @var boolean
     */
    public $timestamps=true;


    public function exam(){
        return $this->belongsTo('App\Exam');
    }

    public function exam_details(){
        return $this->hasMany('App\Exam_detail');
    }
}

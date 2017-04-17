<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReferenceType extends Model
{
    /**
     * @var string
     */
    protected $table='reference_type';

    /**
     *
     * @var array
     */
    protected $fillable = ['name', 'display_name'];

    /**
     * @var boolean
     */
    public $timestamps=false;

    public function exam_details(){
        return $this->hasMany('App\Exam_detail');
    }

}

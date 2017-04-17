<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exam_detail extends Model
{
    /**
     * @var string
     */
    protected $table='exam_details';

    /**
     *
     * @var array
     */
    protected $fillable = ['name_detail', 'description', 'estado', 'grouping_id', 'reference_type_id'];

    /**
     * @var boolean
     */
    public $timestamps=true;

    public function grouping(){
        return $this->belongsTo('App\Grouping');
    }

    public function referenceType(){
        return $this->belongsTo('App\ReferenceType');
    }

    public function reference_values(){
        return $this->hasMany('App\Reference_value');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exam_detail extends Model
{
    /**
     * @var string
     */
    protected $table='exam_detail';

    /**
     *
     * @var array
     */
    protected $fillable = ['name_detail', 'tipo_vr', 'unidades', 'description',  'grouping_id', 'estado_id'];

    /**
     * @var boolean
     */
    public $timestamps=true;

    public function grouping(){
        return $this->belongsTo('App\Grouping');
    }

    public function estado(){
        return $this->belongsTo('App\Estado');
    }

    public function reference_values(){
        return $this->hasMany('App\Reference_value');
    }

    public function special_results(){
        return $this->hasMany('App\Special_result');
    }
}

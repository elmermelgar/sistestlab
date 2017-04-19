<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reference_value extends Model
{
    /**
     * @var string
     */
    protected $table='reference_values';

    /**
     *
     * @var array
     */
    protected $fillable = ['value', 'unidades', 'gender', 'edad_menor', 'edad_mayor', 'exam_detail_id'];

    /**
     * @var boolean
     */
    public $timestamps=true;

    public function exam_detail(){
        return $this->belongsTo('App\Exam_detail');
    }

}

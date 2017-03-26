<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Special_result extends Model
{
    /**
     * @var string
     */
    protected $table='special_results';

    /**
     *
     * @var array
     */
    protected $fillable = ['special_value', 'description'];

    /**
     * @var boolean
     */
    public $timestamps=true;

    public function exam_detail(){
        return $this->belongsTo('App\Exam_detail');
    }

}

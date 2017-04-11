<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    /**
     * @var string
     */
    protected $table='exams';

    /**
     *
     * @var array
     */
    protected $fillable = ['name', 'display_name', 'precio', 'material_directo', 'mano_obra', 'cif', 'observation', 'sucursal_id', 'sample_id', 'exam_category_id', 'estado_id'];

    /**
     * @var boolean
     */
    public $timestamps=true;

    public function groupings(){
        return $this->hasMany('App\Grouping');
    }
    public function exam_category(){
        return $this->belongsTo('App\Exam_category');
    }

    public function sample(){
        return $this->belongsTo('App\Sample');
    }

    public function estado(){
        return $this->belongsTo('App\Estado');
    }

    public function sucursal(){
        return $this->belongsTo('App\Sucursal');
    }


}

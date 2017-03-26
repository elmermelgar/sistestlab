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
    protected $fillable = ['name', 'display_name', 'precio', 'material_directo', 'mano_obra', 'cif', 'observation', 'sucursal_id', 'sample_id', 'exam_category_id'];

    /**
     * @var boolean
     */
    public $timestamps=true;

    public function category(){
        return $this->belongsTo('App\Exam_category');
    }

    public function samples(){
        return $this->belongsTo('App\Sample');
    }

    public function sucursal(){
        return $this->belongsTo('App\Sucursal');
    }

    public function groupings(){
        return $this->hasMany('App\Grouping');
    }
}

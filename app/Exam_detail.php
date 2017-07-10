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
    /**
     * Grupo al que pertenece
     */
    public function grouping(){
        return $this->belongsTo('App\Grouping');
    }
    /**
     * Tipo de resultado
     */
    public function referenceType(){
        return $this->belongsTo('App\ReferenceType');
    }
    /**
     * Valores de referencia
     */
    public function reference_values(){
        return $this->hasMany('App\Reference_value');
    }
    /**
     * Resultados del examen
     */
    public function results(){
        return $this->hasMany('App\Results');
    }

    /**
     * Examenes pacientes asociados
     */
    public function examenes_pacientes()
    {
        return $this->belongsToMany('App\ExamenPaciente', 'results');
    }
}

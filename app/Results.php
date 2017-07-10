<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Results extends Model
{
    /**
     * @var string
     */
    public $table = 'results';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'exam_detail_id', 'examen_paciente_id', 'result', 'observation', 'protozoarios_type_id', 'spermogram_modality_id'
    ];

    /**
     * Detalles de Examenes
     */
    public function exam_detail()
    {
        return $this->belongsTo('App\Exam_detail');
    }

    /**
     * Examenes facturados.
     */
    public function examen_paciente()
    {
        return $this->hasMany('App\ExamenPaciente');
    }

    /**
     * Tipos de Protozoarios
     */
    public function protozoarios_type()
    {
        return $this->belongsTo('App\Protozoarios');
    }

    /**
     * Modalidad del Espermograma
     */
    public function spermogram_modality()
    {
        return $this->belongsTo('App\Spermogram');
    }
}

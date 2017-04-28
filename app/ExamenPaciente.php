<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExamenPaciente extends Model
{
    /**
     * @var string
     */
    public $table = 'examen_paciente';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'exam_id', 'factura_id', 'paciente_id', 'profesional_id', 'paciente_nombre', 'paciente_genero', 'paciente_edad',
        'numero_boleta', 'medico', 'observacion',
    ];

    /**
     * Examen
     */
    public function exam()
    {
        return $this->belongsTo('App\Exam');
    }

    /**
     * Factura del examen
     */
    public function factura()
    {
        return $this->belongsTo('App\Factura');
    }

    /**
     * Paciente del examen
     */
    public function paciente()
    {
        return $this->belongsTo('App\Paciente');
    }


}

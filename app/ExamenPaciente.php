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
        'exam_id', 'invoice_profile_id', 'paciente_id', 'profesional_id', 'paciente_nombre', 'paciente_sexo', 'paciente_edad',
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
     * Paciente del examen
     */
    public function paciente()
    {
        return $this->belongsTo('App\Paciente');
    }

    /**
     * Estado del Examen_Paciente
     */
    public function estado()
    {
        return $this->belongsTo('App\Estado');
    }

    /**
     * Facturas
     */
    public function invoices()
    {
        return $this->belongsTo('App\InvoiceProfile', 'invoice_profile_id');
    }

    /**
     * Profesional
     */
    public function profesional()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Detalles de Examenes asociados
     */
    public function detalles()
    {
        return $this->belongsToMany('App\Exam_detail', 'results')->withPivot(['result', 'observation', 'protozoarios_type_id', 'spermogram_modality_id']);
    }
    /**
     * Registro de Antibioticos
     */
    public function registro_antibioticos(){
        return $this->hasMany('App\Register_antibiotico');
    }

}

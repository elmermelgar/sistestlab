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
        'exam_id', 'invoice_profile_id', 'paciente_id', 'profesional_id', 'paciente_nombre', 'paciente_genero', 'paciente_edad',
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


}

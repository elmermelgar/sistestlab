<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Register_antibiotico extends Model
{
    /**
     * @var string
     */
    protected $table='register_antibiotico';

    /**
     *
     * @var array
     */
    protected $fillable = ['examen_paciente_id', 'antibiotico_id', 'antibiotico_type_id'];

    /**
     * @var boolean
     */
    public $timestamps=false;

    /**
     * Lista de Antibioticos
     */
    public function antibiotico(){
        return $this->belongsTo('App\Antibiotico');
    }
    /**
     * Tipo de estados de los antibioticos
     */
    public function antibiotico_type(){
        return $this->belongsTo('App\Antibiotico_type');
    }
}

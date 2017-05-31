<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    /**
     * @var string
     */
    protected $table = 'exams';

    /**
     *
     * @var array
     */
    protected $fillable = [
        'name', 'display_name', 'precio', 'material_directo', 'mano_obra', 'cif', 'observation',
        'sucursal_id', 'sample_id', 'exam_category_id', 'estado_id'
    ];

    /**
     * @var boolean
     */
    public $timestamps = true;

    public function groupings()
    {
        return $this->hasMany('App\Grouping');
    }

    public function exam_category()
    {
        return $this->belongsTo('App\Exam_category');
    }

    public function sample()
    {
        return $this->belongsTo('App\Sample');
    }

    public function estado()
    {
        return $this->belongsTo('App\Estado');
    }

    public function sucursal()
    {
        return $this->belongsTo('App\Sucursal');
    }

    /**
     * Relacion de muchos a muchos con Activo.
     */
    public function activos()
    {
        return $this->belongsToMany('App\Activo', 'exam_activo');
    }

    //Busqueda de Examenes
    public function scopeName($query, $name)
    {
        if (trim($name) != "") {
            $query->where('display_name', "LIKE", "%$name%");
        }

    }

    /**
     * Examenes facturados.
     */
    public function examen_paciente()
    {
        return $this->hasMany('App\ExamenPaciente');
    }

    /**
     * Perfiles de examenes asociados
     */
    public function profiles()
    {
        return $this->belongsToMany('App\Profile');
    }

}

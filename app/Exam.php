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
     * @var array
     */
    protected $fillable = [
        'name', 'display_name', 'precio', 'material_directo', 'mano_obra', 'cif', 'observation',
        'sample_id', 'exam_category_id', 'estado_id'
    ];

    /**
     * @var boolean
     */
    public $timestamps = true;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function groupings()
    {
        return $this->hasMany('App\Grouping');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function exam_category()
    {
        return $this->belongsTo('App\Exam_category');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sample()
    {
        return $this->belongsTo('App\Sample');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function estado()
    {
        return $this->belongsTo('App\Estado');
    }

    /**
     * Relacion de muchos a muchos con Activo.
     */
    public function activos()
    {
        return $this->belongsToMany('App\Activo', 'exam_activo')->withPivot(['cantidad']);
    }

    //Busqueda de Examenes por nombre
    public function scopeFilter($query, $name)
    {
        if (trim($name) != "") {
            $query->where('display_name', "~*", $name);
        }
    }
    //Busqueda de Examenes por Categoria
    public function scopeCategory($query, $cat)
    {
        if (trim($cat) != 0) {
            $query->where('exam_category_id', "=", $cat);
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

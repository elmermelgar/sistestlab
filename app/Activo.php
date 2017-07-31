<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activo extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     *
     * @var array
     */
    protected $fillable = [
        'proveedor_id', 'nombre', 'tipo', 'marca', 'modelo', 'serie', 'unidades', 'observacion',
    ];

    /**
     * Código del activo
     * @return string
     */
    public function codigo()
    {
        return $this->id . ' - ' . \Carbon\Carbon::createFromFormat('Y-m-d', $this->fecha)->format('d/m/Y');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function proveedor()
    {
        return $this->belongsTo('App\Proveedor');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function inventarios()
    {
        return $this->hasMany('App\Inventario');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function exams()
    {
        return $this->belongsToMany('App\Exam', 'exam_activo');
    }

}

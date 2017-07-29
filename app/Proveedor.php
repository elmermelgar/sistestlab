<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    /**
     * @var string
     */
    protected $table = 'proveedores';

    /**
     * @var boolean
     */
    public $timestamps = false;

    /**
     *
     * @var array
     */
    protected $fillable = ['nombre', 'telefono', 'rubro', 'ubicacion', 'email', 'otros'];

    /**
     * Activos que provee
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function activos()
    {
        return $this->hasMany('App\Activo');
    }

}

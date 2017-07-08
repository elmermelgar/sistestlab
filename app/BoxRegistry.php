<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BoxRegistry extends Model
{
    /**
     * @var string
     */
    public $table = 'box_registry';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = ['sucursal_id', 'date', 'time'];

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sucursal_id', 'user_id', 'state', 'cash', 'debit', 'debt'
    ];

    /**
     * @var boolean
     */
    public $timestamps = false;

    /**
     * Obtiene la sucursal correspondiente al registro.
     */
    public function sucursal()
    {
        return $this->belongsTo('App\Sucursal');
    }

    /**
     * Obtiene el usuario correspondiente al registro.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

}

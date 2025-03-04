<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Estacion extends Model
{
    
    protected $table='estacion';

    protected $fillable = [
        'nombre',
        'telefono',
        'latitude',
        'longitude',
        'id_direccion',
    ];

    public function direccion()
    {
        return $this->belongsTo(Direccion::class, 'id_direccion');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'id_estacion');
    }

}

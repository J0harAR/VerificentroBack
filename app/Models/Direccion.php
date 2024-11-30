<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Direccion extends Model
{
    
    protected $table='direccion';

    protected $fillable = [
        'calle',
        'numero_exterior',
        'numero_interior',
        'colonia',
        'codigo_postal',
        'localidad',
        'municipio',
        'entidad_federativa',
        'entre_calles',
    ];
}

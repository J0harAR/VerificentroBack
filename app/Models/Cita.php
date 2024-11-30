<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cita extends Model
{
    protected $table='cita';

    protected $fillable = [
        'folio',
        'estado',
        'hora',
        'fecha',
        'tipo',
        'id_solicitante',
        'id_estacion',
        'id_vehiculo'
    ];

    public function solicitante()
    {
        return $this->belongsTo(Solicitante::class, 'id_solicitante', 'curp');
    }


    public function estacion()
    {
        return $this->belongsTo(Estacion::class, 'id_estacion');
    }

    public function vehiculo()
    {
        return $this->belongsTo(Vehiculo::class, 'id_vehiculo','placa');
    }
}

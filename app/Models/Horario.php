<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    protected $table = 'horario';
    protected $fillable = ['id_dia', 'hora_inicio', 'hora_fin'];

    public function dia()
    {
        return $this->belongsTo(Dia::class, 'id_dia');
    }

    public function estaciones()
    {
        return $this->belongsToMany(Estacion::class, 'horario_estacion', 'id_horario', 'id_estacion');
    }
}

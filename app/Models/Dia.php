<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dia extends Model
{
    protected $table = 'dia';
    protected $fillable = ['dia'];

    public function horarios()
    {
        return $this->hasMany(Horario::class, 'id_dia');
    }
}

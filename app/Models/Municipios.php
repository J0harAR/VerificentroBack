<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Municipios extends Model
{
    protected $table='municipalities';

    public function estado()
    {
        return $this->belongsTo(Estados::class, 'id_state', 'id');
    }
    
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Estados extends Model
{
    protected $table='states';

    
    public function municipios()
    {
        return $this->hasMany(Municipios::class, 'id_state', 'id');
    }
    
}

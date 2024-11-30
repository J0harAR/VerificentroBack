<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Solicitante extends Model
{
    protected $table='solicitante';

   protected $keyType = 'string';
   protected $primaryKey = 'curp';
   
  public $incrementing = false;
  
   protected $fillable=[
    'curp',
    'nombre',
    'apellido_p',
    'apellido_m',
    'celular',
    'correo',
    'regimen',
   ];

   public function vehiculos()
    {
        return $this->hasMany(Vehiculo::class, 'id_solicitante', 'curp');
    }
}

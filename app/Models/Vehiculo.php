<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehiculo extends Model
{
   protected $table='vehiculo';

   protected $keyType = 'string';
   protected $primaryKey = 'placa';
   
public $incrementing = false;
   protected $fillable=[
    'placa',
    'vin',
    'modelo',
    'marca',
    'año',
    'estado',
    'tipo_combustible',
    'curp',
    'id_solicitante',
   ];
   public function solicitante()
   {
    return $this->belongsTo(Solicitante::class, 'id_solicitante', 'curp');
   }
}

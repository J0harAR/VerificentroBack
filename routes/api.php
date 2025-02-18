<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\VehiculoController;
use App\Http\Controllers\Api\SolicitanteController;
use App\Http\Controllers\Api\EstadoController;
use App\Http\Controllers\Api\EstacionController;
use App\Http\Controllers\Api\CitasController;
use App\Http\Controllers\Api\Auth\AuthController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('signup', [AuthController::class, 'signUp']);
  
    Route::group([
      'middleware' => 'auth:api'
    ], function() {
        Route::get('logout', [AuthController::class, 'logout']);
        Route::get('user', [AuthController::class, 'user']);
        
    });
});


Route::middleware('client')->group(function () {
    Route::get('/vehiculos',[VehiculoController::class,'index']);
});
//Rutas para los vehiculos
Route::post('/vehiculo',[VehiculoController::class,'store']);
Route::get('/vehiculo/{placa}',[VehiculoController::class,'show']);
Route::put('/vehiculo/{placa}',[VehiculoController::class,'update']);
Route::delete('/vehiculo/{placa}',[VehiculoController::class,'destroy']);
Route::get('/vehiculos/estado/{estado}',[VehiculoController::class,'filtrarPorEstado']);

//Rutas para solicitantes
Route::get('/solicitantes',[SolicitanteController::class,'index']);
Route::post('/solicitante',[SolicitanteController::class,'store']);
Route::get('/solicitante/{id_solicitante}',[SolicitanteController::class,'show']);
Route::put('/solicitante/{id_solicitante}',[SolicitanteController::class,'update']);
Route::delete('/solicitante/{id_solicitante}',[SolicitanteController::class,'destroy']);

//Rutas para filtrar los datos por municipio
Route::get('/estados',[EstadoController::class,'index']);
Route::get('/estados/{id_estado}/municipios',[EstadoController::class,'getMunicipios']);

//Rutas para estaciones

Route::get('/estaciones',[EstacionController::class,'index']);
Route::post('/estacion',[EstacionController::class,'store']);
Route::get('/estacion/{id_estacion}',[EstacionController::class,'show']);
Route::put('/estacion/{id_estacion}',[EstacionController::class,'update']);
Route::delete('/estacion/{id_estacion}',[EstacionController::class,'destroy']);

//Ruta para citas
Route::get('/citas',[CitasController::class,'index']);
Route::get('/citas/buscar',[CitasController::class,'filtrarCitas']);
Route::post('/cita',[CitasController::class,'store']);
Route::get('/cita',[CitasController::class,'show']);
Route::get('/cita/verificar',[CitasController::class,'verificarCita']);
Route::get('/citas/{fecha}/horas-disponibles',[CitasController::class,'getHorasDisponibles']);

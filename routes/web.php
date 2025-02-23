<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\RolController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\CitasController;
use App\Http\Controllers\EstacionesController;
use App\Http\Controllers\ClientesController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'root'])->name('root');


//Usuario y Roles 
Route::group(['middleware' => ['auth']], function () {
    //Roles

    Route::resource('roles', RolController::class);
    //Usuarios
    Route::resource('usuarios', UsuarioController::class);

    Route::get('/citas',[CitasController::class,'index'])->name('citas.index');
    Route::put('/cita/{id}',[CitasController::class,'update'])->name('citas.update');
    Route::delete('/cita/{id}',[CitasController::class,'destroy'])->name('citas.destroy');
    Route::post('/cita/{id}/aviso',[CitasController::class,'sendMail'])->name('citas.aviso');
    Route::put('/cita/{id}/finalizar',[CitasController::class,'changeStatus'])->name('citas.finalizar');
   
    Route::get('/clientes',[ClientesController::class,'index'])->name('clientes.index');

    //Estaciones
    Route::resource('estaciones', EstacionesController::class);
    Route::get('/estados/{id_estado}/municipios',[EstacionesController::class,'getMunicipios']);
});


//Update User Details
Route::post('/update-profile/{id}', [App\Http\Controllers\HomeController::class, 'updateProfile'])->name('updateProfile');
Route::post('/update-password/{id}', [App\Http\Controllers\HomeController::class, 'updatePassword'])->name('updatePassword');

Route::get('{any}', [App\Http\Controllers\HomeController::class, 'index'])->name('index');

//Language Translation
Route::get('index/{locale}', [App\Http\Controllers\HomeController::class, 'lang']);




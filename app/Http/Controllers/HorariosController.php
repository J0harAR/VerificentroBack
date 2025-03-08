<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Horario;
use App\Models\Dia;
use Illuminate\Support\Facades\Auth;
class HorariosController extends Controller
{
    
    public function index(){

        $user=Auth::user();
        $horarios = $user->estacion->horarios;

        $dias=Dia::all();

        return view('sistema.horarios.index',compact('horarios','dias'));
    }


    public function store(Request $request){
        

        $validated = $request->validate([
            'dia'=>'required',
            'hora_inicio'=>'date_format:H:i',
            'hora_fin'=>'date_format:H:i|after:hora_inicio',
        ]);

        $user=Auth::user();

        $estacion=$user->estacion;

       
        
        $horario=Horario::create([
            'id_dia'=>$request->input('dia'),
            'hora_inicio'=>$request->input('hora_inicio'),
            'hora_fin'=>$request->input('hora_fin'),
        ]);

        $estacion->horarios()->attach($horario->id);
        return redirect()->route('horarios.index')->with('success', 'Horario creado correctamente');
    }
}

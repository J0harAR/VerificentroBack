<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Solicitante;
use Illuminate\Support\Facades\Validator;

class SolicitanteController extends Controller
{
    
    public function index(){
        $solicitantes=Solicitante::all();

        if($solicitantes->isEmpty()){
            $data=[
                'message'=>'No hay solicitantes registrados',
                'status'=>200,
            ];
            return response()->json($data,200);
        }
        $data=[
            'solicitantes'=>$solicitantes,
            'status'=>200,
        ];
        return response()->json($data,200);

    }
    public function store(Request $request){
        
        $validator = Validator::make($request->all(),[
             'curp'=>'required|unique:solicitante',
             'nombre'=>'required',
             'apellido_p'=>'required',
             'apellido_m'=>'required',
             'celular'=>'required|size:10',
             'correo'=>'required',
             'regimen'=>'required',
         ]);
 
         if($validator->fails()){
             $data=[
                 'message'=>'Error en la validacion de los datos',
                 'errors'=>$validator->errors(),
                 'status'=>400,
             ];
             return response()->json($data,400);
 
         }
         $solicitante=Solicitante::create([
             'curp'=>$request->curp,
             'nombre'=>$request->nombre,
             'apellido_p'=>$request->apellido_p,
             'apellido_m'=>$request->apellido_m,
             'celular'=>$request->celular,
             'correo'=>$request->correo,
             'regimen'=>$request->regimen,
         ]);
 
         if(!$solicitante){
 
             $data=[
                 'message'=>'Error al crear el solicitante',
                 'errors'=>$validator->errors(),
                 'status'=>500,
             ];
             return response()->json($data,500);
 
         }
 
         $data=[
             'solicitante'=>$solicitante,
             'status'=>201,
         ];
 
         return response()->json($data,201);
 
     }

     public function show($id_solicitante){
        $solicitante = Solicitante::find($id_solicitante);

        if(!$solicitante){
            $data=[
                'message'=>'No se encontro el solicitante',
                'status'=>404,
            ];
            return response()->json($data,404);           
        }   
        $solicitante->vehiculos;

        $data=[
            'solicitante'=>$solicitante,
            'status'=>200,
        ];
        return response()->json($data,200);  

    }

    public function update(Request $request,$id_solicitante){

        $solicitante = Solicitante::find($id_solicitante);
        
        if(!$solicitante){
            $data=[
                'message'=>'No se encontro el solicitante',
                'status'=>404,
            ];
            return response()->json($data,404);           
        }
        
        $validator = Validator::make($request->all(),[
            'nombre'=>'required',
            'apellido_p'=>'required',
            'apellido_m'=>'required',
            'celular'=>'required|size:10',
            'correo'=>'required',
            'regimen'=>'required',
        ]);

        if($validator->fails()){
            $data=[
                'message'=>'Error en la validacion de los datos',
                'errors'=>$validator->errors(),
                'status'=>400,
            ];
            return response()->json($data,400);

        }

        $solicitante->nombre = $request->nombre;
        $solicitante->apellido_p = $request->apellido_p;
        $solicitante->apellido_m = $request->apellido_m;
        $solicitante ->celular=$request->celular;
        $solicitante ->correo=$request->correo;
        $solicitante -> regimen=$request->regimen;

        // Guardar los cambios
        $solicitante->save();

        $data=[
            'solicitante'=>$solicitante,
            'status'=>200,
        ];

        return response()->json($data,200);

    }

    public function destroy($id_solicitante){

        $solicitante = Solicitante::find($id_solicitante);
        
        if(!$solicitante){
            $data=[
                'message'=>'No se encontro el solicitante',
                'status'=>404,
            ];
            return response()->json($data,404);           
        }
        $solicitante->delete();

        $data=[
            'message'=>'Solicitante eliminado correctamente',
            'status'=>200,
        ];
        return response()->json($data,200);

    }


}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vehiculo;
use Illuminate\Support\Facades\Validator;

class VehiculoController extends Controller
{
    public function index(){
        $vehiculos=Vehiculo::with('solicitante')->get();

        if($vehiculos->isEmpty()){
            $data=[
                'message'=>'No hay vehiculos registrados',
                'status'=>200,
            ];
            return response()->json($data,200);
        }
        $data=[
            'vehiculos'=>$vehiculos,
            'status'=>200,
        ];
        return response()->json($data,200);

    }

    public function store(Request $request){
       $validator = Validator::make($request->all(),[
            'placa'=>'required|unique:vehiculo',
            'vin'=>'required',
            'modelo'=>'required',
            'marca'=>'required',
            'año'=>'required',
            'estado'=>'required',
            'tipo_combustible'=>'required',
            'id_solicitante'=>'required|exists:solicitante,curp'
        ]);

        if($validator->fails()){
            $data=[
                'message'=>'Error en la validacion de los datos',
                'errors'=>$validator->errors(),
                'status'=>400,
            ];
            return response()->json($data,400);

        }
        $vehiculo=Vehiculo::create([
            'placa'=>$request->placa,
            'vin'=>$request->vin,
            'modelo'=>$request->modelo,
            'marca'=>$request->marca,
            'año'=>$request->año,
            'estado'=>$request->estado,
            'tipo_combustible'=>$request->tipo_combustible,
            'id_solicitante'=>$request->id_solicitante,
        ]);

        if(!$vehiculo){

            $data=[
                'message'=>'Error al crear el vehiculo',
                'errors'=>$validator->errors(),
                'status'=>500,
            ];
            return response()->json($data,500);

        }
        $vehiculo->solicitante;
        $data=[
            'vehiculo'=>$vehiculo,
            'status'=>201,
        ];

        return response()->json($data,201);

    }

    public function show($placa){
        $vehiculo = Vehiculo::find($placa);

        if(!$vehiculo){
            $data=[
                'message'=>'No se encontro el vehiculo',
                'status'=>404,
            ];
            return response()->json($data,404);           
        }
        $vehiculo->solicitante;
        $data=[
            'vehiculo'=>$vehiculo,
            'status'=>200,
        ];
        return response()->json($data,200);  

    }


    public function update(Request $request,$placa){

        $vehiculo = Vehiculo::find($placa);
        
        if(!$vehiculo){
            $data=[
                'message'=>'No se encontro el vehiculo',
                'status'=>404,
            ];
            return response()->json($data,404);           
        }
        
        $validator = Validator::make($request->all(),[
            'vin'=>'required',
            'modelo'=>'required',
            'marca'=>'required',
            'año'=>'required',
            'estado'=>'required',
            'tipo_combustible'=>'required',
            'id_solicitante'=>'required|exists:solicitante,curp'
        ]);

        if($validator->fails()){
            $data=[
                'message'=>'Error en la validacion de los datos',
                'errors'=>$validator->errors(),
                'status'=>400,
            ];
            return response()->json($data,400);

        }

        $vehiculo->vin = $request->vin;
        $vehiculo->modelo = $request->modelo;
        $vehiculo->marca = $request->marca;
        $vehiculo->año = $request->año;
        $vehiculo->estado = $request->estado;
        $vehiculo->tipo_combustible = $request->tipo_combustible;
        $vehiculo->id_solicitante=$request->id_solicitante;

        // Guardar los cambios
        $vehiculo->save();
        $vehiculo->solicitante;
        $data=[
            'vehiculo'=>$vehiculo,
            'status'=>200,
        ];

        return response()->json($data,200);

    }

    public function destroy($placa){

        $vehiculo = Vehiculo::find($placa);
        
        if(!$vehiculo){
            $data=[
                'message'=>'No se encontro el vehiculo',
                'status'=>404,
            ];
            return response()->json($data,404);           
        }
        $vehiculo->delete();

        $data=[
            'message'=>'Vehiculo eliminado correctamente',
            'status'=>200,
        ];
        return response()->json($data,200);

    }

    public function filtrarPorEstado($estado){

        $vehiculos = Vehiculo::where('estado', $estado)
        ->with('solicitante') 
        ->get();

        if($vehiculos->isEmpty()){
            $data=[
                'message'=>'No hay vehiculos registrados',
                'status'=>200,
            ];
            return response()->json($data,200);
        }
       
        $data=[
            'vehiculos'=>$vehiculos,
            'status'=>200,
        ];
        return response()->json($data,200);

    }

}

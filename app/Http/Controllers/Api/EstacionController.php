<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Estacion;
use App\Models\Direccion;
use Illuminate\Support\Facades\Validator;
class EstacionController extends Controller
{
   
    public function index(){
        $estaciones = Estacion::with('direccion')->get();
        if($estaciones->isEmpty()){
            $data=[
                'message'=>'No hay estaciones registradas',
                'status'=>200,
            ];
            return response()->json($data,200);

        }
       
        $data=[
            'estaciones'=>$estaciones,
            'status'=>200
        ];

        return response()->json($data,200);
    }

    public function store(Request $request) {

        $validator = Validator::make($request->all(),[
            'nombre'=>'required|unique:estacion',
            'telefono'=>'required|size:10',
            'latitude'=>'required',
            'longitude'=>'required',
            'calle'=>'required',   
            'numero_exterior'=>'required',   
            'numero_interior'=>'required',   
            'colonia'=>'required',   
            'codigo_postal'=>'required',          
            'localidad'=>'required',   
            'municipio'=>'required',   
            'entidad_federativa'=>'required',
            'entre_calles'=>'required',   
        ]);

        if($validator->fails()){
            $data=[
                'message'=>'Error en la validacion de los datos',
                'errors'=>$validator->errors(),
                'status'=>400,
            ];
            return response()->json($data,400);

        }
        
        $direccion=Direccion::create([
            'calle'=>$request->calle,
            'numero_exterior'=>$request->numero_exterior,
            'numero_interior'=>$request->numero_interior,
            'colonia'=>$request->colonia,
            'codigo_postal'=>$request->codigo_postal,
            'localidad'=>$request->localidad,
            'municipio'=>$request->municipio,
            'entidad_federativa'=>$request->entidad_federativa,
            'entre_calles'=>$request->entre_calles,
        ]);

        if(!$direccion){
 
            $data=[
                'message'=>'Error al crear la direccion',
                'errors'=>$validator->errors(),
                'status'=>500,
            ];
            return response()->json($data,500);

        }

        $estacion=Estacion::create([
            'nombre'=>$request->nombre,
            'telefono'=>$request->telefono,
            'latitude'=>$request->latitude,
            'longitude'=>$request->longitude,
            'id_direccion'=>$direccion->id,          
        ]);

        if(!$estacion){
 
            $data=[
                'message'=>'Error al crear la estacion',
                'errors'=>$validator->errors(),
                'status'=>500,
            ];
            return response()->json($data,500);

        }
        $estacion->direccion;
        $data=[
            'estacion'=>$estacion,       
            'status'=>201
        ];
        return response()->json($data,201);
        
    }

    public function show($id_estacion){
        $estacion = Estacion::find($id_estacion);

        if(!$estacion){
            $data=[
                'message'=>'No se encontro la estacion',
                'status'=>404,
            ];
            return response()->json($data,404);           
        }
       $estacion->direccion;

        $data=[
            'estacion'=>$estacion,          
            'status'=>200,
        ];
        return response()->json($data,200); 
    }

    public function update(Request $request,$id_estacion){

        $estacion = Estacion::find($id_estacion);
        
        if(!$estacion){
            $data=[
                'message'=>'No se encontro la estacion',
                'status'=>404,
            ];
            return response()->json($data,404);           
        }
        
        $validator = Validator::make($request->all(),[
            'telefono'=>'required|size:10',
            'latitude'=>'required',
            'longitude'=>'required',
            'calle'=>'required',   
            'numero_exterior'=>'required',   
            'numero_interior'=>'required',   
            'colonia'=>'required',   
            'codigo_postal'=>'required',          
            'localidad'=>'required',   
            'municipio'=>'required',   
            'entidad_federativa'=>'required',
            'entre_calles'=>'required',   
        ]);

        if($validator->fails()){
            $data=[
                'message'=>'Error en la validacion de los datos',
                'errors'=>$validator->errors(),
                'status'=>400,
            ];
            return response()->json($data,400);

        }

        $direccion=$estacion->direccion;
        $direccion->calle = $request->calle;
        $direccion->numero_exterior = $request->numero_exterior;
        $direccion->numero_interior = $request->numero_interior;
        $direccion->colonia = $request->colonia;
        $direccion->codigo_postal = $request->codigo_postal;
        $direccion->localidad = $request->localidad;
        $direccion->municipio = $request->municipio;
        $direccion->entidad_federativa = $request->entidad_federativa;
        $direccion->entre_calles = $request->entre_calles;
        $direccion->save();


        $estacion->nombre = $request->nombre;
        $estacion->telefono = $request->telefono;
        $estacion->latitude = $request->latitude;
        $estacion->longitude=$request->longitude;
        $estacion->save();

        $data=[
            'estacion'=>$estacion,       
            'status'=>200,
        ];

        return response()->json($data,200);

    }


    public function destroy($id_estacion){

        $estacion = Estacion::find($id_estacion);
        
        if(!$estacion){
            $data=[
                'message'=>'No se encontro la estacion',
                'status'=>404,
            ];
            return response()->json($data,404);           
        }
        $estacion->delete();

        $data=[
            'message'=>'Solicitante eliminado correctamente',
            'status'=>200,
        ];
        return response()->json($data,200);

    }




}

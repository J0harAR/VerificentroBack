<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Estados;
use App\Models\Municipios;
class EstadoController extends Controller
{
    // Obtener todos los estados
    public function index()
    {
        $estados = Estados::all();

        if($estados->isEmpty()){
            $data=[
                'message'=>'No hay estados registrados',
                'status'=>200,
            ];
        }

        $data=[
            'estados'=>$estados,
            'status'=>200,
        ];
        
        return response()->json($data,200);
    }


    public function getMunicipios($id_estado){
        
        $estado = Estados::find($id_estado);
       

        if(!$estado){
            $data=[
                'message'=>'No se encontro el estado',
                'status'=>404,
            ];
            return response()->json($data,404);
        }
        $municipios=Municipios::where('id_state',$estado->id)->get();

        $data=[
            'estado'=>$estado,
            'municipios'=>$municipios,
            'estatus'=>200,
        ];

        return response()->json($data,200);
        
    }

}

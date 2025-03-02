<?php

namespace App\Http\Controllers;

use App\Models\Estacion;
use Illuminate\Http\Request;
use App\Models\Estados;
use App\Models\Municipios;
use App\Models\Direccion;

class EstacionesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $estados=Estados::all();
        $estaciones=Estacion::paginate(15);
        return view('sistema.estaciones.index',compact('estaciones','estados'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre'=>'required|unique:estacion',
            'telefono'=>'required|size:10',
            'latitude'=>'required',
            'longitude'=>'required',
            'calle'=>'required',        
            'colonia'=>'required',   
            'codigo_postal'=>'required',          
            'localidad'=>'required',   
            'municipio'=>'required',   
            'estado'=>'required',
            'entre_calles'=>'required', 
        ]);


        $municipio=Municipios::where('description',$request->input('municipio'))->first();
        $estado=Estados::find($request->input('estado'));

        
        $direccion=Direccion::create([
            'calle'=>$request->input('calle'),
            'numero_exterior'=>$request->input('numero_exterior'),
            'numero_interior'=>$request->input('numero_interior'),
            'colonia'=>$request->input('colonia'),
            'codigo_postal'=>$request->input('codigo_postal'),
            'localidad'=>$request->input('localidad'),
            'municipio'=>$municipio->description,
            'entidad_federativa'=>$estado->description,
            'entre_calles'=>$request->input('entre_calles'),
        ]);

        $estacion=Estacion::create([
            'nombre'=>$request->input('nombre'),
            'telefono'=>$request->input('telefono'),
            'latitude'=>$request->input('latitude'),
            'longitude'=>$request->input('longitude'),
            'id_direccion'=>$direccion->id,          
        ]);

        return redirect()->route('estaciones.index')->with('success', 'Estacion creada correctamente');

    }

    /**
     * Display the specified resource.
     */
    public function show(Estacion $estacion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Estacion $estacion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $estacion)
    {
      
        $estacion = Estacion::find($estacion);

        $validated = $request->validate([
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
            'estado'=>'required',
            'entre_calles'=>'required',  
        ]);
        $estado=Estados::find($request->input('estado'));

        $direccion=$estacion->direccion;
        $direccion->calle = $request->input('calle');
        $direccion->numero_exterior = $request->input('numero_exterior');
        $direccion->numero_interior = $request->input('numero_interior');
        $direccion->colonia = $request->input('colonia');
        $direccion->codigo_postal = $request->input('codigo_postal');
        $direccion->localidad = $request->input('localidad');
        $direccion->municipio = $request->input('municipio');
        $direccion->entidad_federativa = $estado->description;
        $direccion->entre_calles = $request->input('entre_calles');
        $direccion->save();

        $estacion->nombre = $request->input('nombre');
        $estacion->telefono = $request->input('telefono');
        $estacion->latitude = $request->input('latitude');
        $estacion->longitude = $request->input('longitude');
        $estacion->save();

     
        return redirect()->route('estaciones.index')->with('success', 'Estacion actualizada correctamente');
    
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($estacion)
    {
        $estacion = Estacion::find($estacion);
        
        if(!$estacion){
            return redirect()->route('estaciones.index')->with('error', 'No se encontro la estacion');          
        }
        $estacion->delete();
        return redirect()->route('estaciones.index')->with('warning', 'Se elimino correctamente la estacion');
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

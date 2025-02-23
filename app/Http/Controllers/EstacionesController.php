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

        $municipio=Municipios::find($request->input('municipio'));
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
    public function update(Request $request, Estacion $estacion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Estacion $estacion)
    {
        //
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

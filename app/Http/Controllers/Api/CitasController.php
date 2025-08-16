<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cita;
use App\Models\Solicitante;
use App\Models\Estacion;
use App\Models\Vehiculo;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\CitasMail;
use Illuminate\Support\Facades\Notification;
use App\Notifications\Citas;
use App\Models\User;
use App\Models\Horario;
use Carbon\Carbon;
use Illuminate\Support\Str;
class CitasController extends Controller
{
    public function index()
    {
        $citas = Cita::with('solicitante', 'estacion', 'estacion.direccion', 'vehiculo')->get();

        if ($citas->isEmpty()) {
            $data = [
                'message' => 'No hay citas registradas',
                'status' => 200,
            ];
            return response()->json($data, 200);
        }
        $data = [
            'citas' => $citas,
            'status' => 200,
        ];
        return response()->json($data, 200);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'curp' => 'required',
            'nombre' => 'required',
            'apellido_p' => 'required',
            'apellido_m' => 'required',
            'celular' => 'required|size:10',
            'correo' => 'required|email',
            'regimen' => 'required',
            'placa' => 'required',
            'vin' => 'required',
            'modelo' => 'required',
            'marca' => 'required',
            'año' => 'required',
            'estado' => 'required',
            'tipo_combustible' => 'required',
            'tipo_cita' => 'required',
            'fecha' => 'required|date_format:Y-m-d',
            'hora' => 'required|date_format:H:i',
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validacion de los datos',
                'errors' => $validator->errors(),
                'status' => 400,
            ];
            return response()->json($data, 400);
        }


        if (Cita::where('fecha', $request->fecha)->where('hora', $request->hora)->where('estado', false)->first()) {
            return response()->json([
                'message' => 'Cita con hora y fecha ya registrada.',
                'status' => 400
            ], 400);
        }

        $estacion = Estacion::find($request->id_estacion);
        if (!$estacion) {
            return response()->json(['message' => 'Estación no encontrada', 'status' => 404], 404);
        }

        $solicitante = Solicitante::firstOrCreate(['curp' => $request->curp], [
            'nombre' => $request->nombre,
            'apellido_p' => $request->apellido_p,
            'apellido_m' => $request->apellido_m,
            'celular' => $request->celular,
            'correo' => $request->correo,
            'regimen' => $request->regimen,
        ]);

        $vehiculo = Vehiculo::firstOrCreate(['placa' => $request->placa], [
            'vin' => $request->vin,
            'modelo' => $request->modelo,
            'marca' => $request->marca,
            'año' => $request->año,
            'estado' => $request->estado,
            'tipo_combustible' => $request->tipo_combustible,
            'id_solicitante' => $solicitante->curp,
        ]);
      
        $citaExistente = Cita::where('id_solicitante', $solicitante->curp)
        ->where('id_vehiculo', $vehiculo->placa)
        ->where('fecha', $request->fecha)
        ->where('hora', $request->hora)
        ->where('estado', false)
        ->exists();

        if ($citaExistente) {
            return response()->json(['message' => 'Cita ya registrada.', 'status' => 400], 400);
        }

        $cita_date_diferentes=Cita::where('id_solicitante',$solicitante->curp)->where('id_vehiculo', $vehiculo->placa)->where('estado', false)->exists();
        
        if($cita_date_diferentes){
            return response()->json(['message' => 'Cita ya registrada.', 'status' => 400], 400);
        }


        $cita = Cita::create([
            'folio' => $folio = $estacion->nombre . '-' . $request->fecha . '-' . uniqid(),
            'id_solicitante' => $solicitante->curp,
            'id_estacion' => $estacion->id,
            'id_vehiculo' => $vehiculo->placa,
            'fecha' => $request->fecha,
            'hora' => $request->hora,
            'tipo' => $request->tipo_cita,
            'estado' => false,
        ]);

        $data = [
            'cita' => $cita,
            'status' => 201,
        ];
        $cita->vehiculo;
        $cita->solicitante;
        $cita->estacion;

        Mail::to($request->correo)->send(new CitasMail());
        $users = $estacion->users; 
        Notification::send($users, new Citas($cita));
        return response()->json($data, 201);
    }

    public function show(Request $request)
    {
        // Validar la entrada del usuario
        $validator = Validator::make($request->all(), [
            'placa' => 'nullable|string',
            'folio' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error en la validación de los datos',
                'errors' => $validator->errors(),
                'status' => 400,
            ], 400);
        }

        $query = Cita::query();

        if ($request->has('placa') || $request->has('folio')) {
            $query->where('id_vehiculo', $request->placa)
                ->orWhere('folio', $request->folio);
        }

        $citas = $query->with(['vehiculo', 'solicitante', 'estacion'])
            ->first();
        
        if ($citas==null) {
                return response()->json([
                    'message' => 'Cita no encontrada.',
                    'status' => 404
                ], 404);
        }

        return response()->json([
            'cita' => $citas,
            'status' => 200,
        ]);
    }




    public function getHorasDisponibles($fecha, Request $request)
    {
        Carbon::setLocale('es');
        $centerId = $request->query('centerId'); // Get the center ID from the query string
        $nombreDia = Carbon::parse($fecha)->translatedFormat('l');
        $horarios=Estacion::find($centerId)->horarios;
        
        $horaInicio = '';
        $horaFin = '';
        $todasLasHoras =[];
        foreach($horarios as $horario){
            if(Str::lower($horario->dia->dia) == $nombreDia){
                $horaInicio=$horario->hora_inicio;
                $horaFin=$horario->hora_fin;
                // Generate all time slots in 15-minute intervals
                $todasLasHoras = $this->generarIntervalosDeTiempo($horaInicio, $horaFin, 15);
                
            }
        }
        // Obtener la hora actual si la fecha es hoy
        $horaActual = now()->format('H:i:s');
        if ($fecha == now()->format('Y-m-d')) {
            // Filtrar las horas después de la hora actual
            $todasLasHoras = array_filter($todasLasHoras, function ($hora) use ($horaActual) {
                return $hora > $horaActual;
            });
        }

        // Get booked hours for the given date and station
        $horasOcupadas = Cita::where('fecha', $fecha)
            ->where('id_estacion', $centerId) // Filter by station ID
            ->pluck('hora')
            ->toArray();

        // Calculate available hours
        $horasDisponibles = array_diff($todasLasHoras, $horasOcupadas);

        // Format hours to H:i
        $horas_formateadas = array_map(function ($hora) {
            return date('H:i', strtotime($hora));
        }, $horasDisponibles);

        return response()->json([
            'horas' => array_values($horas_formateadas),
            'status' => 200,
        ]);
    }


    private function generarIntervalosDeTiempo($inicio, $fin, $intervaloEnMinutos)
    {
        $horarios = [];
        $horaActual = strtotime($inicio);
        $horaLimite = strtotime($fin);

        while ($horaActual <= $horaLimite) {
            $horarios[] = date('H:i:s', $horaActual);
            $horaActual = strtotime("+{$intervaloEnMinutos} minutes", $horaActual);
        }

        return $horarios;
    }

    public function filtrarCitas(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'estado' => 'nullable|boolean',
            'id_estacion' => 'nullable',
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error en la validacion de los datos',
                'errors' => $validator->errors(),
                'status' => 400,
            ];
            return response()->json($data, 400);
        }
        $query = Cita::query();

        if ($request->has('id_estacion')) {
            $query->where('id_estacion', $request->id_estacion);
        }

        if ($request->has('estado')) {
            $query->where('estado', $request->estado);
        }

        $citas = $query->with('vehiculo', 'solicitante', 'estacion')->get();

        return response()->json([
            'data' => $citas,
            'status' => 200,
        ]);
    }

    public function verificarCita(Request $request){

        // Validar la entrada del usuario
    $validator = Validator::make($request->query(), [ // Cambié a query() porque la petición es GET
        'placa' => 'required|string',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'message' => 'Error en la validación de los datos',
            'errors' => $validator->errors(),
            'status' => 400,
        ], 400);
    }

    $placa = $request->query('placa');

    // Buscar la cita asociada al vehículo con esa placa
    $cita=Cita::where('id_vehiculo',$request->query('placa'))->first();  

 

    return response()->json([
        'cita' => $cita,
        'status' => 200,
    ]);

    }
}

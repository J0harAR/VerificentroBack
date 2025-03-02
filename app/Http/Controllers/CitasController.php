<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Solicitante;
use App\Models\Estacion;
use App\Models\Vehiculo;
use App\Models\User;
use App\Models\Cita;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\CitasMail;
class CitasController extends Controller
{
   
        public function index() {
            $user=Auth::user();
            if($user->hasRole('Administrador')){
                $citas = Cita::paginate(5);
                $estacion=null;
                return view('sistema.citas.index',compact('citas','estacion'));
            };
            $estacion = $user->estacion;
            $citas = Cita::where('id_estacion',$estacion->id)->paginate(5);
            
            return view('sistema.citas.index',compact('citas','estacion'));
        }

        public function store(){

        }

        public function update(Request $request,$id){

            $cita = Cita::find($id);

            if (!$cita) {
                return redirect()->route('citas.index')->with('error', 'Cita no encontrada');
            }

            // Validar si ya existe una cita con la misma fecha y hora
            $existeCita = Cita::where('fecha', $request->input('fecha'))
                            ->where('hora', $request->input('hora'))
                            ->where('id', '!=', $id)
                            ->exists();

            if ($existeCita) {
                return redirect()->route('citas.index')->with('error', 'Ya existe una cita en esa fecha y hora');
            }
            $cita->folio=$cita->estacion->nombre . '-' . $request->fecha . '-' . uniqid();
            $cita->fecha = $request->input('fecha');
            $cita->hora = $request->input('hora');
            $cita->save();
            
            Mail::to($cita->solicitante->correo)->send(new CitasMail());

            return redirect()->route('citas.index')->with('success', 'Cita actualizada exitosamente');
            
        }



        public function changeStatus($id){
            
            $cita = Cita::find($id);

            if (!$cita) {
                return redirect()->route('citas.index')->with('error', 'Cita no encontrada');
            }

            $cita->estado=true;
            $cita->save();
           return redirect()->route('citas.index')->with('success', 'Cita finalizada exitosamente');

        }

        public function destroy($id){
            $cita = Cita::find($id);

            if (!$cita) {
                return redirect()->route('citas.index')->with('error', 'Cita no encontrada');
            }
            $cita->delete();
            return redirect()->route('citas.index')->with('info', 'Cita eliminada exitosamente');

        }

        public function sendMail($id){
            $cita = Cita::find($id);

            if (!$cita) {
                return redirect()->route('citas.index')->with('error', 'Cita no encontrada');
            }

            Mail::to($cita->solicitante->correo)->send(new CitasMail());
            return redirect()->route('citas.index')->with('info', 'Acuse de cita enviado');
        }

       

}

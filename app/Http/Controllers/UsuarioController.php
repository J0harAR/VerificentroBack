<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Models\User;
use App\Models\Estacion;
use App\Services\UserService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Arr;

class UsuarioController extends Controller
{
    public function __construct(private UserService $userServices)
    {
       
        $this->middleware('permission:gestionar-usuarios-ver|gestionar-usuarios-crear|gestionar-usuarios-editar|gestionar-usuarios-eliminar', ['only' => ['index']]);
        $this->middleware('permission:gestionar-usuarios-crear', ['only' => ['create', 'store']]);
        $this->middleware('permission:gestionar-usuarios-editar', ['only' => ['edit', 'update']]);
        $this->middleware('permission:gestionar-usuarios-eliminar', ['only' => ['destroy']]);
        
    }

    public function index()
    {
        $roles = Role::pluck('name', 'id')->all(); // Cambiar 'name' por 'id'
        $estaciones=Estacion::all();
        $usuarios = User::paginate(5);
        return view('sistema.usuarios.index', compact('usuarios', 'roles','estaciones'));
    }


    public function create()
    {
        $roles = Role::pluck('name', 'name')->all();
        return view('usuarios.crear', compact('roles'));
    }

    public function store(Request $request)
    {
        $this->userServices->crearUsuario($request);
        return redirect()->route('usuarios.index')->with('success', 'Usuario creado exitosamente');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::pluck('name', 'id')->all(); // Obtén los roles con sus IDs
        $userRoles = $user->roles->pluck('id')->all(); // Obtén los IDs de los roles asignados al usuario

        return view('usuarios.editar', compact('user', 'roles', 'userRoles'));
    }


    public function update(Request $request, $id)
    {
       
        $this->userServices->actualizarUsuario($request,$id);
        return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado exitosamente');
    }

    public function destroy($id)
    {
        $this->userServices->eliminarUsuario($id);
        return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado exitosamente');
    }

  
}

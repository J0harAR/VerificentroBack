@extends('layouts.master')

@section('title') @lang('Usuarios') @endsection

@section('content')
@include('partials.alertas')
@component('components.breadcrumb')
@slot('li_1') Usuarios @endslot
@slot('title') Lista de Usuarios @endslot
@endcomponent

<div class="row">
    <div class="col-lg-12">
        <div class="card shadow-sm border-light">
            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Gestión de Usuarios</h5>
                @can('gestionar-usuarios-crear')
                    <button type="button" class="btn btn-success" data-bs-toggle="modal"
                        data-bs-target="#nuevoUsuarioModal">
                        <i class="bx bx-user-plus"></i> Nuevo Usuario
                    </button>
                @endcan
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table mb-0 table-hover table-striped">
                        <thead class="table">
                            <tr>
                                <th scope="col" class="d-none">ID</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">E-mail</th>
                                <th scope="col">Rol</th>
                                <th>Estacion</th>
                                <th scope="col" class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($usuarios as $usuario)
                                <tr>
                                    <td class="d-none">{{$usuario->id}}</td>
                                    <td>{{$usuario->name}}</td>
                                    <td>{{$usuario->email}}</td>
                                    <td>
                                        @if($usuario->getRoleNames()->isNotEmpty())
                                            @foreach($usuario->getRoleNames() as $rolname)
                                                <span class="badge bg-success mb-1">{{ $rolname }}</span>
                                            @endforeach
                                        @else
                                            <span class="text-muted">Sin rol asignado</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($usuario->estacion)
                                            {{$usuario->estacion->nombre}}
                                        @else
                                            <span class="text-muted">Sin estacion asignado</span>
                                        @endif
                                   
                                    </td>
                                    <td class="text-center align-middle">
                                        @can('gestionar-usuarios-editar')
                                            <button type="button" class="btn btn-sm btn-outline-info me-1"
                                                data-bs-toggle="modal" data-bs-target="#editarUsuarioModal-{{ $usuario->id }}"
                                                title="Editar">
                                                <i class="bx bx-pencil"></i>
                                            </button>
                                        @endcan
                                        @can('gestionar-usuarios-eliminar')
                                            <form action="{{ route('usuarios.destroy', $usuario->id) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger"
                                                    onclick="return confirm('¿Estás seguro de que deseas eliminar este usuario?');">
                                                    <i class="bx bx-trash"></i>
                                                </button>
                                            </form>
                                        @endcan
                                    </td>
                                </tr>

                                @include('sistema.usuarios.modals.edit', ['usuario' => $usuario, 'roles' => $roles])
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- Paginación -->
                <div class="d-flex justify-content-center mt-3">
                    {!! $usuarios->links('pagination::bootstrap-4') !!}
                </div>
            </div>
            <!-- end card body -->
        </div>
        <!-- end card -->
    </div>
    <!-- end col -->
</div>

@include('sistema.usuarios.modals.create')
<!--Comentario prueba -->
@endsection
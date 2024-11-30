@extends('layouts.master')

@section('title') @lang('Roles') @endsection

@section('content')
@include('partials.alertas')
@component('components.breadcrumb')
@slot('li_1') Roles @endslot
@slot('title') Lista de Roles @endslot
@endcomponent

<div class="row">
    <div class="col-lg-12">
        <div class="card shadow-sm border-light">
            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Gestión de Roles</h5>
                @can('gestionar-roles-crear')
                    <a href="{{ route('roles.create') }}" class="btn btn-success">
                        <i class="bx bx-plus"></i> Nuevo Rol
                    </a>
                @endcan
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table mb-0 table-hover table-striped">
                        <thead class="table">
                            <tr>
                                <th scope="col">Rol</th>
                                <th scope="col" class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($roles as $role)
                                <tr>
                                    <td>{{ $role->name }}</td>
                                    <td class="text-center align-middle">
                                        @can('gestionar-roles-editar')
                                            <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-sm btn-outline-info me-1" title="Editar">
                                                <i class="bx bx-pencil"></i>
                                            </a>
                                        @endcan
                                        @can('gestionar-roles-eliminar')
                                            <form action="{{ route('roles.destroy', $role->id) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger"
                                                    onclick="return confirm('¿Estás seguro de que deseas eliminar este rol?');">
                                                    <i class="bx bx-trash"></i>
                                                </button>
                                            </form>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- Paginación -->
                <div class="d-flex justify-content-center mt-3">
                    {!! $roles->links('pagination::bootstrap-4') !!}
                </div>
            </div>
            <!-- end card body -->
        </div>
        <!-- end card -->
    </div>
    <!-- end col -->
</div>
@endsection
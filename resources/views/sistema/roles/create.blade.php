@extends('layouts.master')

@section('title') @lang('Crear Rol') @endsection

@section('content')
@component('components.breadcrumb')
@slot('li_1') 
<a href="{{ route('roles.index') }}">Roles</a> 
@endslot
@slot('title') Crear Rol @endslot
@endcomponent

<div class="row">
    <div class="col-lg-12">
    <div class="card shadow-sm">
            <div class="card-body">
                <form method="POST" action="{{ route('roles.store') }}">
                    @csrf

                    <div class="mb-4">
                        <label for="name" class="form-label fw-bold">Nombre del Rol</label>
                        <input type="text" name="name" class="form-control" placeholder="Ingrese el nombre del rol" required>
                    </div>

                    <div class="mb-4">
                        <label for="permissions" class="form-label fw-bold">Permisos</label>

                        @php
                                                    $order = ['usuarios', 'roles', 'estaciones', 'servicios', 'anexo30','om'];

                            $groupedPermissions = $permission->groupBy(function($perm) {
                                return explode('-', $perm->name, 3)[1];
                            })->sortBy(function($value, $key) use ($order) {
                                $index = array_search($key, $order);
                                return $index === false ? count($order) : $index;
                            });
                        @endphp

                        <div class="row">
                            @foreach($groupedPermissions->chunk(2) as $rowChunks)
                            <div class="row mb-4">
                                @foreach($rowChunks as $action => $permissions)
                                <div class="col-md-6">
                                    <div class="border rounded p-3 shadow-sm ">
                                    <div class="d-flex justify-content-between align-items-center mb-3 border-bottom pb-2">
                                    <h6 class=" mb-0">{{ ucfirst($action) }}</h6>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="select-all-{{ $action }}" onclick="toggleSectionPermissions('{{ $action }}')">
                                                <label class="form-check-label" for="select-all-{{ $action }}">
                                                    Seleccionar todos
                                                </label>
                                            </div>
                                        </div>
                                        <table class="table table-sm table-borderless">
                                            <tbody>
                                                @foreach($permissions->chunk(2) as $chunk)
                                                <tr>
                                                    @foreach($chunk as $value)
                                                    <td>
                                                        <div class="form-check">
                                                            <input class="form-check-input section-{{ $action }}" type="checkbox" name="permission[]" value="{{ $value->name }}" id="permission-{{ $value->name }}">
                                                            <label class="form-check-label" for="permission-{{ $value->name }}">
                                                                {{ $value->name }}
                                                            </label>
                                                        </div>
                                                    </td>
                                                    @endforeach
                                                    @if($chunk->count() < 2)
                                                    <td></td>
                                                    @endif
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary me-2">Guardar</button>
                        <a href="{{ route('roles.index') }}" class="btn btn-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function toggleSectionPermissions(section) {
        const sectionCheckbox = document.getElementById(`select-all-${section}`);
        const checkboxes = document.querySelectorAll(`.section-${section}`);
        checkboxes.forEach(checkbox => checkbox.checked = sectionCheckbox.checked);
    }

    function toggleAllPermissions() {
        const selectAllCheckbox = document.getElementById('select-all');
        const checkboxes = document.querySelectorAll('input[name="permission[]"]');
        checkboxes.forEach(checkbox => checkbox.checked = selectAllCheckbox.checked);
    }
</script>

@endsection
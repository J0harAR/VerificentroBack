@extends('layouts.master')

@section('title') @lang('translation.Building') @endsection
@section('css')

<!-- flatpickr css -->
<link href="{{ URL::asset('build/libs/flatpickr/flatpickr.min.css') }}" rel="stylesheet" type="text/css">

<!-- DataTables -->
<link href="{{ URL::asset('build/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset('build/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />

@endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') Estaciones @endslot
@slot('title') Lista de estaciones @endslot
@endcomponent

<button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#generarEstacionModal">
    <i class="fas fa-plus"></i>
    Nueva Estación
</button>
@include('sistema.estaciones.modals.create')

@include('partials.alertas')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table align-middle datatable dt-responsive table-check nowrap" style="border-collapse: collapse; border-spacing: 0 8px; width: 100%;">
                        <thead>
                            <tr class="bg-transparent">
                                <th>Nombre de la estacion</th>
                                <th>Direccion</th>
                                <th>Telefono</th>
                                <th style="width: 90px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                        @foreach ($estaciones as $estacion)
                        
                            <tr>
            
                                <td>
                                    {{$estacion->nombre}}
                                </td>
                                <td>{{$estacion->direccion->calle}},{{$estacion->direccion->numero_exterior}},{{$estacion->direccion->colonia}},{{$estacion->direccion->codigo_postal}}</td>
                                <td>{{$estacion->telefono}}</td>
                             
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-link font-size-16 shadow-none py-0 text-muted dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="bx bx-dots-horizontal-rounded"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">

                                                <button type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#editarEstacionModal-{{ $estacion->id }}">
                                                     Editar estacion
                                                </button>
                                
                                                   
                                                <button type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#deleteEstacion-{{$estacion->id}}">
                                                    Eliminar estacion
                                                </button>                             
                                        </ul>
                                    </div>
                                </td>
                               
                            </tr>
                            @include('sistema.estaciones.modals.delete')
                            @include('sistema.estaciones.modals.edit')
                       
                        @endforeach
                    
                        
                        </tbody>
                    </table>
                </div>
                <!-- end table responsive -->
            </div>
            <!-- end card body -->
        </div>
        <!-- end card -->
    </div>
    <!-- end col -->
</div>
<!-- end row -->

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $(document).ready(function () {
    $(document).on('change', 'select[name="estado"]', function () {
        var estadoId = $(this).val();
        var modal = $(this).closest('.modal');
        var municipioSelect = modal.find('select[name="municipio"]');
        var municipioSeleccionado = municipioSelect.data('selected');

        if (estadoId) {
            $.ajax({
                url: '/estados/' + estadoId + '/municipios',
                type: 'GET',
                dataType: 'json',
                success: function (response) {
                    municipioSelect.empty();
                    municipioSelect.append('<option value="" disabled>Selecciona un municipio</option>');

                    $.each(response.municipios, function (key, municipio) {
                        let selected = (municipio.description == municipioSeleccionado) ? 'selected' : '';
                        municipioSelect.append('<option value="' + municipio.description + '" ' + selected + '>' + municipio.description + '</option>');
                    });

                    municipioSelect.val(municipioSeleccionado); // Selecciona el municipio correcto
                },
                error: function () {
                    alert('Error al obtener los municipios');
                }
            });
        }
    });

    $('.modal').on('shown.bs.modal', function () {
        var municipioSelect = $(this).find('select[name="municipio"]');
        if (municipioSelect.data('selected')) {
            $(this).find('select[name="estado"]').trigger('change');
        }
    });
});



</script>

@endsection


@section('script')

<script src="{{ URL::asset('build/libs/dropzone/min/dropzone.min.js') }}"></script>
<!-- flatpickr js -->
<script src="{{ URL::asset('build/libs/flatpickr/flatpickr.min.js') }}"></script>

<!-- Required datatable js -->
<script src="{{ URL::asset('build/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ URL::asset('build/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ URL::asset('build/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ URL::asset('build/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>

<!-- init js -->
<script src="{{ URL::asset('build/js/pages/invoices-list.init.js') }}"></script>
@endsection
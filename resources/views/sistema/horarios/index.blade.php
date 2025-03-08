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
@slot('title') Lista de horarios @endslot
@endcomponent

<button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#generarHorarioModal">
    <i class="fas fa-plus"></i>
    Nueva horario
</button>
@include('sistema.horarios.modals.create')


@include('partials.alertas')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table align-middle datatable dt-responsive table-check nowrap" style="border-collapse: collapse; border-spacing: 0 8px; width: 100%;">
                        <thead>
                            <tr class="bg-transparent">
                                <th>#</th>
                                <th>Nombre</th>
                                <th>Horas</th>
                                <th style="width: 90px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                        @foreach ($horarios as $horario)
                        
                            <tr>
            
                                <td>
                                    {{$horario->dia->id}}
                                </td>
                                <td>{{$horario->dia->dia}}</td>
                                <td>{{$horario->hora_inicio}} - {{$horario->hora_fin}}</td>
                             
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-link font-size-16 shadow-none py-0 text-muted dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="bx bx-dots-horizontal-rounded"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">

                                                <button type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#editarEstacionModal">
                                                     Editar estacion
                                                </button>
                                
                                                   
                                                <button type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#deleteEstacion">
                                                    Eliminar estacion
                                                </button>                             
                                        </ul>
                                    </div>
                                </td>
                               
                            </tr>
                      
                       
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
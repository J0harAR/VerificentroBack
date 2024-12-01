@extends('layouts.master')

@section('title') @lang('translation.Invoice_List') @endsection

@section('css')

<!-- flatpickr css -->
<link href="{{ URL::asset('build/libs/flatpickr/flatpickr.min.css') }}" rel="stylesheet" type="text/css">

<!-- DataTables -->
<link href="{{ URL::asset('build/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset('build/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />

@endsection

@section('content')

@component('components.breadcrumb')
@slot('li_1') Citas @endslot
@slot('title') Gestion de citas @endslot
@endcomponent

@include('partials.alertas')

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm">
                        
                    </div>
                    <div class="col-sm-auto">
                        <div class="d-flex align-items-center gap-1 mb-4">
                            <div class="input-group datepicker-range">
                                <input type="text" class="form-control flatpickr-input" data-input aria-describedby="date1">
                                <button class="input-group-text" id="date1" data-toggle><i class="bx bx-calendar-event"></i></button>
                            </div>
                            <div class="dropdown">
                                <a class="btn btn-link text-muted py-1 font-size-16 shadow-none dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bx bx-dots-horizontal-rounded"></i>
                                </a>

                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="#">Action</a></li>
                                    <li><a class="dropdown-item" href="#">Another action</a></li>
                                    <li><a class="dropdown-item" href="#">Something else here</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end row -->

                <div class="table-responsive">
                    <table class="table align-middle datatable dt-responsive table-check nowrap" style="border-collapse: collapse; border-spacing: 0 8px; width: 100%;">
                        <thead>
                            <tr class="bg-transparent">
                                
                                <th style="width: 90px;">Folio</th>
                                <th>Nombre del solicitante</th>
                                <th>Placas del vehiculo</th>
                                <th>Fecha</th>
                                <th>Hora</th>
                                <th>Estatus</th>
                                <th style="width: 90px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                        @foreach ($citas as $cita)
                        
                            <tr>
                                

                                <td><a href="javascript: void(0);" class="text-body fw-medium">{{$cita->folio}}</a> </td>
                                <td>
                                    {{$cita->solicitante->nombre}} {{$cita->solicitante->apellido_p}} {{$cita->solicitante->apellido_m}}
                                </td>
                                <td>{{$cita->vehiculo->placa}}</td>
                             
                                 <td>{{$cita->fecha}}</td>
                                
                                <td>
                                   {{$cita->hora}}                                    
                                </td>

                                @if(!$cita->estado)
                                    <td>Pendiente</td>
                                @else
                                     <td>Completada</td>

                                @endif
                            
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-link font-size-16 shadow-none py-0 text-muted dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="bx bx-dots-horizontal-rounded"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                                                                                                                                            
                                            
                                                   
                                                @if(!$cita->estado)   
                                                    <button type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#editCita-{{$cita->id}}">
                                                        Editar Cita
                                                    </button>
                                                 @endif   

                                    
                                                                                   
                                           
                                                @if(!$cita->estado)                                                               
                                                <button type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#finalizarCita-{{$cita->id}}">
                                                    Finalizar cita
                                                </button>
                                                @endif
                                             
                                                <button type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#deleteCita-{{$cita->id}}">
                                                    Eliminar cita
                                                </button>
                                                                                                                                
                                                                        
                                                <form action="{{route('citas.aviso',['id'=>$cita->id])}}" method="POST">
                                                        @csrf
                                                        @method('POST')
                                                        <button class="dropdown-item" type="submit">Avisar con correo</button>
                                                </form>
                                               
                                        </ul>
                                    </div>
                                </td>
                               
                            </tr>
                            @include('sistema.citas.modals.edit', ['cita' => $cita])
                            @include('sistema.citas.modals.delete', ['cita' => $cita])
                            @include('sistema.citas.modals.finalizarCita', ['cita' => $cita])
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
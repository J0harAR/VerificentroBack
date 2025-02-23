@extends('layouts.master')

@section('title') @lang('Roles') @endsection

@section('content')
@include('partials.alertas')
@component('components.breadcrumb')
@slot('li_1') Estaciones @endslot
@slot('title') Lista de estaciones @endslot
@endcomponent

<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#generarEstacionModal">
    <i class="fas fa-plus"></i>
    Nueva Estación
</button>
@include('sistema.estaciones.modals.create')

@foreach ($estaciones as $estacion)
<p>{{$estacion}}</p>
    
@endforeach


@endsection
@extends('layouts.master')

@section('title') @lang('Roles') @endsection

@section('content')
@include('partials.alertas')
@component('components.breadcrumb')
@slot('li_1') Clientes @endslot
@slot('title') Lista de Clientes @endslot
@endcomponent


@foreach ($clientes as $cliente)
<p>client_id: {{$cliente->id}}</p>
<p>user_id: {{$cliente->user_id}}</p>
<p>redirect: {{$cliente->redirect}}</p>
<p>secret: {{$cliente->secret}}</p>
@endforeach


@endsection
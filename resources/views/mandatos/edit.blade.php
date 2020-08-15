@extends('layouts.app')
@section('header')
    @breadcrumb(['title' => 'Mandatos'])
    <li>
        <a href="{!! route('app.index') !!}">
            <i class="fa fa-th"></i> Dashboard
        </a>
    </li>
    <li>
        <a href="{!! route('app.clients.index') !!}">
            <i class="fa fa-users"></i> Clientes
        </a>
    </li>
    <li>
        <a href="{!! route('app.clients.show', $client->id) !!}">
            {{ $client->name }}
        </a>
    </li>
    <li class="active">
        <i class="fa fa-ribbon"></i> Mandatos
    </li>
    @endbreadcrumb
@endsection

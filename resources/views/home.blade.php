@extends('layouts.app')

@section('header')
    @breadcrumb(['title' => 'Painel'])
    <li class="active"><i class="fa fa-th"></i> Painel</li>
    @endbreadcrumb
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            {{ Route::currentRouteName() }}
        </div>
    </div>
@endsection

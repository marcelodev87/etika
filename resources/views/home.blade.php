@extends('layouts.app')

@section('header')
    @breadcrumb(['title' => 'Painel'])
    <li class="active"><i class="fa fa-th"></i> Painel</li>
    @endbreadcrumb
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"></div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
@endsection

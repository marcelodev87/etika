@extends('layouts.app')

@section('header')
    @breadcrumb(['title' => 'Painel'])
    <li class="active"><i class="fa fa-th"></i> Painel</li>
    @endbreadcrumb
@endsection

@section('content')
    <div class="row justify-content-center">


        <div class="col-lg-3 col-xs-6">
            <div class="media-box">
                <div class="media-icon pull-left"><i class="fa fa-users"></i> </div>
                <div class="media-info">
                    <h5>Clientes Cadastrados</h5>
                    <h3>{{ \App\Client::count() }}</h3>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-xs-6">
            <div class="media-box bg-sea">
                <div class="media-icon pull-left"><i class="fa fa-users"></i> </div>
                <div class="media-info">
                    <h5>Clientes Inativos</h5>
                    <h3>1530</h3>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-xs-6">
            <div class="media-box bg-blue">
                <div class="media-icon pull-left"><i class="icon-bargraph"></i> </div>
                <div class="media-info">
                    <h5>s</h5>
                    <h3>1530</h3>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-xs-6">
            <div class="media-box bg-green">
                <div class="media-icon pull-left"><i class="icon-bargraph"></i> </div>
                <div class="media-info">
                    <h5>Total Leads</h5>
                    <h3>1530</h3>
                </div>
            </div>
        </div>

    </div>
@endsection

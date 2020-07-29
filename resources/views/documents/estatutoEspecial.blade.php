@extends('layouts.app')

@section('header')
    @breadcrumb(['title' => 'Geração de Documentos'])
    <li>
        <a href="{!! route('app.index') !!}">
            <i class="fa fa-th"></i> Painel
        </a>
    </li>
    <li class="active">
        <i class="fa fa-copy"></i> Geração de Documentos
    </li>
    <li class="active">
        Estatuto Especial
    </li>
    @endbreadcrumb
@endsection

@section('content')

    <div class="chart-box">
        <div class="row">
            <div class="col-md-12">
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active">
                        <a href="#igreja" aria-controls="igreja" role="tab" data-toggle="tab">Igreja</a>
                    </li>
                    <li role="presentation">
                        <a href="#fundacao" aria-controls="fundacao" role="tab" data-toggle="tab">Fundação</a>
                    </li>
                    <li role="presentation">
                        <a href="#organizacional" aria-controls="organizacional" role="tab" data-toggle="tab">Estrutura Organizacional</a>
                    </li>
                    <li role="presentation">
                        <a href="#membros" aria-controls="membros" role="tab" data-toggle="tab">Eleição dos Membros</a>
                    </li>
                    <li role="presentation">
                        <a href="#ministerio" aria-controls="ministerio" role="tab" data-toggle="tab">Ministério</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endsection

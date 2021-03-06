@php
    $erro = false;
    $content = null;
@endphp
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
        Lista de Presença
    </li>
    @endbreadcrumb
@endsection

@section('style')
    <style>
        .chart-box {
            margin-bottom: 14px;
        }

        .bootstrap-select + .bootstrap-select {
            margin-top: 7px;
        }

        .bootstrap-select .btn.dropdown-toggle {
            padding: 5px 20px !important;
        }
    </style>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-4 col-lg-3">
            <div class="chart-box">
                <form method="post" action="{!! route('app.documents.listaPresenca') !!}">
                    @csrf
                    <fieldset class="form-group form-group-sm">
                        <select class="form-control selectpicker" name="client_id" required>
                            <option value="">Selecione a Igreja</option>
                            @foreach(\App\Client::where('type', 'igreja')->orderBy('name','asc')->get() as $user)
                                <option value="{{$user->id}}" {{ ($request->has('client_id') && $request->client_id == $user->id) ? 'selected' : '' }}>{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </fieldset>
                    <button type="submit" class="btn btn-sm btn-block btn-success">
                        <i class="fa fa-magic"></i> Gerar
                    </button>
                </form>
            </div>
        </div>

        @if($request->isMethod('post'))
            @php
                $content = true;
                $igreja = $post[0]['name'];
                $cnpj_igreja = $post[0]['document'];
                $endereco_igreja = $post[0]['street'] . ", " .$post[0]['street_number'];
                $complemento_igreja = 	$post[0]['complement'];
                $bairro_igreja = $post[0]['neighborhood'];
                $cidade_igreja = $post[0]['city'];
                $cep_igreja = $post[0]['zip'];
                $uf_igreja = $post[0]['state'];
                $pattern = '/^([[:digit:]]{2})([[:digit:]]{3})([[:digit:]]{3})([[:digit:]]{4})([[:digit:]]{2})$/';
                $replacement = '$1.$2.$3/$4-$5';
                // FUNÇÃO PARA FORMATAR CEP
                $pattern_cep = '/^([[:digit:]]{5})([[:digit:]]{3})$/';
                $replacement_cep = '$1-$2';
                $data = date('d/m/Y');
                if(count($post) == 1){
                    $texto1 = "<h2>NÃO TEM PRESIDENTE CADASTRADO</h2>";
                    $nome_presidente = "Nome Presidente";
                }else{

                    if($post[1]->addresses()->where('main', 1)->count()==0){
                        $erro = "<b>{$post[1]['name']}</b> não tem um endereço padrão";
                    }else{
                        $nome_presidente = $post[1]['name'];
                    }

                }
            @endphp

        @endif


        <div class="col-md-8 col-lg-9">

            @if($erro != false)

                <div class="alert alert-warning">
                    {!! $erro !!}
                </div>

            @else
                @if($content != null)
                    <div class="chart-box">
                        <div class="right_col" role="main">
                            <h1> Geração de Documentos </h1>

                            <div align=justify style='background-color:#FFFFFF;  padding: 25px 50px 25px 50px;'>

                                <h2 class="text-center">LISTA DE PRESENÇA DA REUNIÃO DE FUNDAÇÃO <span style='color:red !important;'>DO(A)</span> {{ $igreja }}</h2>
                                <p class="text-center">DATA: <span style='color:red !important;'>{{ $data }} HORA: 19HS</span></p>
                                <p class="text-center">Realizada na {{ $endereco_igreja }} – {{ $complemento_igreja }} – {{ $bairro_igreja }} – {{ $cidade_igreja }} - {{ $uf_igreja }} – CEP: {{ $cep_igreja }}</p>
                                <br/>
                                <table class="table table-bordered text-center">
                                    <thead>
                                      <tr>
                                        <th class="text-center col-4" scope="col">NOME</th>
                                        <th class="text-center col-4" scope="col">CPF</th>
                                        <th class="text-center col-4" scope="col">ASSINATURA</th>
                                      </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($post[2] as $d)
                                            <tr>
                                                <td>{{ $d->name }}</td>
                                                <td>{{ $d->document }}</td>
                                                <td></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                  </table>



                                    <br/>
                                <p class="text-center">{{ $cidade_igreja }} - {{ $uf_igreja }}, <span style='color:red !important;'>{{ $data }}</span>.</p>
                                <br/>

                                <p class="text-center"> _________________________________________________</p>
                                <span style='color:red !important;'>
                                <p class="text-center">{{ $nome_presidente }}</p>
                                <p class="text-center">PRESIDENTE</p>
                                </span>
                                <br/>
                                <br/>
                            </div>

                        </div>
                    </div>
                @endif
            @endif
        </div>
    </div>

@endsection

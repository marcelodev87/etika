@extends('layouts.app')

@section('header')
    @breadcrumb(['title' => 'Clientes'])
    <li>
        <a href="{!! route('app.index') !!}">
            <i class="fa fa-th"></i> Dashboard
        </a>
    </li>
    <li>
        <a href="{!! route('app.clients.index') !!}">
            <i class="fa fa-user"></i> Clientes
        </a>
    </li>

    <li class="active">
        {{ $client->name }}
    </li>
    @endbreadcrumb
@endsection

@section('style')
    <style>
        .panel-heading > h3 {
            margin: 0;
            padding: 0;
        }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-6">
            <h1>{{ $client->name }}</h1>
        </div>
        <div class="col-md-6 text-right mb-1">
            <a href="{{ route('app.clients.members.index', $client->id) }}" class="btn btn-danger btn-sm">
                Diretoria
            </a>
            <a href="#modal-processes" data-toggle="modal" class="btn btn-success btn-sm">
                Processos
            </a>

        </div>

        <div class="col-md-12">
            <div class="chart-box">
                <div class="bs-example" data-example-id="hoverable-table">

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3>Assinaturas</h3>
                        </div>
                        <div class="panel-body">

                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="col-md-12">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3>Processos</h3>
                </div>
                <div class="panel-body">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Abertura</th>
                            <th>Processo</th>
                            <th class="text-center">Tarefas</th>
                            <th>Valor</th>
                            <th>Pago</th>
                            <th class="text-center">Fechado</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($client->processes as $process)
                            <tr>
                                <td>{{ $process->created_at->format('d/m/Y H:i:s') }}</td>
                                <td>{{ $process->process->name }}</td>
                                <td class="text-center">
                                    {{ $process->tasks()->where('closed', 1)->count() }} / {{ $process->tasks()->count() }}
                                </td>
                                <td>{{ brl($process->totalPrice()) }}</td>
                                <td>{{ brl($process->totalPayed()) }}</td>
                                <td class="text-center">
                                    <i class="fa fa-{{ ($process->closed) ? 'check text-success' : 'times text-danger' }}"></i>
                                </td>
                                <td class="text-right">
                                    <a href="{{ route('app.clients.processes.index',[$client->id, $process->id]) }}" class="btn btn-xs btn-primary">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

        <div class="col-md-6">
            <div class="chart-box">
                <div class="bs-example" data-example-id="hoverable-table">

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3>Tarefas</h3>
                        </div>
                        <div class="panel-body">
                            Panel content
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('modal')
    @include('clients.modals.processCreate')
@endsection

@section('script')
    <script type="text/javascript">
        $("#form-diretoria").on('submit', function (e) {
            e.preventDefault();
            var $form = $(this);
            var $button = $form.find('button[type="submit"]');
            var $buttonText = $button.html();
            var $data = new FormData($form[0]);
            $.ajax({
                url: $form.attr('action'),
                type: $form.attr('method'),
                data: $data,
                dataType: 'json',
                contentType: false,
                processData: false,
                cache: false,
                beforeSend: () => { // aqui vai o que tem que ser feito antes de chamar o endpoint
                    $button.attr('disabled', 'disabled').html('<i class="fas fa-spinner fa-pulse"></i> Carregando...');
                },
                success: (response) => { // aqui vai o que der certo
                    console.log(response);
                    alert(response.message);

                },
                error: (response) => { // aqui vai o que acontece quando ocorrer o erro
                    console.log(response)
                    var json = $.parseJSON(response.responseText);
                    alert(json.message);
                },
                complete: () => { // aqui vai o que acontece quando tudo acabar
                    $button.removeAttr('disabled').html($buttonText);
                }
            });
        });

        $('#select-processes').on('change', function () {
            var $choosed = $(this);
            var $input = $choosed.closest('form').find('input[name="price"]');
            if ($choosed.val() !== "") {
                var $price = $choosed
                    .find('option:selected')
                    .attr('data-price');
                $input.val($price);
            } else {
                $input.val('');
            }
        })

        $('#form-process').on('submit', function (e) {
            e.preventDefault();
            var $form = $(this);
            var $button = $form.find('button[type="submit"]');
            var $buttonText = $button.html();
            var $data = new FormData($form[0]);
            $.ajax({
                url: $form.attr('action'),
                type: $form.attr('method'),
                data: $data,
                dataType: 'json',
                contentType: false,
                processData: false,
                cache: false,
                beforeSend: () => { // aqui vai o que tem que ser feito antes de chamar o endpoint
                    $button.attr('disabled', 'disabled').html('<i class="fas fa-spinner fa-pulse"></i> Carregando...');
                },
                success: (response) => { // aqui vai o que der certo
                    window.location.reload()
                    return;

                },
                error: (response) => { // aqui vai o que acontece quando ocorrer o erro
                    var json = $.parseJSON(response.responseText);
                    alert(json.message);
                },
                complete: () => { // aqui vai o que acontece quando tudo acabar
                    $button.removeAttr('disabled').html($buttonText);
                }
            });
        });
    </script>
@endsection

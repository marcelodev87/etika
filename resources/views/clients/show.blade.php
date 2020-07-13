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

@section('content')
    <div class="row">
        <div class="col-md-6">
            <h1>{{ $client->name }}</h1>
        </div>
        <div class="col-md-6 text-right mb-1">
            <a href="{{ route('app.clients.members.index', $client->id) }}" class="btn btn-danger btn-sm">
                Diretoria
            </a>
            <a href="#modal-processos" data-toggle="modal" class="btn btn-success btn-sm">
                Processos
            </a>

        </div>

        <div class="col-md-12">
            <div class="chart-box">
                <div class="bs-example" data-example-id="hoverable-table">

                    <div class="panel panel-default">
                        <div class="panel-heading"></div>
                        <div class="panel-body">
                            Panel content
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="chart-box">
                <div class="bs-example" data-example-id="hoverable-table">

                    <div class="panel panel-default">
                        <div class="panel-heading"></div>
                        <div class="panel-body">
                            Panel content
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="chart-box">
                <div class="bs-example" data-example-id="hoverable-table">

                    <div class="panel panel-default">
                        <div class="panel-heading"></div>
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
    </script>
@endsection

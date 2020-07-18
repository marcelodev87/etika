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

    <li>
        <a href="{{ route('app.clients.show', $client->id) }}">
            {{ $client->name }}
        </a>
    </li>

    <li class="active">
        Processos
    </li>

    <li class="active">
        <i class="fa fa-hashtag"></i> {{ $clientProcess->id }}
    </li>
    @endbreadcrumb
@endsection

@section('style')
    <style>
        .panel-heading > h3 {
            margin: 0;
            padding: 0;
        }

        .btn-h-35 {
            height: 35px;
        }
    </style>
@endsection

@section('content')

    <div class="chart-box" style="padding-bottom: 0">
        <form method="post" class="row mb-2 form-group-mt-0" action="{{ route('app.clients.processes.tasks.store', [$client->id, $clientProcess->id]) }}">
            @csrf
            <div class="col-md-4">
                <div class="form-group">
                    <select class="form-control" name="task_id">
                        <option value="">Selecione a tarefa</option>
                        @foreach(\App\InternalTask::orderBy('name', 'asc')->get() as $task)
                            <option value="{{ $task->id }}" data-price="{{brl($task->price, false)}}" {{ (old('task_id') == $task->id) ? 'selected' : '' }}>{{ $task->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-addon">R$</div>
                        <input class="form-control" type="text" name="price" placeholder="" data-mask="#00.000,00" data-mask-reverse="true" value="{{ old('price') }}">
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <button class="btn btn-sm btn-success btn-block btn-h-35">
                    <span class="fa fa-plus"></span> Adicionar
                </button>
            </div>

        </form>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3> {{ $clientProcess->process->name }}</h3>
        </div>
        <div class="panel-body">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Nome</th>
                    <th>Valor</th>
                    <th>Fechado</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($clientProcess->tasks as $task)
                    <tr>
                        <td>{{ $task->task->name }}</td>
                        <td>{{ brl($task->price) }}</td>
                        <td>
                            @if($task->closed)
                                <a href="javascript:void(0)" class="btn btn-success btn-xs">
                                    <i class="fa fa-check"></i> {{ $task->end_at->format('d/m/Y H:i:s') }} {{ $task->closedBy->name }}
                                </a>
                                @else
                                <a class="btn btn-danger btn-xs">
                                    <i class="fa fa-times"></i> Aberto
                                </a>
                                @endif
                        </td>
                        <td class="text-right">
                            @if(!$task->closed)
                                <form class="form-inline" action="{{ route('app.clients.processes.tasks.done', [$client->id, $clientProcess->id, $task->id]) }}" method="post" onsubmit="return confirm('Deseja mesmo finalizar?')">
                                    @csrf
                                    @method('put')
                                    <button class="btn btn-success btn-xs" data-toggle="tooltip" data-placement="left" title="Marcar como terminado">
                                        <i class="fa fa-check"></i>
                                    </button>
                                </form>
                            @endif
                            <form class="form-inline" action="{!! route('app.clients.processes.tasks.delete', [$client->id, $clientProcess->id, $task->id]) !!}" method="post">
                                @csrf
                                @method('delete')
                                <button type="button" class="btn btn-xs btn-danger formConfirmDelete" data-toggle="tooltip" data-placement="left" title="Deletar">
                                    <i class="fa fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="row">

        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3>Pagamentos</h3>
                </div>
                <div class="panel-body" style="padding-bottom: 0">
                    <div class="row">
                        <form method="post" action="{{ route('app.clients.processes.payments.store', [$client->id, $clientProcess->id]) }}" class="col-md-12" enctype="multipart/form-data" id="payment-form">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-addon">R$</div>
                                            <input class="form-control" type="text" name="pay_value" placeholder="" required data-mask="#00.000,00" data-mask-reverse="true" value="{{ old('pay_value') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                            <input class="form-control" type="text" name="payed_at" placeholder="" required data-mask="00/00/0000" value="{{ old('payed_at') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fa fa-comment"></i></div>
                                    <textarea class="form-control" name="description" placeholder="Descrição">{!! old('description') !!}</textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="file" name="file" required>
                            </div>
                            <div class="form-group" style="margin-bottom: 0">
                                <button class="btn btn-success btn-block btn-sm">
                                    <i class="fa fa-save"></i> Cadastrar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3>Pagamentos Cadastrados</h3>
                </div>
                <div class="panel-body" style="padding-bottom: 0">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Data</th>
                            <th>Valor</th>
                            <th>Commentário</th>
                            <th class="text-center">Foto</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($clientProcess->payments as $payment)

                            <tr>
                                <td>{{ $payment->payed_at->format('d/m/Y') }}</td>
                                <td>{{ brl($payment->value) }}</td>
                                <td>{{ $payment->description }}</td>
                                <td class="text-center">
                                    @if($payment->file)
                                        <a href="{{ \Illuminate\Support\Facades\Storage::url($payment->file) }}" class="btn btn-xs btn-default" target="_blank">
                                            <i class="fa fa-image"></i>
                                        </a>
                                    @endif
                                </td>
                                <td class="text-right">
                                    <form class="form-inline" action="{!! route('app.clients.processes.payments.delete', [$client->id, $clientProcess->id, $task->id]) !!}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button type="button" class="btn btn-xs btn-danger formConfirmDeletePayment" data-nome="{{ $task->task->name }}" data-toggle="tooltip" data-placement="left" title="Deletar">
                                            <i class="fa fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
@endsection



@section('script')
    <script type="text/javascript">

        $('select[name="task_id"]').on('change', function (e) {
            e.preventDefault();
            console.log($(this))
            var $input = $('input[name="price"]');
            var $selected = $(this).find('option:selected');
            var $val = $selected.val();
            if ($val !== '') {
                var $price = $selected.attr('data-price');
                $input.val($price)
            } else {
                $input.val('');
            }
        });

        $('body').on('click', '.formConfirmDelete', function (event) {
            event.preventDefault();
            var form = $(this).closest('form');
            var nome = $(this).attr('data-nome');
            Swal.fire({
                title: 'Você tem certeza que deseja deletar a  tarefa \'' + nome + '\'?',
                text: "Você não poderá reverter isso!",
                type: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim, exclua!'
            }).then((result) => {
                if (result.value) {
                    form.submit()
                }
            })
        });

        $('#payment-form').on('submit', function (e) {
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
                    window.location.href = "{{ route('app.clients.processes.index',[$client->id, $clientProcess->id]) }}";
                    return;
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

        $('body').on('click', '.formConfirmDeletePayment', function (event) {
            event.preventDefault();
            var form = $(this).closest('form');
            Swal.fire({
                title: 'Você tem certeza que deseja deletar ?',
                text: "Você não poderá reverter isso!",
                type: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim, exclua!'
            }).then((result) => {
                if (result.value) {
                    form.submit()
                }
            })
        });
    </script>
@endsection

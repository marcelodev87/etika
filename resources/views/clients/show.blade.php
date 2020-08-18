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
        @if($client->internal_code)
           {{$client->internal_code}} - {{ $client->name }}
        @else
            {{ $client->name }}
        @endif
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
            <h1>
                @if($client->internal_code)
                    {{ $client->internal_code }} - {{ $client->name }}
                @else
                    {{ $client->name }}
                @endif
            </h1>
        </div>
        <div class="col-md-6 text-right mb-1">
            <a href="{{ route('app.clients.members.index', $client->id) }}" class="btn btn-danger btn-sm">
                <i class="fa fa-plus"></i> Diretoria
            </a>
            <a href="#modal-processes" data-toggle="modal" class="btn btn-success btn-sm">
                <i class="fa fa-plus"></i> Processos
            </a>
            <a href="#modal-tasks" data-toggle="modal" class="btn btn-primary btn-sm">
                <i class="fa fa-plus"></i> Tarefas
            </a>

            <a href="#modal-subscriptions" data-toggle="modal" class="btn btn-default btn-sm">
                <i class="fa fa-plus"></i> Assinaturas
            </a>

            <a href="{{ route('app.clients.mandatos.index', $client->id) }}"  class="btn btn-info btn-sm">
                <i class="fa fa-ribbon"></i> Mandatos
            </a>

        </div>

        {{-- assinaturas --}}
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3>Assinaturas</h3>
                </div>
                <div class="panel-body">
                    @if($client->subscriptions()->count())
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>Plano</th>
                                <th>Valor</th>
                                <th>Data contratação</th>
                                <th>Data termino</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($client->subscriptions()->orderBy('id','desc')->get() as $sub)
                                <tr>
                                    <td>{{ $sub->subscription->name }}</td>
                                    <td>{{ brl($sub->price) }}</td>
                                    <td>{{ $sub->created_at->format('d/m/Y H:i:s') }}</td>
                                    <td>
                                        @if(!$sub->active)
                                            {{ $sub->terminate_at->format('d/m/Y H:i:s') }}
                                        @endif
                                    </td>
                                    <td class="text-right">
                                        <a href="{{ route('app.clients.subscriptions.show', [$client->id, $sub->id]) }}" class="btn btn-xs btn-default" data-toggle="tooltip" data-placement="bottom" title="Pagamentos">
                                            <i class="fa fa-dollar-sign"></i>
                                        </a>

                                        @if($sub->active)
                                            <a href="{{ route('app.clients.subscriptions.close', [$client->id, $sub->id]) }}" class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="bottom" title="Fechar assinatura" onclick="return confirm('Deseja mesmo fazer isso?')">
                                                <i class="fa fa-power-off"></i>
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @else
                        <h4 class="text-center m-bot-0">Não há nenhuma assinatura</h4>
                    @endif
                </div>
            </div>
        </div>

        {{-- processos --}}
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
                                <td>
                                    <a href="{{ route('app.clients.processes.index',[$client->id, $process->id]) }}">{{ $process->process->name }}</a>
                                </td>
                                <td class="text-center">
                                    {{ $process->tasks()->where('closed', 1)->count() }} / {{ $process->tasks()->count() }}
                                </td>
                                <td>{{ brl($process->totalPrice()) }}</td>
                                <td>{{ brl($process->totalPayed()) }}</td>
                                <td class="text-center">
                                    <i class="fa fa-{{ ($process->closed) ? 'check text-success' : 'times text-danger' }}"></i>
                                </td>
                                <td class="text-right">
                                    <button type="button" class="btn btn-xs btn-success" onclick="showHistory({{$process->id}})">
                                        <i class="fa fa-history"></i>
                                    </button>
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

        {{-- tarefas --}}
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3>Tarefas</h3>
                </div>
                <div class="panel-body">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Tarefa</th>
                            <th>Responsável</th>
                            <th>Dt Entrega</th>
                            <th>Dt Entregue</th>
                            <th><i class="fa fa-comments"></i></th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($client->tasks as $task)
                            <tr>
                                <td>{{ $task->id }}</td>
                                <td>{{ $task->task->name }}</td>
                                <td>{{ $task->responsible->name }}</td>
                                <td class="{{ $task->isLate() ? 'text-danger text-bold' : '' }}">{{ $task->end_at->format('d/m/y H:i:') }}00</td>
                                <td>
                                    @if($task->closed)
                                        {{ $task->closed_at->format('d/m/Y H:i:s') }} ({{ $task->closedBy()->name }})
                                    @endif
                                </td>
                                <td>{{ $task->comments()->count()}}</td>
                                <td class="text-right">
                                    @if(!$task->closed)
                                        <a href="{{ route('app.clients.tasks.done',[$client->id, $task->id]) }}" class="btn btn-xs btn-success" onclick="return confirm('Deseja realmente finalizar?')">
                                            <i class="fa fa-check"></i> Finalizar
                                        </a>
                                    @endif
                                    <a href="#modal-comment" data-toggle="modal" data-client-task="{{ $task->id }}" class="btn btn-default btn-xs">
                                        <i class="fa fa-plus"></i> Comentário
                                    </a>
                                    <a href="javascript:void(0)" class="btn btn-primary btn-xs" onclick="showComments({{ $task->id }})">
                                        <i class="fa fa-eye"></i> Comentário
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <div class="sidebar-right-blank hide">
        <div class="header">
            <h3>Comentários</h3>
            <a href="javascript:void(0)" onclick="hideComments()" class="text-danger">
                <i class="fa fa-times"></i>
            </a>
        </div>
        <div class="body">

        </div>
    </div>


@endsection

@section('modal')
    @include('clients.modals.processCreate')
    @include('clients.modals.tasksCreate')
    @include('clients.modals.commentCreate')
    @include('clients.modals.subscriptionCreate')
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

        $('#select-tasks').on('change', function () {
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

        $('#form-task').on('submit', function (e) {
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
                    $button.removeAttr('disabled').html($buttonText);
                }
            });
        });

        function showComments(task) {
            const $block = $('.sidebar-right-blank');
            var $endpoint = "{{ route('app.clients.tasks.comments.index', [$client->id, ':TASK']) }}";
            $endpoint = $endpoint.replace(':TASK', task);
            $.get($endpoint, function (response) {
                $.each(response.data, function (i, e) {
                    console.log(e);
                    var $html = '';
                    $html += '<div class="panel panel-default">';
                    $html += '<div class="panel-heading">';
                    $html += '<h4><b>' + e.user + ' - ' + e.date + '</b></h4>';
                    $html += '</div>';
                    $html += '<div class="panel-body">' + e.comment ;
                    $html += '<div class="files">';

                    $.each(e.files, function (x, z) {
                        $html += '<a href="' + z + '" class="btn btn-xs btn-default" target="_blank">';
                        $html += '<i class="fa fa-paperclip"></i> Anexo';
                        $html += '</a>';
                    })

                    $html += '</div>';
                    $html += '</div>';
                    $html += '</div>';
                    console.log($html)
                    $block.find('.body').append($html);
                });
            })

            $block.find('h3').html('Comentários');
            $block.removeClass('hide');
        }

        function showHistory(process) {
            const $block = $('.sidebar-right-blank');
            var $endpoint = "{{ route('app.clients.processes.history', [$client->id, ':PROCESS']) }}";
            $endpoint = $endpoint.replace(':PROCESS', process);
            $.get($endpoint, function (response) {
                $.each(response.data, function (i, e) {
                    console.log(e);
                    var $html = '';
                    $html += '<div class="panel panel-default">';
                    $html += '<div class="panel-heading">';
                    $html += '<h4><b>' + e.user + ' - ' + e.date + '</b></h4>';
                    $html += '</div>';
                    $html += '<div class="panel-body">' + e.comment;
                    $html += '<div class="files">';

                    $.each(e.files, function (x, z) {
                        $html += '<a href="' + z + '" class="btn btn-xs btn-default" target="_blank">';
                        $html += '<i class="fa fa-paperclip"></i> Anexo';
                        $html += '</a>';
                    })

                    $html += '</div>';
                    $html += '</div>';
                    $html += '</div>';
                    $block.find('.body').append($html);
                });
            });
            $block.find('h3').html('Histórico');
            $block.removeClass('hide');
        }

        $('#modal-comment').on('show.bs.modal', function (e) {
            var $button = e.relatedTarget;
            var $taskId = $($button).attr('data-client-task')
            $('#form-comment').find('[name="task_id"]').val($taskId);
        })

        $('.summernote').summernote({
            height: 180,
            toolbar: [
                // [groupName, [list of button]]
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']],
                ['misc', ['codeview']]
            ]
        });

        $('#form-comment').on('submit', function (e) {
            e.preventDefault();
            var $form = $(this);
            var $button = $form.find('button[type="submit"]');
            var $buttonText = $button.html();
            var $data = new FormData($form[0]);
            var $endpoint = $form.attr('action').replace(':TASK', $form.find('[name="task_id"]').val());
            $.ajax({
                url: $endpoint,
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
                    window.location.reload();
                    return;

                },
                error: (response) => { // aqui vai o que acontece quando ocorrer o erro
                    var json = $.parseJSON(response.responseText);
                    alert(json.message);
                    $button.removeAttr('disabled').html($buttonText);
                },
            });
        });

        $('#select-subscription').on('change', function () {
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
        });

        $('#form-subscription').on('submit', function (e) {
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
                    window.location.reload();
                    return;

                },
                error: (response) => { // aqui vai o que acontece quando ocorrer o erro
                    var json = $.parseJSON(response.responseText);
                    alert(json.message);
                    $button.removeAttr('disabled').html($buttonText);
                },
            });
        });
    </script>
@endsection

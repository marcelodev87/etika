@extends('layouts.app')

@section('header')
    @breadcrumb(['title' => 'Clientes'])
    <li>
        <a href="{!! route('app.index') !!}">
            <i class="fa fa-th"></i> Dashboard
        </a>
    </li>
    <li class="active">
        <i class="fa fa-users"></i> Clientes
    </li>
    @endbreadcrumb
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12 text-right mb-1">
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-form-cadastrar">
                Criar
            </button>
        </div>
        <div class="col-md-12">
            <div class="chart-box">
                <div class="bs-example" data-example-id="hoverable-table">
                    <table class="table table-hover table-striped" id="datatable">
                        <thead>
                        <tr>
                            <th>Codigo interno</th>
                            <th>Nome Completo</th>
                            <th>Documento</th>
                            <th>Tipo</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($clients as $client)
                            <tr>
                                <td>{{ $client->internal_code ?? "Não vinculado" }}</td>
                                <td>{{ $client->name }}</td>
                                <td>{{ $client->document }}</td>
                                <td>{{ $client->type }}</td>
                                <td class="text-right">
                                    <a href="{!! route('app.clients.show', $client->id) !!}" class="btn btn-xs btn-primary" data-toggle="tooltip" data-placement="left" title="Ver"><i class="fa fa-eye"></i></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    {{-- Modal de criação --}}
    <div class="modal fade" tabindex="-1" role="dialog" id="modal-form-cadastrar">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Cadastro</h4>
                </div>
                <form action="{{ route('app.clients.store') }}" method="post" id="form-cadastrar">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-xs-12 col-md-sm-6 col-md-4 col-lg-3">
                                <fieldset class="form-group">
                                    <label>Codigo Interno</label>
                                    <input class="form-control" name="internal_code" type="text">
                                </fieldset>
                            </div>

                            <div class="col-md-xs-12 col-md-sm-6 col-md-6 col-lg-9 ">
                                <fieldset class="form-group">
                                    <label>Nome Completo</label>
                                    <input class="form-control" name="name" type="text">
                                </fieldset>
                            </div>

                            <div class="col-md-xs-12 col-md-sm-6 col-md-4 col-lg-9">
                                <fieldset class="form-group">
                                    <label>Documento</label>
                                    <input class="form-control document-mask" name="document" type="text">
                                </fieldset>
                            </div>

                            <div class="col-md-xs-12 col-md-sm-6 col-md-4 col-lg-3">
                                <fieldset class="form-group">
                                    <label>Tipo</label>
                                    <select class="form-control" name="type">
                                        <option value="">Selecione</option>
                                        <option value="Igreja">Igreja</option>
                                        <option value="Empresa">Empresa</option>
                                        <option value="Pessoa Física">Pessoa Física</option>
                                    </select>
                                </fieldset>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-warning" data-dismiss="modal">Fechar</button>
                        <button type="submit" class="btn btn-primary">Cadastrar</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    {{-- Modal de criação --}}

@endsection

@section('script')
    <script type="text/javascript">

        $("#form-cadastrar").on('submit', function (e) {
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
                    window.location.href = "{{ route('app.clients.index') }}";

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

        $("#datatable").dataTable();
    </script>
@endsection

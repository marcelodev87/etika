@extends('layouts.app')

@section('header')
    @breadcrumb(['title' => 'Membros'])
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
        <a href="{!! route('app.clients.show', $client->id) !!}">
            {{ $client->name }}
        </a>
    </li>
    <li class="active">
        <i class="fa fa-users"></i> Membros
    </li>
    @endbreadcrumb
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12 text-right mb-1">
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-form-cadastrar">
                Novo Membro
            </button>
        </div>
        <div class="col-md-12">
            <div class="chart-box">
                <div class="bs-example" data-example-id="hoverable-table">
                    <table class="table table-hover table-striped">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Nome Completo</th>
                            <th>Documento</th>
                            <th>Email</th>
                            <th>Telefone</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($client->members as $member)
                            <tr data-tr-member="{{ $member->id }}">
                                <td>{{ $member->id }}</td>
                                <td>{{ $member->name }}</td>
                                <td>{{ $member->document }}</td>
                                <td>{{ $member->email }}</td>
                                <td>{{ $member->phone }}</td>
                                <td class="text-right">
                                    <a href="javascript:void(0);" data-modal="#modal-show" data-member="{{ $member->id }}" class="btn btn-xs btn-info" data-toggle="tooltip" data-placement="bottom" title="Informações">
                                        <i class="fa fa-user"></i>
                                    </a>
                                    <a href="javascript:void(0);" data-modal="#modal-edit" data-member="{{ $member->id }}" class="btn btn-xs btn-primary" data-toggle="tooltip" data-placement="bottom" title="Editar">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <a href="javascript:void(0);" data-modal="#modal-addresses" data-member="{{ $member->id }}" class="btn btn-xs btn-default" data-toggle="tooltip" data-placement="bottom" title="Endereços">
                                        <i class="fa fa-map-marker-alt"></i>
                                    </a>
                                    <a href="javascript:void(0);" data-modal="#modal-emails" data-member="{{ $member->id }}" class="btn btn-xs btn-default" data-toggle="tooltip" data-placement="bottom" title="E-mails">
                                        <i class="fa fa-envelope"></i>
                                    </a>
                                    <a href="javascript:void(0);" data-modal="#modal-phones" data-member="{{ $member->id }}" class="btn btn-xs btn-default" data-toggle="tooltip" data-placement="bottom" title="Telefones">
                                        <i class="fa fa-phone"></i>
                                    </a>

                                    <form class="form-inline member-delete" method="post" action="{{ route('app.clients.members.delete',[$client->id, $member->id]) }}">
                                        <button type="submit" class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="bottom" title="Deletar">
                                            <i class="fa fa-trash"></i>
                                        </button>
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


    {{-- Modal de criação --}}
    <div class="modal fade" tabindex="-1" role="dialog" id="modal-form-cadastrar">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Novo Membro</h4>
                </div>
                <form action="{{ route('app.clients.members.store', $client->id) }}" method="post" id="form-cadastrar">
                    <div class="modal-body">
                        <div class="row">

                            <div class="col-md-xs-12 col-md-sm-6 col-md-8 col-lg-8">
                                <fieldset class="form-group">
                                    <label>Nome Completo</label>
                                    <input class="form-control" name="name" type="text">
                                </fieldset>
                            </div>

                            <div class="col-md-xs-12 col-md-sm-6 col-md-4 col-lg-4">
                                <fieldset class="form-group">
                                    <label>Documento</label>
                                    <input class="form-control" name="document" type="text" data-mask="000.000.000-00">
                                </fieldset>
                            </div>

                            <div class="col-md-xs-12 col-md-sm-6 col-md-4 col-lg-3">
                                <fieldset class="form-group">
                                    <label>Cargo</label>
                                    <input class="form-control" name="role" type="text">
                                </fieldset>
                            </div>

                            <div class="col-md-xs-12 col-md-sm-6 col-md-4 col-lg-3">
                                <fieldset class="form-group">
                                    <label>Sexo</label>
                                    <select class="form-control" name="gender">
                                        <option value="">Selecione</option>
                                        <option value="Feminino">Feminino</option>
                                        <option value="Masculino">Masculino</option>
                                    </select>
                                </fieldset>
                            </div>

                            <div class="col-md-xs-12 col-md-sm-6 col-md-4 col-lg-3">
                                <fieldset class="form-group">
                                    <label>Estado Civil</label>
                                    <input class="form-control" name="marital_status" type="text">
                                </fieldset>
                            </div>

                            <div class="col-md-xs-12 col-md-sm-6 col-md-4 col-lg-3">
                                <fieldset class="form-group">
                                    <label>Profissão</label>
                                    <input class="form-control" name="profession" type="text">
                                </fieldset>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-warning btn-sm" data-dismiss="modal">Fechar</button>
                        <button type="submit" class="btn btn-primary btn-sm">Cadastrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- Modal de criação --}}


    {{-- Modal de endereços--}}
    <div class="modal fade" tabindex="-1" role="dialog" id="modal-addresses">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Endereços</h4>
                </div>

                <div class="modal-body">
                    <div class="row collapse" id="address-create">
                        <form method="post" action="" id="modal-form-address">
                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                <div class="form-group">
                                    <label for="zip">CEP</label>
                                    <input type="text" name="zip" class="form-control" data-mask="00000-000" id="zip">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-1">
                                <div class="form-group">
                                    <label for="state">UF</label>
                                    <input type="text" name="state" class="form-control" data-mask="AA" id="state">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-4">
                                <div class="form-group">
                                    <label for="city">Cidade</label>
                                    <input type="text" name="city" class="form-control" id="city">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-4">
                                <div class="form-group">
                                    <label for="neighborhood">Bairro</label>
                                    <input type="text" name="neighborhood" class="form-control" id="neighborhood">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-7">
                                <div class="form-group">
                                    <label for="street">Logradouro</label>
                                    <input type="text" name="street" class="form-control" id="street">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-2">
                                <div class="form-group">
                                    <label for="street_number">Número</label>
                                    <input type="text" name="street_number" class="form-control" data-mask="000000" id="street_number">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                                <div class="form-group">
                                    <label for="complement">Complemento</label>
                                    <input type="text" name="complement" class="form-control" id="complement">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-sm btn-success btn-block">
                                        <i class="fa fa-save"></i> Salvar
                                    </button>
                                </div>
                            </div>

                        </form>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <a href="#address-create" class="btn btn-sm btn-default btn-block" data-toggle="collapse">
                                <i class="fa fa-plus"></i> Adicionar
                            </a>

                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>CEP</th>
                                    <th>UF</th>
                                    <th>CIDADE</th>
                                    <th>BAIRRO</th>
                                    <th>LOGRADOURO</th>
                                    <th>Nº</th>
                                    <th>COMPLEMENTO</th>
                                    <th class="text-center">PADRÃO</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning btn-sm" data-dismiss="modal">
                        <i class="fa fa-times"></i> Fechar
                    </button>
                </div>
            </div>
        </div>
    </div>
    {{-- Modal de endereços--}}

    {{-- Modal de emails --}}
    <div class="modal fade" tabindex="-1" role="dialog" id="modal-emails">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">E-mails</h4>
                </div>

                <div class="modal-body">
                    <div class="row collapse" id="emails-create">
                        <form method="post" action="" id="modal-form-emails">
                            <div class="col-xs-12 col-sm-8 col-md-9 col-lg-10">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" name="email" class="form-control" id="email">
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-4 col-md-3 col-lg-2">
                                <div class="form-group" style="margin-top: 23px">
                                    <button type="submit" class="btn btn-sm btn-success btn-block">
                                        <i class="fa fa-save"></i> Salvar
                                    </button>
                                </div>
                            </div>

                        </form>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <a href="#emails-create" class="btn btn-sm btn-info btn-block" data-toggle="collapse">
                                <i class="fa fa-plus"></i> Adicionar
                            </a>

                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>Email</th>
                                    <th class="text-center">PADRÃO</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning btn-sm" data-dismiss="modal">
                        <i class="fa fa-times"></i> Fechar
                    </button>
                </div>
            </div>
        </div>
    </div>
    {{-- Modal de emails --}}

    {{-- Modal de phones--}}
    <div class="modal fade" tabindex="-1" role="dialog" id="modal-phones">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Telefones</h4>
                </div>

                <div class="modal-body">
                    <div class="row collapse" id="phones-create">
                        <form method="post" action="" id="modal-form-phones">
                            <div class="col-xs-12 col-sm-8 col-md-9 col-lg-10">
                                <div class="form-group">
                                    <label for="phone">Telefone</label>
                                    <input type="text" name="phone" class="form-control phone-mask" id="phone">
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-4 col-md-3 col-lg-2">
                                <div class="form-group" style="margin-top: 23px">
                                    <button type="submit" class="btn btn-sm btn-success btn-block">
                                        <i class="fa fa-save"></i> Salvar
                                    </button>
                                </div>
                            </div>

                        </form>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <a href="#phones-create" class="btn btn-sm btn-info btn-block" data-toggle="collapse">
                                <i class="fa fa-plus"></i> Adicionar
                            </a>

                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>Número</th>
                                    <th class="text-center">PADRÃO</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning btn-sm" data-dismiss="modal">
                        <i class="fa fa-times"></i> Fechar
                    </button>
                </div>
            </div>
        </div>
    </div>
    {{-- Modal de phones--}}

    {{-- Modal de edit--}}
    <div class="modal fade" tabindex="-1" role="dialog" id="modal-edit">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Editar</h4>
                </div>
                <form method="post" action="" id="modal-form-edit">
                    @method('put')
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-xs-12 col-md-sm-6 col-md-8 col-lg-8">
                                <fieldset class="form-group">
                                    <label>Nome Completo</label>
                                    <input class="form-control" name="name" type="text">
                                </fieldset>
                            </div>

                            <div class="col-md-xs-12 col-md-sm-6 col-md-4 col-lg-4">
                                <fieldset class="form-group">
                                    <label>Documento</label>
                                    <input class="form-control" name="document" type="text" data-mask="000.000.000-00">
                                </fieldset>
                            </div>

                            <div class="col-md-xs-12 col-md-sm-6 col-md-4 col-lg-4">
                                <fieldset class="form-group">
                                    <label>Cargo</label>
                                    <input class="form-control" name="role" type="text">
                                </fieldset>
                            </div>

                            <div class="col-md-xs-12 col-md-sm-6 col-md-4 col-lg-4">
                                <fieldset class="form-group">
                                    <label>Estado Civil</label>
                                    <input class="form-control" name="marital_status" type="text">
                                </fieldset>
                            </div>

                            <div class="col-md-xs-12 col-md-sm-6 col-md-4 col-lg-4">
                                <fieldset class="form-group">
                                    <label>Profissão</label>
                                    <input class="form-control" name="profession" type="text">
                                </fieldset>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success btn-sm">
                            <i class="fa fa-sync"></i> Alterar
                        </button>
                        <button type="button" class="btn btn-warning btn-sm" data-dismiss="modal">
                            <i class="fa fa-times"></i> Fechar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- Modal de edit--}}

    {{-- Modal de show--}}
    <div class="modal fade" tabindex="-1" role="dialog" id="modal-show">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Informações</h4>
                </div>

                <div class="modal-body">
                    <div id="modal-show-area">
                        <p>Nome Completo: <span class="persona-name"></span></p>

                        <p>Documento: <span class="persona-document"></span></p>

                        <p>Cargo: <span class="persona-role"></span></p>

                        <p>Sexo: <span class="persona-gender"></span></p>

                        <p>Estado Civil: <span class="persona-marital_status"></span></p>

                        <p>Profissão: <span class="persona-profession"></span></p>

                        <div>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Email</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody id="tb-emails"></tbody>
                            </table>
                        </div>

                        <div style="margin-top: 7px">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Telefone</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody id="tb-phones"></tbody>
                            </table>
                        </div>

                        <div style="margin-top: 7px">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Cep</th>
                                        <th>Estado</th>
                                        <th>Cidade</th>
                                        <th>Bairro</th>
                                        <th>Rua</th>
                                        <th>Número</th>
                                        <th>Complemeto</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody id="tb-addresses"></tbody>
                            </table>
                        </div>
                    </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-warning btn-sm" data-dismiss="modal">
                        <i class="fa fa-times"></i> Fechar
                    </button>
                </div>
            </div>
        </div>
    </div>
    {{-- Modal de show--}}



@endsection

@section('script')
    <script type="text/javascript">
        var $member = null;
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
                    window.location.href = "{{ route('app.clients.members.index', $client->id) }}";

                },
                error: (response) => { // aqui vai o que acontece quando ocorrer o erro
                    var json = $.parseJSON(response.responseText);
                    setTimeout(() => {
                        alert(json.message);
                    }, 100)
                },
                complete: () => { // aqui vai o que acontece quando tudo acabar
                    $button.removeAttr('disabled').html($buttonText);
                }
            });
        });

        // ADDRESSES
        // OPEN MODAL
        $('[data-modal="#modal-addresses"]').on('click', function (e) {
            e.preventDefault();
            var $target = $(e.currentTarget);
            var $modal = $($target.attr('data-modal'));
            $member = $target.attr('data-member');
            var $linkGet = "{{ route('app.clients.members.addresses.index',[$client->id, ':MEMBER']) }}".replace(":MEMBER", $member);
            var $linkStore = "{{ route('app.clients.members.addresses.store',[$client->id, ':MEMBER']) }}".replace(":MEMBER", $member);
            $('#modal-form-address').attr('action', $linkStore);
            $.get($linkGet, function (response) {
                var $table = $('#modal-addresses').find('table').find('tbody');
                $table.html('');
                var $html = ''
                $.each(response.data, function (i, e) {
                    $html += '<tr>';
                    $html += '<td>' + e.zip + '</td>';
                    $html += '<td>' + e.state + '</td>';
                    $html += '<td>' + e.city + '</td>';
                    $html += '<td>' + e.neighborhood + '</td>';
                    $html += '<td>' + e.street + '</td>';
                    $html += '<td>' + e.number + '</td>';
                    $html += '<td>' + e.complement + '</td>';
                    if (e.main) {
                        $html += '<td class="text-center"><i class="fa fa-check text-success"></i></td>';
                    } else {
                        $html += '<td class="text-center"><i class="fa fa-times text-danger"></i></td>';
                    }
                    $linkDelete = "{{ route('app.clients.members.addresses.delete', [$client->id, ":MEMBER", ":ID"]) }}".replace(':MEMBER', $member).replace(':ID', e.id);
                    $html += '<td class="text-right">';
                    $html += '<form method="post" action="' + $linkDelete + '">';
                    $html += '@csrf'
                    $html += '<button class="btn btn-xs btn-danger address-form-delete" type="button">';
                    $html += '<i class="fa fa-trash"></i>';
                    $html += '</button>';
                    $html += '</form>';
                    $html += '</td>';
                    $html += '</tr>';
                });
                $table.append($html);
            });
            $modal.modal('show');
        });
        // SHOW FORM
        $('[href="#address-create"]').on('click', function () {
            var $link = $(this);
            setTimeout(() => {
                var $area = $('#address-create');
                if ($area.hasClass('in')) {
                    $link.removeClass('btn-default').addClass('btn-danger').html('<i class="fa fa-minus"></i> Fechar');
                } else {
                    $link.removeClass('btn-danger').addClass('btn-default').html('<i class="fa fa-plus"></i> Adicionar');
                }
            }, 500)
        });
        // SUBMIT FORM
        $('#modal-form-address').on('submit', function (e) {
            e.preventDefault();
            var $form = $(this);
            var $button = $form.find('button[type="submit"]');
            var $buttonText = $button.html();
            var $data = new FormData($form[0]);
            var $table = $form.closest('.modal-body').find('table').find('tbody');
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
                    var $html = ''
                    $html += '<tr>';
                    $html += '<td>' + response.data.zip + '</td>';
                    $html += '<td>' + response.data.state + '</td>';
                    $html += '<td>' + response.data.city + '</td>';
                    $html += '<td>' + response.data.neighborhood + '</td>';
                    $html += '<td>' + response.data.street + '</td>';
                    $html += '<td>' + response.data.number + '</td>';
                    $html += '<td>' + response.data.complement + '</td>';
                    if (response.data.main) {
                        $html += '<td class="text-center"><i class="fa fa-check text-success"></i></td>';
                    } else {
                        $html += '<td class="text-center"><i class="fa fa-times text-danger"></i></td>';
                    }
                    $linkDelete = "{{ route('app.clients.members.addresses.delete', [$client->id, ":MEMBER", ":ID"]) }}".replace(':MEMBER', $member).replace(':ID', response.data.id);
                    $html += '<td class="text-right">';
                    $html += '<form method="post" action="' + $linkDelete + '">';
                    $html += '<button class="btn btn-xs btn-danger address-form-delete" type="button">';
                    $html += '<i class="fa fa-trash"></i>';
                    $html += '</button>';
                    $html += '</form>';
                    $html += '</td>';
                    $html += '</tr>';
                    $table.append($html);

                },
                error: (response) => { // aqui vai o que acontece quando ocorrer o erro
                    var json = $.parseJSON(response.responseText);
                    setTimeout(() => {
                        alert(json.message);
                    }, 100)
                },
                complete: () => { // aqui vai o que acontece quando tudo acabar
                    $button.removeAttr('disabled').html($buttonText);
                    $form.trigger('reset');
                }
            });
        });
        // DELETE ITEM
        $('body').on('click', '.address-form-delete', function (e) {
            e.preventDefault();
            var $form = $(this).closest('form');
            Swal.fire({
                title: 'Você tem certeza que deseja deletar o endereço?',
                text: "Você não poderá reverter isso!",
                type: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim, exclua!'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: $form.attr('action'),
                        type: 'DELETE',
                        dataType: 'json',
                        contentType: false,
                        processData: false,
                        cache: false,
                        success: (response) => { // aqui vai o que der certo
                            $form.closest('tr').remove();
                        },
                        error: (response) => { // aqui vai o que acontece quando ocorrer o erro
                            var json = $.parseJSON(response.responseText);
                            setTimeout(() => {
                                alert(json.message);
                            }, 100)
                        }
                    });
                }
            })
        });


        // E-MAILS
        // OPEN MODAL
        $('[data-modal="#modal-emails"]').on('click', function (e) {
            e.preventDefault();
            var $target = $(e.currentTarget);
            var $modal = $($target.attr('data-modal'));
            $member = $target.attr('data-member');
            var $linkGet = "{{ route('app.clients.members.emails.index',[$client->id, ':MEMBER']) }}".replace(":MEMBER", $member);
            var $linkStore = "{{ route('app.clients.members.emails.store',[$client->id, ':MEMBER']) }}".replace(":MEMBER", $member);
            $('#modal-form-emails').attr('action', $linkStore);
            $.get($linkGet, function (response) {
                var $table = $modal.find('table').find('tbody');
                $table.html('');
                var $html = ''
                $.each(response.data, function (i, e) {
                    $html += '<tr>';
                    $html += '<td>' + e.email + '</td>';
                    if (e.main) {
                        $html += '<td class="text-center"><i class="fa fa-check text-success"></i></td>';
                    } else {
                        $html += '<td class="text-center"><i class="fa fa-times text-danger"></i></td>';
                    }
                    $linkDelete = "{{ route('app.clients.members.emails.delete', [$client->id,":MEMBER", ":ID"]) }}".replace(':MEMBER', $member).replace(':ID', e.id);
                    $html += '<td class="text-right">';
                    $html += '<form method="post" action="' + $linkDelete + '">';
                    $html += '@csrf'
                    $html += '<button class="btn btn-xs btn-danger emails-form-delete" type="button">';
                    $html += '<i class="fa fa-trash"></i>';
                    $html += '</button>';
                    $html += '</form>';
                    $html += '</td>';
                    $html += '</tr>';
                });
                $table.append($html);
            });
            $modal.modal('show');
        });
        // SHOW FORM
        $('[href="#emails-create"]').on('click', function () {
            var $link = $(this);
            setTimeout(() => {
                var $area = $('#emails-create');
                if ($area.hasClass('in')) {
                    $link.removeClass('btn-info').addClass('btn-danger').html('<i class="fa fa-minus"></i> Fechar');
                } else {
                    $link.removeClass('btn-danger').addClass('btn-info').html('<i class="fa fa-plus"></i> Adicionar');
                }
            }, 500)
        });
        // SUBMIT FORM
        $('#modal-form-emails').on('submit', function (e) {
            e.preventDefault();
            var $form = $(this);
            var $button = $form.find('button[type="submit"]');
            var $buttonText = $button.html();
            var $data = new FormData($form[0]);
            var $table = $form.closest('.modal-body').find('table').find('tbody');
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
                    var $html = ''
                    $html += '<tr>';
                    $html += '<td>' + response.data.email + '</td>';
                    if (response.data.main) {
                        $html += '<td class="text-center"><i class="fa fa-check text-success"></i></td>';
                    } else {
                        $html += '<td class="text-center"><i class="fa fa-times text-danger"></i></td>';
                    }
                    $linkDelete = "{{ route('app.clients.members.emails.delete', [$client->id, ':MEMBER', ":ID"]) }}".replace(':MEMBER', $member).replace(':ID', response.data.id);
                    $html += '<td class="text-right">';
                    $html += '<form method="post" action="' + $linkDelete + '">';
                    $html += '<button class="btn btn-xs btn-danger emails-form-delete" type="button">';
                    $html += '<i class="fa fa-trash"></i>';
                    $html += '</button>';
                    $html += '</form>';
                    $html += '</td>';
                    $html += '</tr>';
                    $table.append($html);

                },
                error: (response) => { // aqui vai o que acontece quando ocorrer o erro
                    var json = $.parseJSON(response.responseText);
                    setTimeout(() => {
                        alert(json.message);
                    }, 100)
                },
                complete: () => { // aqui vai o que acontece quando tudo acabar
                    $button.removeAttr('disabled').html($buttonText);
                }
            });
        });
        // DELETE ITEM
        $('body').on('click', '.emails-form-delete', function (e) {
            e.preventDefault();
            var $form = $(this).closest('form');
            Swal.fire({
                title: 'Você tem certeza que deseja deletar o endereço?',
                text: "Você não poderá reverter isso!",
                type: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim, exclua!'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: $form.attr('action'),
                        type: 'DELETE',
                        dataType: 'json',
                        contentType: false,
                        processData: false,
                        cache: false,
                        success: (response) => { // aqui vai o que der certo
                            $form.closest('tr').remove();
                        },
                        error: (response) => { // aqui vai o que acontece quando ocorrer o erro
                            var json = $.parseJSON(response.responseText);
                            setTimeout(() => {
                                alert(json.message);
                            }, 100)
                        }
                    });
                }
            })
        });


        // PHONES
        // OPEN MODAL
        $('[data-modal="#modal-phones"]').on('click', function (e) {
            e.preventDefault();
            var $target = $(e.currentTarget);
            var $modal = $($target.attr('data-modal'));
            $member = $target.attr('data-member');
            var $linkGet = "{{ route('app.clients.members.phones.index',[$client->id, ':MEMBER']) }}".replace(":MEMBER", $member);
            var $linkStore = "{{ route('app.clients.members.phones.store',[$client->id, ':MEMBER']) }}".replace(":MEMBER", $member);
            $('#modal-form-phones').attr('action', $linkStore);
            $.get($linkGet, function (response) {
                var $table = $modal.find('table').find('tbody');
                $table.html('');
                var $html = ''
                $.each(response.data, function (i, e) {
                    $html += '<tr>';
                    $html += '<td>' + e.phone + '</td>';
                    if (e.main) {
                        $html += '<td class="text-center"><i class="fa fa-check text-success"></i></td>';
                    } else {
                        $html += '<td class="text-center"><i class="fa fa-times text-danger"></i></td>';
                    }
                    $linkDelete = "{{ route('app.clients.members.phones.delete', [$client->id, ":MEMBER", ":ID"]) }}".replace(':MEMBER', $member).replace(':ID', e.id);
                    $html += '<td class="text-right">';
                    $html += '<form method="post" action="' + $linkDelete + '">';
                    $html += '@csrf'
                    $html += '<button class="btn btn-xs btn-danger phones-form-delete" type="button">';
                    $html += '<i class="fa fa-trash"></i>';
                    $html += '</button>';
                    $html += '</form>';
                    $html += '</td>';
                    $html += '</tr>';
                });
                $table.append($html);
            });
            $modal.modal('show');
        });
        // SHOW FORM
        $('[href="#phones-create"]').on('click', function () {
            var $link = $(this);
            setTimeout(() => {
                var $area = $('#phones-create');
                if ($area.hasClass('in')) {
                    $link.removeClass('btn-info').addClass('btn-danger').html('<i class="fa fa-minus"></i> Fechar');
                } else {
                    $link.removeClass('btn-danger').addClass('btn-info').html('<i class="fa fa-plus"></i> Adicionar');
                }
            }, 500)
        });
        // SUBMIT FORM
        $('#modal-form-phones').on('submit', function (e) {
            e.preventDefault();
            var $form = $(this);
            var $button = $form.find('button[type="submit"]');
            var $buttonText = $button.html();
            var $data = new FormData($form[0]);
            var $table = $form.closest('.modal-body').find('table').find('tbody');
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
                    var $html = ''
                    $html += '<tr>';
                    $html += '<td>' + response.data.phone + '</td>';
                    if (response.data.main) {
                        $html += '<td class="text-center"><i class="fa fa-check text-success"></i></td>';
                    } else {
                        $html += '<td class="text-center"><i class="fa fa-times text-danger"></i></td>';
                    }
                    $linkDelete = "{{ route('app.clients.members.phones.delete', [$client->id,":MEMBER", ":ID"]) }}".replace(':MEMBER', $member).replace(':ID', e.id);
                    $html += '<td class="text-right">';
                    $html += '<form method="post" action="' + $linkDelete + '">';
                    $html += '<button class="btn btn-xs btn-danger phones-form-delete" type="button">';
                    $html += '<i class="fa fa-trash"></i>';
                    $html += '</button>';
                    $html += '</form>';
                    $html += '</td>';
                    $html += '</tr>';
                    $table.append($html);

                },
                error: (response) => { // aqui vai o que acontece quando ocorrer o erro
                    var json = $.parseJSON(response.responseText);
                    setTimeout(() => {
                        alert(json.message);
                    }, 100)
                },
                complete: () => { // aqui vai o que acontece quando tudo acabar
                    $button.removeAttr('disabled').html($buttonText);
                }
            });
        });
        // DELETE ITEM
        $('body').on('click', '.phones-form-delete', function (e) {
            e.preventDefault();
            var $form = $(this).closest('form');
            Swal.fire({
                title: 'Você tem certeza que deseja deletar o endereço?',
                text: "Você não poderá reverter isso!",
                type: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim, exclua!'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: $form.attr('action'),
                        type: 'DELETE',
                        dataType: 'json',
                        contentType: false,
                        processData: false,
                        cache: false,
                        success: (response) => { // aqui vai o que der certo
                            $form.closest('tr').remove();
                        },
                        error: (response) => { // aqui vai o que acontece quando ocorrer o erro
                            var json = $.parseJSON(response.responseText);
                            setTimeout(() => {
                                alert(json.message);
                            }, 100)
                        }
                    });
                }
            })
        });

        // EDIT
        // OPEN MODAL
        $('[data-modal="#modal-edit"]').on('click', function (e) {
            e.preventDefault();
            var $target = $(e.currentTarget);
            var $modal = $($target.attr('data-modal'));
            var $member = $target.attr('data-member');
            var $linkGet = "{{ route('app.clients.members.show',[$client->id, ':MEMBER']) }}".replace(":MEMBER", $member);
            var $linkStore = "{{ route('app.clients.members.update',[$client->id, ':MEMBER']) }}".replace(":MEMBER", $member);
            var $form = $('#modal-form-edit');
            $form.attr('action', $linkStore);
            $.get($linkGet, function (response) {
                $form.find('input[name="name"]').val(response.data.name);
                $form.find('input[name="document"]').val(response.data.document);
                $form.find('input[name="role"]').val(response.data.role);
                $form.find('input[name="marital_status"]').val(response.data.marital_status);
                $form.find('input[name="profession"]').val(response.data.profession);
            });
            $modal.modal('show');
        });
        // SUBMIT FORM
        $('#modal-form-edit').on('submit', function (e) {
            e.preventDefault();
            var $form = $(this);
            var $button = $form.find('button[type="submit"]');
            var $buttonText = $button.html();
            var $data = new FormData($form[0]);
            var $table = null;
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
                    $table = $('[data-tr-member="' + response.data.id + '"]');
                    $.each($table.find('td'), function (i, e) {
                        switch (i) {
                            case 1:
                                $(e).html(response.data.name);
                                break;
                            case 2:
                                $(e).html(response.data.document)
                                break;
                            case 3:
                                $(e).html(response.data.role)
                                break;
                            case 4:
                                $(e).html(response.data.marital_status)
                                break;
                            case 5:
                                $(e).html(response.data.profession)
                                break;
                        }
                    })
                },
                error: (response) => { // aqui vai o que acontece quando ocorrer o erro
                    var json = $.parseJSON(response.responseText);
                    setTimeout(() => {
                        alert(json.message);
                    }, 100)
                },
                complete: () => { // aqui vai o que acontece quando tudo acabar
                    $button.removeAttr('disabled').html($buttonText);
                    $form.trigger('clear');
                    $($form.closest('.modal')).modal('hide');
                }
            });
        });

        // SHOW MEMBER
        $('[data-modal="#modal-show"]').on('click', function (e) {
            e.preventDefault();
            var $target = $(e.currentTarget);
            var $modal = $($target.attr('data-modal'));
            var $member = $target.attr('data-member');

            var $linkGet = "{{ route('app.clients.members.show', [$client->id,':MEMBER']) }}";
            var $area = $('#modal-show-area');

            $linkGet = $linkGet.replace(':MEMBER', $member);
            $.get($linkGet, function (response) {
                $area.find('.persona-name').html(response.data.persona.name);
                $area.find('.persona-document').html(response.data.persona.document);
                $area.find('.persona-role').html(response.data.persona.role);
                $area.find('.persona-gender').html(response.data.persona.gender);
                $area.find('.persona-marital_status').html(response.data.persona.marital_status);
                $area.find('.persona-profession').html(response.data.persona.profession);

                // Emails
                var $tbEmails = $area.find('#tb-emails');
                $tbEmails.html('');
                if(response.data.emails.length)
                {
                    $.each(response.data.emails, function(i, e){
                        var $type = (e.main) ? "check text-success" : "times text-danger";
                        var $icon = '<i class="fa fa-'+$type+'"></i>'
                        var $html = '<tr>';
                        $html += '<td>'+e.email+'</td>';
                        $html += '<td class="text-right">'+$icon+'</td>';
                        $html += '</tr>';
                        $tbEmails.append($html);
                    });
                }else{
                     var $html = '<tr>';
                        $html += '<td colspan="2">Não há emails registrados</td>';
                        $html += '</tr>';
                        $tbEmails.append($html);
                }

                // Telefones
                var $tbPhones = $area.find('#tb-phones');
                $tbPhones.html('');
                if(response.data.phones.length)
                {
                    $.each(response.data.phones, function(i, e){
                        var $type = (e.main) ? "check text-success" : "times text-danger";
                        var $icon = '<i class="fa fa-'+$type+'"></i>'
                        var $html = '<tr>';
                        $html += '<td>'+e.phone+'</td>';
                        $html += '<td text-right>'+$icon+'</td>';
                        $html += '</tr>';
                        $tbPhones.append($html);
                    });
                }else{
                     var $html = '<tr>';
                        $html += '<td colspan="2">Não há telefones registrados</td>';
                        $html += '</tr>';
                        $tbPhones.append($html);
                }

                // Endereços
                var $tbAddresses = $area.find('#tb-addresses');
                $tbAddresses.html('');
                if(response.data.addresses.length)
                {
                    $.each(response.data.addresses, function(i, e){
                        var $type = (e.main) ? "check text-success" : "times text-danger";
                        var $icon = '<i class="fa fa-'+$type+'"></i>'
                        var $html = '<tr>';
                        $html += '<td>'+e.zip+'</td>';
                        $html += '<td>'+e.state+'</td>';
                        $html += '<td>'+e.city+'</td>';
                        $html += '<td>'+e.neighborhood+'</td>';
                        $html += '<td>'+e.street+'</td>';
                        $html += '<td>'+e.number ?? ''+'</td>';
                        $html += '<td>'+e.complement ?? ''+'</td>';
                        $html += '<td text-right>'+$icon+'</td>';

                        $html += '</tr>';
                        $tbAddresses.append($html);
                    });
                }else{
                     var $html = '<tr>';
                        $html += '<td colspan="8">Não há endereços registrados</td>';
                        $html += '</tr>';
                        $tbAddresses.append($html);
                }

            });
            $modal.modal('show');
        });

        $('body').on('submit', '.member-delete', function (event) {
            event.preventDefault();
            var $form = $(this);
            Swal.fire({
                title: 'Você tem certeza que deseja deletar um membro?',
                text: "Você não poderá reverter isso!",
                type: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim, exclua!'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: $form.attr('action'),
                        type: 'DELETE',
                        dataType: 'json',
                        contentType: false,
                        processData: false,
                        cache: false,
                        success: (response) => { // aqui vai o que der certo
                            $form.closest('tr').remove();
                        },
                        error: (response) => { // aqui vai o que acontece quando ocorrer o erro
                            var json = $.parseJSON(response.responseText);
                            setTimeout(() => {
                                alert(json.message);
                            }, 100)
                        }
                    });
                }
            })
        });
    </script>
@endsection

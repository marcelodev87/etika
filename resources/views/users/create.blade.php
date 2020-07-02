@extends('layouts.app')

@section('header')
    @breadcrumb(['title' => 'Usuários'])
    <li>
        <a href="{!! route('app.index') !!}">
            <i class="fa fa-th"></i> Dashboard
        </a>
    </li>
    <li>
        <a href="{!! route('app.users.index') !!}">
            <i class="fa fa-users"></i> Usuários
        </a>
    </li>
    <li class="active">
        <i class="fa fa-plus"></i> Adicionar
    </li>
    @endbreadcrumb

@endsection

@section('content')
    <div class="row">
        <form action="{!! route('app.users.store') !!}" method="post" id="user-add-form">
            @csrf
            <div class="col-md-4 col-md-offset-4">
                <div class="chart-box">

                    <h4 class="text-center text-uppercase">Dados do Usuário</h4>
                    <hr>

                    <fieldset class="form-group">
                        <label>Nome Completo</label>
                        <input class="form-control" name="name" type="text">
                    </fieldset>

                    <fieldset class="form-group">
                        <label>Aniversário</label>
                        <input class="form-control" name="dob" type="date" style="line-height: 15px">
                    </fieldset>

                    <fieldset class="form-group">
                        <label>Gênero</label>
                        <input class="form-control" name="gender" type="text">
                    </fieldset>

                    <fieldset class="form-group">
                        <label>E-mail</label>
                        <input class="form-control" name="email" type="email">
                    </fieldset>

                    <div class="passwords">
                        <fieldset class="form-group">
                            <label>Senha</label>
                            <input class="form-control" name="password" type="password">
                        </fieldset>
                        <fieldset class="form-group">
                            <label>Confirmação da senha</label>
                            <input class="form-control" name="password_confirmation" type="password">
                        </fieldset>
                    </div>

                    <fieldset class="form-group">
                        <label class="checkbox" style="margin-left: 20px">
                            <input name="emailPassword" type="checkbox"/>
                            <i></i> Enviar por e-mail
                        </label>
                    </fieldset>
                    <div class="text-center">
                        <a href="{!! route('app.users.index') !!}" class="btn btn-xs btn-default">
                            <i class="fa fa-reply"></i> Voltar
                        </a>

                        <button type="submit" class="btn btn-xs btn-success">
                            <i class="fa fa-save"></i> Salvar
                        </button>
                    </div>

                    <div class="alert-blockquote" style="display: none">
                        <hr>
                        <blockquote>
                            <small>Ao cadastrar um usuário será gerada uma senha e enviada ao e-mail
                                cadastrado.</small>
                        </blockquote>
                    </div>

                </div>
            </div>
        </form>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        var blockquote = $('.alert-blockquote');
        var passwords = $('.passwords');
        $('[name="emailPassword"]').on('change', function () {

            if ($(this).is(':checked')) {
                passwords.slideToggle();
                blockquote.slideToggle();
            } else {
                passwords.slideToggle();
                blockquote.slideToggle();
            }
        });

        $('#user-add-form').on('submit', function (e) {
            e.preventDefault();
            var form = $(this);
            var data = new FormData(form[0]);
            var button = form.find('button[type="submit"]');
            var buttonText = button.html();
            $.ajax({
                url: form.attr('action'),
                type: form.attr('method'),
                data: data,
                processData: false,
                contentType: false,
                beforeSend: function () {
                    button.html('<i class="fas fa-spinner fa-pulse"></i> Aguarde...');
                    button.attr('disabled', 'disabled');
                },
                success: function (response) {
                    button.html(buttonText);
                    button.removeAttr('disabled');
                    form.trigger('reset');
                    passwords.slideToggle();
                    blockquote.slideToggle();
                    Swal('Tudo certo', response.message, 'success');

                },
                error: function (response) {
                    var err = JSON.parse(response.responseText);
                    button.html(buttonText);
                    button.removeAttr('disabled');
                    Swal('Oops', err.error, 'error');
                }
            })
        })
    </script>
@endsection

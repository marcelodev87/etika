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

@section('style')
    <style>
        .chart-box {
            margin-bottom: 14px;
        }
    </style>
@endsection

@section('content')

    <div class="row">
        <div class="col-md-4">
            <form method="post" action="{{ route('app.documents.generations.estatutoEpiscopal') }}">
                @csrf
                <div class="chart-box">

                    <div class="form-group">
                        <label>Igreja</label>
                        <select class="form-control selectpicker" name="client_id" required>
                            <option value="">Selecione a Igreja</option>
                            @foreach(\App\Client::where('type', 'igreja')->get() as $user)
                                <option value="{{$user->id}}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Sede</label>
                        <select name="sede" class="form-control selectpicker">
                            <option value="provisória" selected>Provisória</option>
                            <option value="definitiva">Definitiva</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Data de fundação da Igreja</label>
                        <input type="text" class="form-control" name="data_fundacao" data-mask="00/00/0000" placeholder="dd/mm/aaaa">
                    </div>
                    <div class="form-group">
                        <label>Mencionar membros fundadores?</label>
                        <input type="text" class="form-control" name="fundadores">
                    </div>

                    <div class="form-group">
                        <label>Haverá conselho fiscal?</label>
                        <select class="form-control selectpicker" name="conselho" required>
                            <option value="0" selected>Não</option>
                            <option value="1">Sim</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Haverá vice residente?</label>
                        <select class="form-control selectpicker" name="vice" required>
                            <option value="0">Não, o tesoureiro ocupará o cargo em caso de vacância</option>
                            <option value="1">Sim</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Tesoureiro</label>
                        <select class="form-control selectpicker outputMembers" name="tesouraria" required>
                            <option value="1" selected>Tesoureiro</option>
                            <option value="2">1º e 2º Tesoureiro</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Secretario</label>
                        <select class="form-control selectpicker" name="secretaria" required>
                            <option value="1" selected>Secretário</option>
                            <option value="2">1º e 2º Secretário</option>
                            <option value="0">Sem Secretário</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Madato do presidente:</label>
                        <select class="form-control selectpicker" name="m_presidente" required>
                            <option value="100" selected>Vitalício</option>
                            <option value="200">Indeterminado</option>
                            @for($i=1; $i<= 15; $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Madato da diretoria:</label>
                        <select class="form-control selectpicker" name="m_diretoria" required>
                            @for($i=1; $i<= 15; $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>

                    <div class="form-group">
                        <label>As movimentações financeiras serão feitas pelo:</label>
                        <select class="form-control selectpicker" name="m_financeiras" required>
                            <option value="1" selected>Pelo presidente, de forma isolada</option>
                            <option value="2">Pelo Tesoureiro e pelo Presidente, em conjunto</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Escolha os cargos ministeriais que a igreja terá: Todas as igrejas já terão a função de pastor!</label>
                        @php
                            $cargos = ['Apóstolo', 'Bispo', 'Diácono', 'Dirigente', 'Evangelista', 'Missionário', 'Obreiro', 'Presbítero'];
                        @endphp
                        <select class="form-control selectpicker" name="cargom[]" multiple>
                            <option value="">Selecione</option>
                            @foreach($cargos as $cargo)
                                <option value="{{ $cargo }}">{{ $cargo }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Os membros do ministério serão remunerados por suas funções Eclesiáticas?</label>
                        <select class="form-control selectpicker" name="remuneracao" required>
                            <option value="1" selected>Sim, em todos os casos</option>
                            <option value="2">Sim, apenas em casos de trabalho integral com registro em carteira</option>
                            <option value="3">Não, todo trabalho ministerial será considerado voluntário</option>
                        </select>
                    </div>

                </div>

                <button type="submit" class="btn btn-success btn-block">
                    <i class="fa fa-print"></i> Gerar
                </button>
            </form>
        </div>

        <div class="col-md-8">
            <div class="chart-box">
                <div id="output"></div>
            </div>
        </div>
    </div>


@endsection


@section('script')
    <script type="text/javascript">
        $('form').on('submit', function (e) {
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
                    $('#output').html(response.html);

                },
                error: (response) => { // aqui vai o que acontece quando ocorrer o erro
                    var json = $.parseJSON(response.responseText);
                    alert(json.message);
                },
                complete: () => { // aqui vai o que acontece quando tudo acabar
                    $button.removeAttr('disabled').html($buttonText);
                }
            });
        })
    </script>
@endsection

@extends('layouts.app')

@section('header')
    @breadcrumb(['title' => 'Painel'])
    <li class="active"><i class="fa fa-th"></i> Painel</li>
    @endbreadcrumb
@endsection

@section('content')

    @include('widgets.open')
        <div class="row">
            <div class="col-md-12 pl-5">
                <h2>Geral</h2>
            </div>
            @include('widgets.boxes.clientsRegistred')
            @include('widgets.boxes.newClientsSubscription')
            @include('widgets.boxes.digitalCertificate')

        </div>
        <div class="row">
            <div class="col-md-12 pl-5">
                <h2 class="m-5">Legalização</h2>
            </div>
            @include('widgets.boxes.newProcesses')
            @include('widgets.boxes.closedProcesses')
            @include('widgets.boxes.closedProcesses30')
            @include('widgets.boxes.expiredTerms')
            @include('widgets.boxes.lawyerSignature')
            @include('widgets.boxes.sentProcesses')
        </div>

    @if(auth()->user()->hasRole('adm'))
        <div class="row">
            @include('widgets.charts.received')
        </div>
    @endif


    @endsection


@section('script')
    <script type="text/javascript">
        $.get('{{ route('app.api.charts.received') }}', function (response) {
            var ctx = document.getElementById('chartReceived');
            var chartReceived = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: response.periods,
                    datasets: [{
                        label: 'Recebido',
                        data: response.values,
                        backgroundColor: 'rgba(102, 204, 153, 0.4)',
                        borderColor: 'rgba(102, 204, 153, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                // Include a dollar sign in the ticks
                                callback: function (value, index, values) {
                                    return value.toLocaleString('pt-BR', {
                                        style: 'currency',
                                        currency: 'BRL',
                                        maximumSignificantDigits: 2
                                    });
                                }
                            }
                        }],
                    }
                }
            });
        });

        $.get('{{ route('app.api.widgets.clientsRegistred') }}', function (response) {
            $('.clientsRegistred').find('.count').html(response.total);
        })
        $.get('{{ route('app.api.widgets.newProcesses') }}', function (response) {
            $('.newProcesses').find('.count').html(response.total);
        })
        $.get('{{ route('app.api.widgets.closedProcesses') }}', function (response) {
            $('.closedProcesses').find('.count').html(response.total);
        })
        $.get('{{ route('app.api.widgets.closedProcesses30') }}', function (response) {
            $('.closedProcesses30').find('.count').html(response.total);
        })
        $.get('{{ route('app.api.widgets.newClientsSubscription') }}', function (response) {
            $('.newClientsSubscription').find('.count').html(response.total);
        })
        $.get('{{ route('app.api.widgets.expiredTerms') }}', function (response) {
            $('.expiredTerms').find('.count').html(response.total);
        })
        $.get('{{ route('app.api.widgets.digitalCertificate') }}', function (response) {
            $('.digitalCertificate').find('.count').html(response.total);
        })
        $.get('{{ route('app.api.widgets.lawyerSignature') }}', function (response) {
            $('.lawyerSignature').find('.count').html(response.total);
        })
        $.get('{{ route('app.api.widgets.sentProcesses') }}', function (response) {
            $('.sentProcesses').find('.count').html(response.total);
        })

    </script>
@endsection()

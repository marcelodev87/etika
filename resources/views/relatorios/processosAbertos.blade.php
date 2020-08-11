@extends('layouts.app')

@section('header')
    @breadcrumb(['title' => 'Relatórios'])
    <li>
        <a href="{!! route('app.index') !!}">
            <i class="fa fa-th"></i> Dashboard
        </a>
    </li>
    <li class="active">
        <i class="fa fa-copy"></i> Processos Abertos
    </li>
    @endbreadcrumb
@endsection
@section('content')
    <div class="chart-box">
        <table class="table table-hover table-striped" id="datatable">
            <thead>
            <tr>
                <th>Cliente</th>
                <th>Processo</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($processos as $processo)
                <tr>

                    <td>
                        <a href="{{ route('app.clients.show', $processo->client->id) }}">{{ $processo->client->name }}</a>
                    </td>
                    <td>{{ $processo->process->name }}</td>

                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection


@section('script')
    <script type="text/javascript">
        $("#datatable").dataTable();
    </script>
@endsection

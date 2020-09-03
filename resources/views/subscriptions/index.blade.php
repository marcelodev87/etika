@extends('layouts.app')

@section('header')
    @breadcrumb(['title' => 'Assinaturas'])
    <li>
        <a href="{!! route('app.index') !!}">
            <i class="fa fa-th"></i> Dashboard
        </a>
    </li>
    <li class="active">
        <i class="fa fa-file-signature"></i> Assinaturas
    </li>
    @endbreadcrumb
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12 text-right mb-1">
            <a href="{{ route('app.subscriptions.create') }}" class="btn btn-success btn-sm">
                <i class="fa fa-plus"></i> Adicionar
            </a>
        </div>

        <div class="col-md-6 collapse" id="create-subscription">
            <div class="chart-box">
                <form action="{{ route('app.subscriptions.store') }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Nome</label>
                                <input type="text" name="name" class="form-control" required minlength="4">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Valor</label>
                                <input type="text" class="form-control" name="value" data-mask="000.000,00" data-mask-reverse="true" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-xs btn-success">
                                <i class="fa fa-save"></i> Salvar
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-md-6 collapse" id="edit-subscription">
            <div class="chart-box">
                <form action="{{ route('app.subscriptions.update', ':SUB') }}">
                    @csrf
                    @method('put')
                    <input type="hidden" name="sub" value="">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Nome</label>
                                <input type="text" name="name" class="form-control" required minlength="4">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Valor</label>
                                <input type="text" class="form-control" name="value" data-mask="000.000,00" data-mask-reverse="true" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-xs btn-success">
                                <i class="fa fa-save"></i> Salvar
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-md-12">
            <div class="chart-box">
                <div class="bs-example" data-example-id="hoverable-table">
                    <table class="table table-hover table-striped" id="datatable">
                        <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Valor</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($subscriptions as $sub)
                            <tr>

                                <td>{{ $sub->name }}</td>
                                <td>{{ brl($sub->price) }}</td>
                                <td class="text-right">

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


        $("#datatable").dataTable();
    </script>
@endsection

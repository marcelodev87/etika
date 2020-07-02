@extends('layouts.app')

@section('header')
    @breadcrumb(['title' => 'Usuários'])
    <li><a href="{!! route('app.index') !!}"><i class="fa fa-th"></i> Dashboard</a></li>
    <li><a href="{!! route('app.users.index') !!}"><i class="fa fa-users"></i> Usuários</a></li>
    <li class="active"><i class="fa fa-edit"></i> Editar</li>
    <li class="active">{{ $user->name }}</li>
    @endbreadcrumb
@endsection

@section('content')
    <div class="row">
        <form action="{!! route('app.users.update', $user->id) !!}" method="post">
            @csrf
            @method('put')
            <div class="col-md-4 col-md-offset-4">
                <div class="chart-box">

                    <h4 class="text-center">Dados do Usuário</h4>

                    <fieldset class="form-group">
                        <label>Nome Completo</label>
                        <input class="form-control" name="name" type="text" value="{{ old('name', $user->name) }}">
                    </fieldset>

                    <fieldset class="form-group">
                        <label>Aniversário</label>
                        <input class="form-control" name="dob" type="date" value="{{ old('dob', ($user->dob) ? $user->dob->format('Y-m-d') : '')}}" style="line-height: 15px">
                    </fieldset>

                    <fieldset class="form-group">
                        <label>Gênero</label>
                        <input class="form-control" name="gender" type="text" value="{{ old('gender', $user->gender) }}">
                    </fieldset>

                    <fieldset class="form-group">
                        <label>E-mail</label>
                        <input class="form-control" name="email" type="email" value="{{ old('email', $user->email) }}">
                    </fieldset>

                    <fieldset class="form-group">
                        <label>Usuário ativo?</label>
                        <select class="form-control" name="status" style="padding: 5px 10px">
                            <option value="0" {{ (!$user->status) ? 'selected' : '' }}>Não</option>
                            <option value="1" {{ ($user->status) ? 'selected' : '' }}>Sim</option>
                        </select>
                    </fieldset>

                    <div class="text-right">
                        <a href="{!! route('app.users.index') !!}" class="btn btn-xs btn-default"><i class="fa fa-reply"></i>
                            Voltar</a>
                        <button type="submit" class="btn btn-xs btn-success"><i class="fa fa-save"></i> Salvar
                        </button>
                    </div>

                </div>
            </div>
        </form>
@endsection

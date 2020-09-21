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
                        <select class="form-control" name="gender">
                            <option value="Feminino" {{ (old('gender', $user->gender) == "Feminino") ? 'selected' : null }}>Feminino</option>
                            <option value="Masculino" {{ (old('gender', $user->gender) == "Masculino") ? 'selected' : null }}>Masculino</option>
                        </select>
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

                    <fieldset class="form-group">
                        <label>Papel</label>
                        <select name="role_id" class="form-control">
                            @if(auth()->user()->hasRole('adm'))
                                <option value="1" {{ (old('role_id', $user->hasRole('adm'))) ? 'selected' : '' }}>Administrador</option>
                            @endif
                            <option value="2" {{ (old('role_id', $user->hasRole('usr'))) ? 'selected' : '' }}>Usuário</option>
                        </select>
                    </fieldset>

                    <div class="row">
                        <div class="col-md-6">
                            <a href="{!! route('app.users.index') !!}" class="btn btn-sm btn-block btn-default">
                                <i class="fa fa-reply"></i> Voltar
                            </a>
                        </div>
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-sm btn-block btn-success">
                                <i class="fa fa-save"></i> Salvar
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        </form>
@endsection

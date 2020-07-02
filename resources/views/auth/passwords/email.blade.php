@extends('layouts.app')

@section('content')
    <div class="form-body" id="middleAuthBox">
        <form method="POST" action="{{ route('password.email') }}" class="col-form">
            @csrf
            <div class="col-logo">
                <a href="#">
                    <img alt="imagem de logo" src="{!! asset('img/logo-lg.png') !!}" class="img-responsive center-block"/>
                </a>
            </div>
            <fieldset>
                <section>
                    <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                        <label class="control-label">E-mail</label>
                        <input class="form-control" placeholder="E-mail" type="text" name="email" value="{{ old('email') }}"/>
                        @if ($errors->has('email'))
                            <span class="help-block" role="alert">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                </section>
            </fieldset>
            <footer class="text-right">
                <a href="{{ route('app.index') }}" class="btn btn-sm btn-default">
                    <i class="fa fa-reply"></i> Voltar
                </a>
                <button type="submit" class="btn btn-success btn-sm ">
                    <i class="fa fa-magic"></i> Recuperar senha
                </button>
            </footer>
        </form>
    </div>
@endsection

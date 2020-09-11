<html lang="pt-br">
<head>
    <meta charset="utf8">
</head>
<body style="background-color: #24252a; color:#fff">

<div>
    <img src="{{ $message->embed(public_path() . '/img/logo-lg.png') }}" alt="">
</div>

<div>
    <p>Olá {{ $name ?? "NAME" }},<br>segue senha para entrar no painel.</p>
    <p>Senha: <b>{{ $password ?? "SENHA" }}</b></p>
</div>
</body>
</html>

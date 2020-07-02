<html lang="pt-br">
<head>
    <meta charset="utf8">
</head>
<body style="background-color: black; color:#fff">

    <div>
        <img src="{{ $message->embed(public_path() . '/img/logo-lg.png') }}" alt="">
    </div>

    <div>
        <p>Olá {{ $name }},<br>segue o link para troca de senha solicitada.</p>
        <a href="{{ $link }}">{{ $link }}</a>
    </div>
</body>
</html>

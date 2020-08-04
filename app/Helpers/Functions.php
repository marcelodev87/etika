<?php

if (!function_exists('getAvatar')) {
    function getAvatar($user_id)
    {
        $user = \App\User::where('id', $user_id)->first();
        if ($user->avatar == null) {
            return asset('img/avatar-default.png');
        }
        return \Storage::url($user->avatar);
    }
}

if (!function_exists('getDob')) {
    function getDob($user_id)
    {
        $user = \App\User::where('id', $user_id)->first();
        return ($user->dob) ? $user->dob->format('Y-m-d') : null;
    }
}

if (!function_exists('brl')) {
    function brl($value, $flag = true)
    {
        $valor = number_format($value, 2, ',', '.');
        if ($flag) {
            return "R$ " . $valor;
        }
        return $valor;
    }
}

if (!function_exists('brlToNumeric')) {
    function brlToNumeric($value)
    {
        return str_replace([' ', 'R$', '.', ','], ['', '', '', '.'], $value);
    }
}


if (!function_exists('menuPath')) {
    function menuPath($path = [], $type = "active menu-open")
    {
        $routeNames = (array)$path;
        foreach ($routeNames as $routeName) {
            if (Route::is($routeName)) {
                return ' ' . $type;
            }
        }
        return '';
    }
}

if(!function_exists('numberIntegerToRoman')){
    function numberIntegerToRoman($num, $debug = false)
    {
        $n = intval($num);
        $nRoman = '';

        $default = array(
            'M'     => 1000,
            'CM'     => 900,
            'D'     => 500,
            'CD'     => 400,
            'C'     => 100,
            'XC'     => 90,
            'L'     => 50,
            'XL'     => 40,
            'X'     => 10,
            'IX'     => 9,
            'V'     => 5,
            'IV'     => 4,
            'I'     => 1,
        );

        foreach ($default as $roman => $number) {
            $matches = intval($n / $number);
            $nRoman .= str_repeat($roman, $matches);
            $n = $n % $number;
        }
        return $nRoman;
    }
}
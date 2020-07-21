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

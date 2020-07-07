<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Auth::routes();

Route::group(['as' => 'app.', 'middleware' => ['auth', 'role']], function () {

    # página inicial
    Route::get('/', ['uses' => 'DashboardController@index', 'as' => 'index', 'roles' => ['adm', 'usr']]);

    # rota de usuários
    Route::group(['prefix' => 'usuarios', 'as' => 'users.'], function () {
        # screens
        Route::get('/', ['uses' => 'UserController@index', 'as' => 'index', 'roles' => ['dev', 'adm']]);
        Route::get('/adicionar', ['uses' => 'UserController@create', 'as' => 'create', 'roles' => ['dev', 'adm']]);
        Route::get('/{user}/editar', ['uses' => 'UserController@edit', 'as' => 'edit', 'roles' => ['dev', 'adm']]);

        # methods
        Route::post('/', ['uses' => 'UserController@store', 'as' => 'store', 'roles' => ['dev', 'adm']]);
        Route::put('/{user}', ['uses' => 'UserController@update', 'as' => 'update', 'roles' => ['dev', 'adm']]);
        Route::patch('/{user}/status', ['uses' => 'UserController@changeStatus', 'as' => 'updateStatus', 'roles' => ['dev', 'adm']]);
        Route::delete('/{user}', ['uses' => 'UserController@destroy', 'as' => 'delete', 'roles' => ['dev', 'adm']]);

    });

    # rota de perfil
    Route::group(['prefix' => 'perfil', 'as' => 'profile.'], function () {
        # screens
        Route::get('/', ['uses' => 'ProfileController@index', 'as' => 'index']);

        # methods
        Route::patch('/change-avatar', ['uses' => 'ProfileController@changeAvatar', 'as' => 'update_avatar']);
        Route::patch('/change-password', ['uses' => 'ProfileController@changePassword', 'as' => 'update_password']);
        Route::put('/change-information', ['uses' => 'ProfileController@changeInformation', 'as' => 'update_information']);
        Route::patch('/change-email', ['uses' => 'ProfileController@changeEmail', 'as' => 'update_email']);

    });

    # rota de cliente
    Route::group(['prefix' => 'clientes', 'as' => 'clients.'], function () {
        Route::get('/', ['uses' => 'ClientController@index', 'as' => 'index']);
        Route::get('/{client}', ['uses' => 'ClientController@show', 'as' => 'show', 'roles' => ['adm']]);
        Route::post('/', ['uses' => 'ClientController@store', 'as' => 'store', 'roles' => ['adm']]);
        Route::put('/{client}', ['uses' => 'ClientController@update', 'as' => 'update', 'roles' => ['adm']]);

        Route::group(['prefix' => '{client}/membros', 'as' => 'members.'], function () {
            Route::get('/', ['uses' => 'ClientPersonaController@index', 'as' => 'index']);
            Route::post('/', ['uses' => 'ClientPersonaController@store', 'as' => 'store', 'roles' => ['adm']]);
            Route::get('/{clientPersona}', ['uses' => 'ClientPersonaController@show', 'as' => 'show', 'roles' => ['adm']]);
            Route::put('/{clientPersona}', ['uses' => 'ClientPersonaController@update', 'as' => 'update', 'roles' => ['adm']]);
            Route::delete('/{clientPersona}', ['uses' => 'ClientPersonaController@destroy', 'as' => 'delete', 'roles' => ['adm']]);

            // Address
            Route::group(['prefix' => '{clientPersona}/address', 'as' => 'addresses.'], function () {
                Route::get('/', ['uses' => 'ClientPersonaAddressController@index', 'as' => 'index']);
                Route::post('/', ['uses' => 'ClientPersonaAddressController@store', 'as' => 'store', 'roles' => ['adm']]);
                Route::delete('/{clientPersonaAddress}', ['uses' => 'ClientPersonaAddressController@destroy', 'as' => 'delete', 'roles' => ['adm']]);
            });

            // E-mails
            Route::group(['prefix' => '{clientPersona}/emails', 'as' => 'emails.'], function () {
                Route::get('/', ['uses' => 'ClientPersonaEmailController@index', 'as' => 'index']);
                Route::post('/', ['uses' => 'ClientPersonaEmailController@store', 'as' => 'store', 'roles' => ['adm']]);
                Route::delete('/{clientPersonaEmail}', ['uses' => 'ClientPersonaEmailController@destroy', 'as' => 'delete', 'roles' => ['adm']]);
            });

            // Phones
            Route::group(['prefix' => '{clientPersona}/phones', 'as' => 'phones.'], function () {
                Route::get('/', ['uses' => 'ClientPersonaPhoneController@index', 'as' => 'index']);
                Route::post('/', ['uses' => 'ClientPersonaPhoneController@store', 'as' => 'store', 'roles' => ['adm']]);
                Route::delete('/{clientPersonaPhone}', ['uses' => 'ClientPersonaPhoneController@destroy', 'as' => 'delete', 'roles' => ['adm']]);
            });



        });

    });

});

Route::get("/sair", function () {
    (Auth::check()) ? Auth::logout() : null;
    return redirect()->route('login');
});

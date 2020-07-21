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
        Route::get('/', ['uses' => 'UserController@index', 'as' => 'index', 'roles' => ['adm']]);
        Route::get('/adicionar', ['uses' => 'UserController@create', 'as' => 'create', 'roles' => ['adm']]);
        Route::get('/{user}/editar', ['uses' => 'UserController@edit', 'as' => 'edit', 'roles' => ['adm']]);

        # methods
        Route::post('/', ['uses' => 'UserController@store', 'as' => 'store', 'roles' => ['adm']]);
        Route::put('/{user}', ['uses' => 'UserController@update', 'as' => 'update', 'roles' => ['adm']]);
        Route::patch('/{user}/status', ['uses' => 'UserController@changeStatus', 'as' => 'updateStatus', 'roles' => ['adm']]);
        Route::delete('/{user}', ['uses' => 'UserController@destroy', 'as' => 'delete', 'roles' => ['adm']]);

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

        // membros
        Route::group(['prefix' => '{client}/membros', 'as' => 'members.'], function () {
            Route::get('/', ['uses' => 'ClientPersonaController@index', 'as' => 'index']);
            Route::post('/', ['uses' => 'ClientPersonaController@store', 'as' => 'store', 'roles' => ['adm']]);
            Route::get('/{clientPersona}', ['uses' => 'ClientPersonaController@show', 'as' => 'show', 'roles' => ['adm']]);
            Route::get('/{clientPersona}/information', ['uses' => 'ClientPersonaController@information', 'as' => 'information', 'roles' => ['adm']]);
            Route::put('/{clientPersona}', ['uses' => 'ClientPersonaController@update', 'as' => 'update', 'roles' => ['adm']]);
            Route::delete('/{clientPersona}', ['uses' => 'ClientPersonaController@destroy', 'as' => 'delete', 'roles' => ['adm']]);

            // Address
            Route::group(['prefix' => '{clientPersona}/address', 'as' => 'addresses.'], function () {
                Route::get('/', ['uses' => 'ClientPersonaAddressController@index', 'as' => 'index']);
                Route::post('/', ['uses' => 'ClientPersonaAddressController@store', 'as' => 'store', 'roles' => ['adm']]);
                Route::delete('/{clientPersonaAddress}', ['uses' => 'ClientPersonaAddressController@destroy', 'as' => 'delete', 'roles' => ['adm']]);
                Route::post('/{clientPersonaAddress}/main', ['uses' => 'ClientPersonaAddressController@main', 'as' => 'main', 'roles' => ['adm']]);
            });

            // E-mails
            Route::group(['prefix' => '{clientPersona}/emails', 'as' => 'emails.'], function () {
                Route::get('/', ['uses' => 'ClientPersonaEmailController@index', 'as' => 'index']);
                Route::post('/', ['uses' => 'ClientPersonaEmailController@store', 'as' => 'store', 'roles' => ['adm']]);
                Route::delete('/{clientPersonaEmail}', ['uses' => 'ClientPersonaEmailController@destroy', 'as' => 'delete', 'roles' => ['adm']]);
                Route::post('/{clientPersonaEmail}/main', ['uses' => 'ClientPersonaEmailController@main', 'as' => 'main', 'roles' => ['adm']]);
            });

            // Phones
            Route::group(['prefix' => '{clientPersona}/phones', 'as' => 'phones.'], function () {
                Route::get('/', ['uses' => 'ClientPersonaPhoneController@index', 'as' => 'index']);
                Route::post('/', ['uses' => 'ClientPersonaPhoneController@store', 'as' => 'store', 'roles' => ['adm']]);
                Route::delete('/{clientPersonaPhone}', ['uses' => 'ClientPersonaPhoneController@destroy', 'as' => 'delete', 'roles' => ['adm']]);
                Route::post('/{clientPersonaPhone}/main', ['uses' => 'ClientPersonaPhoneController@main', 'as' => 'main', 'roles' => ['adm']]);
            });


        });

        // processos
        Route::group(['prefix' => '{client}/processos', 'as' => 'processes.'], function () {
            Route::get('/{clientProcess}', ['uses' => 'ClientProcessController@index', 'as' => 'index']);
            Route::post('/', ['uses' => 'ClientProcessController@store', 'as' => 'store']);

            // add task
            Route::post('/{clientProcess}/tasks', ['uses' => 'ClientProcessTaskController@store', 'as' => 'tasks.store']);
            Route::put('/{clientProcess}/tasks/{clientProcessTask}/done', ['uses' => 'ClientProcessTaskController@done', 'as' => 'tasks.done']);
            Route::delete('/{clientProcess}/tasks/{clientProcessTask}', ['uses' => 'ClientProcessTaskController@destroy', 'as' => 'tasks.delete']);

            // payment
            Route::post('/{clientProcess}/payments', ['uses' => 'ClientProcessPaymentController@store', 'as' => 'payments.store']);
            Route::delete('/{clientProcess}/payments/{clientProcessPayment}', ['uses' => 'ClientProcessPaymentController@destroy', 'as' => 'payments.delete']);

        });

        // tarefas
        Route::group(['prefix' => '{client}/tasks', 'as' => 'tasks.'], function () {
            Route::post('/', ['uses' => 'ClientTaskController@store', 'as' => 'store']);

            // Comentários
            Route::group(['prefix' => '{clientTask}/comments', 'as' => 'comments.'], function () {
                Route::get('/', ['uses' => 'ClientTaskCommentController@index', 'as' => 'index']);
                Route::post('/', ['uses' => 'ClientTaskCommentController@store', 'as' => 'store']);
            });
        });
    });

    # rota de processos internos
    Route::group(['prefix' => 'processos', 'as' => 'processes.'], function(){
        Route::get('', ['uses' => 'InternalProcessController@index', 'as' => 'index', 'roles' => ['adm']]);
        Route::get('/adicionar', ['uses' => 'InternalProcessController@create', 'as' => 'create', 'roles' => ['adm']]);
        Route::post('/', ['uses' => 'InternalProcessController@store', 'as' => 'store', 'roles' => ['adm']]);
        Route::get('/{internalProcess}/editar', ['uses' => 'InternalProcessController@edit', 'as' => 'edit', 'roles' => ['adm']]);
        Route::put('/{internalProcess}', ['uses' => 'InternalProcessController@update', 'as' => 'update', 'roles' => ['adm']]);
        Route::delete('/{internalProcess}', ['uses' => 'InternalProcessController@destroy', 'as' => 'delete', 'roles' => ['adm']]);

        Route::post('/{internalProcess}/attach-task', ['uses' => 'InternalProcessController@attachTask', 'as' => 'attach.task', 'roles' => ['adm']]);
        Route::delete('/{internalProcess}/detach-task', ['uses' => 'InternalProcessController@detachTask', 'as' => 'detach.task', 'roles' => ['adm']]);

        Route::put('/{internalProcess}/up', ['uses' => 'InternalProcessController@putUp', 'as' => 'task.up', 'roles' => ['adm']]);
        Route::put('/{internalProcess}/down', ['uses' => 'InternalProcessController@putDown', 'as' => 'task.down', 'roles' => ['adm']]);

    });

    # rota de tarefas internos
    Route::group(['prefix' => 'tarefas', 'as' => 'tasks.'], function(){
        Route::get('', ['uses' => 'InternalTaskController@index', 'as' => 'index', 'roles' => ['adm']]);
        Route::get('/adicionar', ['uses' => 'InternalTaskController@create', 'as' => 'create', 'roles' => ['adm']]);
        Route::post('/', ['uses' => 'InternalTaskController@store', 'as' => 'store', 'roles' => ['adm']]);
        Route::get('/{internalTask}/editar', ['uses' => 'InternalTaskController@edit', 'as' => 'edit', 'roles' => ['adm']]);
        Route::put('/{internalTask}', ['uses' => 'InternalTaskController@update', 'as' => 'update', 'roles' => ['adm']]);
        Route::delete('/{internalTask}', ['uses' => 'InternalTaskController@destroy', 'as' => 'delete', 'roles' => ['adm']]);
    });

    # rota de cartórios
    Route::group(['prefix' => 'cartorios', 'as' => 'notaryAddresses.'], function(){
        Route::get('', ['uses' => 'NotaryAddressController@index', 'as' => 'index', 'roles' => ['adm']]);
        Route::get('/adicionar', ['uses' => 'NotaryAddressController@create', 'as' => 'create', 'roles' => ['adm']]);
        Route::post('/', ['uses' => 'NotaryAddressController@store', 'as' => 'store', 'roles' => ['adm']]);
        Route::get('/{notaryAddress}/editar', ['uses' => 'NotaryAddressController@edit', 'as' => 'edit', 'roles' => ['adm']]);
        Route::put('/{notaryAddress}', ['uses' => 'NotaryAddressController@update', 'as' => 'update', 'roles' => ['adm']]);
        Route::delete('/{notaryAddress}', ['uses' => 'NotaryAddressController@destroy', 'as' => 'delete', 'roles' => ['adm']]);
    });
});

Route::get("/sair", function () {
    (Auth::check()) ? Auth::logout() : null;
    return redirect()->route('login');
});

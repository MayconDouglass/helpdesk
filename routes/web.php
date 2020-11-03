<?php

Route::get('/nopermission', function(){
    return view('nopermission'); 
})->name('semPermissao');


Route::get('/helpdesk', 'LoginClienteController@form')->name('login');
Route::post('/loginCliente', 'LoginClienteController@Login');

Route::get('/suporte', 'LoginSuporteController@form')->name('login');
Route::post('/suporte/login', 'LoginSuporteController@Login');

Route::group(['middleware' => ['auth']], function () {
    Route::get('dashboard/logout', function () {
        Auth::logout();
        return redirect()->action('LoginSuporteController@form');
    })->name('logoutSuporte');
    
    //usuarios
    Route::get('/suporte/usuarios', 'UserSuporteController@create')->name('usuarios');
    Route::post('/suporte/user/cad', 'UserSuporteController@store');
    Route::post('/suporte/user/att', 'UserSuporteController@update');
    Route::post('/suporte/user/reset', 'UserSuporteController@resetPassword');
    Route::post('/suporte/user/del', 'UserSuporteController@destroy');

    //cargos
    Route::get('/suporte/cargos', 'CargoController@create')->name('cargos');
    Route::post('/suporte/cargos/cad', 'CargoController@store');
    Route::post('/suporte/cargos/att', 'CargoController@update');
    Route::post('/suporte/cargos/del', 'CargoController@destroy');
    Route::post('/suporte/cargos/permissao', 'CargoController@atualizarPermissao'); 
    Route::post('/suporte/cargos/obterperm', 'CargoController@obterPermissaoCargo'); 
    Route::get('/suporte/cargos/role', 'CargoController@countRoleCargo'); 

    //categorias
    Route::get('/suporte/categorias', 'CategoriaController@create')->name('categorias');
    Route::post('/suporte/categorias/cad', 'CategoriaController@store');
    Route::post('/suporte/categorias/att', 'CategoriaController@update');
    Route::post('/suporte/categorias/del', 'CategoriaController@destroy');

    //classificacao
    Route::get('/suporte/classificacao', 'ClassificacaoController@create')->name('classificacao');
    Route::post('/suporte/class/cad', 'ClassificacaoController@store');
    Route::post('/suporte/class/att', 'ClassificacaoController@update');
    Route::post('/suporte/class/del', 'ClassificacaoController@destroy');

    //setores
    Route::get('/suporte/setor', 'SetorController@create')->name('setores');
    Route::post('/suporte/setor/cad', 'SetorController@store');
    Route::post('/suporte/setor/att', 'SetorController@update');
    Route::post('/suporte/setor/del', 'SetorController@destroy');

    //status
    Route::get('/suporte/status', 'StatusController@create')->name('status');
    Route::post('/suporte/status/cad', 'StatusController@store');
    Route::post('/suporte/status/att', 'StatusController@update');
    Route::post('/suporte/status/del', 'StatusController@destroy');

    //build list
    Route::get('/suporte/build', 'BuildListController@create')->name('buildlist');
    Route::post('/suporte/build/cad', 'BuildListController@store');
    Route::post('/suporte/build/att', 'BuildListController@update');
    Route::post('/suporte/build/del', 'BuildListController@destroy');


});



Route::group(['middleware' => ['cliente']], function () {
    Route::get('helpdesk/logout', function () {
        Auth::guard('client')->logout();
        return redirect()->action('LoginClienteController@form');
    })->name('logoutCliente');

    
});
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


});



Route::group(['middleware' => ['cliente']], function () {
    Route::get('helpdesk/logout', function () {
        Auth::guard('client')->logout();
        return redirect()->action('LoginClienteController@form');
    })->name('logoutCliente');

    
});
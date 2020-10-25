<?php

Route::get('/nopermission', function(){
    return view('nopermission'); 
})->name('semPermissao');

Route::get('/suporte', 'LoginSuporteController@form')->name('loginSup');
Route::post('/suporte/login', 'LoginSuporteController@Login');

Route::group(['middleware' => ['auth']], function () {
    Route::get('dashboard/logout', function () {
        Auth::logout();
        return redirect()->action('LoginSuporteController@form');
    })->name('logoutSuporte');



});


Route::get('/cliente', 'LoginClienteController@form')->name('loginCli');
Route::post('/loginCliente', 'LoginClienteController@Login');

Route::group(['middleware' => ['client']], function () {
    Route::get('helpdesk/logout', function () {
        Auth::guard('client')->logout();
        return redirect()->action('LoginClienteController@form');
    })->name('logoutCliente');



});
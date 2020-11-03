<?php

use Illuminate\Http\Request;

Route::group(['middleware' => ['api']], function () {
    Route::apiResource('usersup','api\\UserSuporteAPI');
    Route::apiResource('build','api\\BuildDetailAPI');
    Route::get('/build/detail/{id}', 'api\\BuildDetailAPI@showDetail');
    Route::post('/build/detail/{id}', 'api\\BuildDetailAPI@updateDetail');
    Route::post('/build/detail', 'api\\BuildDetailAPI@store');
    Route::post('/build/detail/d/{id}', 'api\BuildDetailAPI@destroy');
});

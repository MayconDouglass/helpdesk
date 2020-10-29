<?php

use Illuminate\Http\Request;

Route::group(['middleware' => ['api']], function () {
    Route::apiResource('usersup','api\\UserSuporteAPI');
});

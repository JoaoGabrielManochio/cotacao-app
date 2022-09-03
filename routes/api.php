<?php

use Illuminate\Http\Request;

Route::group(['prefix' => 'v1'], function () {

    Route::get('/ping', function () {
        return response()->json(['now' => date('Ymd H:i:s')]);
    });
});

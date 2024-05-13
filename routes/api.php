<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/chat', function (Request $request) {

    return json_encode($request->all());
});

<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

Route::post('/chat', function (Request $request) {
    return Http::post(env('CHATBOT_URL').'/chat/create',[
        'collection_name'=> $request->get('collection_name'),
        'message'=> $request->get('message')
    ]);
//    return json_encode($request->all());
});

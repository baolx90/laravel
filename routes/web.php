<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatBotController;
use App\Http\Controllers\VectorStoreController;

Route::controller(ChatBotController::class)->group(function () {
    Route::get('', 'index');
    Route::get('bot/{id}', 'show');
});

Route::prefix('admin')->group(function () {
   Route::resource('vector-store',VectorStoreController::class);
});

//  Route::get('/{any}', function () {
//      return view('app');
//  })->where('any', '^(?!api).*');

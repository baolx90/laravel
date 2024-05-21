<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatBotController;
use App\Http\Controllers\VectorStoreController;

 Route::resource('',VectorStoreController::class);
 Route::controller(ChatBotController::class)->group(function () {
 //    Route::get('', 'index');
     Route::get('bot/{code}', 'show');
     Route::get('widget/{code}', 'widget');
     Route::post('bot/{code}', 'store');
 });

//Route::prefix('admin')->group(function () {
//   Route::resource('vector-store',VectorStoreController::class);
//});


// Route::get('/{any}', function () {
//     return view('app');
// })->where('any', '^(?!api).*');

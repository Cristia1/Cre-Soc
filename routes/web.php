<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
// use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\HomeController;



Route::prefix('any')->group(function () {
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index']);
});


//  Route::get('/google', [GoogleController::class, 'loginWithGoogle'])->name('google');
//     Route::get('/google/callback', [GoogleController::class, 'handleGoogleCallback'])->name('google.callback');

Auth::routes();

Route::get('/{any}', function () {
    return view('home');
})->where('any', '.*');
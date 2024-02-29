<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
use App\Events\MessageNotification;

Route::prefix('api')->group(function () {

    
});


Route::get('/login', [LoginController::class, 'showLoginForm']);
Route::get('/auth/google', [LoginController::class, 'redirectToGoogle']);
Route::get('/auth/google/callback', [LoginController::class, 'handleGoogleCallback']);
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('event', function () {
    event(new MessageNotification('This is broadcast message!'));
});

Auth::routes();

Route::get('/{any}', function () {
    return view('layouts.app');
})->where('any', '.*');

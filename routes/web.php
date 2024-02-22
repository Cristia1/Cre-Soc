<?php


use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UserController;

Route::prefix('user')->group(function () {
    Route::get('/', 'App\Http\Controllers\UserController@index')->name('user.index');
});


Route::get('/login', [LoginController::class, 'showLoginForm']);
Route::get('/auth/google', [LoginController::class, 'redirectToGoogle']);
Route::get('/auth/google/callback', [LoginController::class, 'handleGoogleCallback']);

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
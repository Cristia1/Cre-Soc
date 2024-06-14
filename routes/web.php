<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
// use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;


Route::middleware(['api', 'auth'])->group(function () {
    // Photos Routes
        Route::get('/photos', [PhotoController::class, 'index']);
        Route::post('/photos', [PhotoController::class, 'store']);
        Route::get('/photos/{id}', [PhotoController::class, 'show']);
        Route::put('/photos/{id}', [PhotoController::class, 'update']);
    // End Routes

    //Profiles Routes
        Route::get('/Profile', [ProfileController::class, 'show'])->name('show');
        Route::get('/Profile/edit', [ProfileController::class, 'edit'])->name('edit');
        Route::post('/Profile/update', [ProfileController::class, 'update'])->name('update');  
        Route::post('/Profile', [ProfileController::class, 'store'])->name('store');
    // End Routes


    // Users Routes
    Route::get('/users', [UserController::class, 'index']);
    Route::get('/users/{id}', [UserController::class, 'show']);
    Route::put('/users/{id}', [UserController::class, 'update']);
    // End Routes


    Route::post('/logout', [LoginController::class, 'logout']);
    Auth::routes();
    Route::get('{any}', function () {
        return view('app');
    })->where('any', '.*');
});


Route::post('/login', [LoginController::class, 'login']);
// Route::get('/google/callback', [GoogleController::class, 'handleGoogleCallback']);
// Route::get('/google', [GoogleController::class, 'loginWithGoogle'])->name('google');
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);
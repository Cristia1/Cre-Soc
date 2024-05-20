<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\RegisterController;


Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Photos Routes
    Route::get('/photos', [PhotoController::class, 'index']);
    Route::post('/photos', [PhotoController::class, 'store']);
    Route::get('/photos/{id}', [PhotoController::class, 'show']);
    Route::put('/photos/{id}', [PhotoController::class, 'update']);
    // End Routes

    //Profiles Routes
    Route::get('/Profile', [ProfileController::class, 'show'])->name('Profile.show');
    Route::get('/Profile/edit', [ProfileController::class, 'edit'])->name('Profile.edit');
    Route::post('/Profile/update', [ProfileController::class, 'update'])->name('Profile.update');  
    Route::post('/Profile', [ProfileController::class, 'store'])->name('Profile.store');
    // End Routes


    Auth::routes();
    Route::get('/{any}', function () {
        return view('home');
    })->where('any', '.*');
});


Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/google/callback', [GoogleController::class, 'handleGoogleCallback']);
Route::get('/google', [GoogleController::class, 'loginWithGoogle'])->name('google');
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);
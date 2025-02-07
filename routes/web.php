<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RecipientController;
use App\Http\Controllers\SenderController;
use App\Http\Controllers\FriendController;
use App\Http\Controllers\ChatController;
use Illuminate\Support\Facades\Auth;


Route::middleware(['auth'])->group(function () {
    // Posts rutes
        Route::get('/posts', [PostController::class, 'openPost']);
    // Ends
    
    
    // Chats Routes
        Route::prefix('chat')->group(function () {
            Route::get('/{id}', [ChatController::class, 'index']);
            Route::post('/create', [ChatController::class, 'createChat']);
        });
    // End Routes


    // Photos Routes
        Route::get('/photo', [PhotoController::class, 'index']);
        Route::post('/photo', [PhotoController::class, 'store']);
        Route::get('/photo/{id}', [PhotoController::class, 'show']);
        Route::put('/photo/{id}', [PhotoController::class, 'update']);
        Route::delete('/photo/{id}', [PhotoController::class, 'destroy']);
        Route::get('/PhotoCover', [PhotoController::class, 'PhotoCover']);
        Route::get('/PhotoProfil', [PhotoController::class, 'PhotoProfil']);
        Route::post('/photos/{photo}/like', [LikeController::class, 'likePhoto'])->middleware('auth');
    // End Routes


    // Message Rutes
        Route::post('/send-message', [MessageController::class, 'sendMessage']);
        Route::get('/messages/{receiver_id}', [MessageController::class, 'getMessages']);
        Route::get('/user-messages', [MessageController::class, 'UserMessages']);
    // End


    // Friends Routes
        Route::get('/friends', [FriendController::class, 'getFriends']);
        Route::get('/getFriendRequests', [FriendController::class, 'getFriendRequests']);
        Route::post('/sendRequest', [FriendController::class, 'sendRequest']);
        Route::post('/acceptRequest', [FriendController::class, 'acceptRequest']);
        Route::post('/deleteRequest', [FriendController::class, 'deleteRequest']);
    // End Routes


    // Like Routes
        Route::post('/like/{itemType}/{id}', [LikeController::class, 'like']);
        Route::delete('/unlike/{itemType}/{id}', [LikeController::class, 'unlike']);
        Route::get('/likes/{itemType}/{id}', [LikeController::class, 'getLikes']);
    // End routes 

    
    //Profiles Routes
        Route::get('/user/{id}/photos', [ProfileController::class, 'getUserPhotos']);
        Route::get('/profile/{id}', [ProfileController::class, 'show']);
        Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('edit');
        Route::put('/profile/{id}', [ProfileController::class, 'update']);
        Route::post('/profile', [ProfileController::class, 'store']);
    // End Routes


    // Users Routes
        Route::get('/users', [UserController::class, 'index']);
        Route::get('/users/search', [UserController::class, 'search']);
        Route::get('/user/{id}', [UserController::class, 'show']);
        Route::get('/user/{id}/profile', [UserController::class, 'getUser'])->middleware('auth');
        Route::put('/user/{id}/update', [UserController::class, 'update']);
        Route::get('/user/{id}/friends', [UserController::class, 'getFriends'])->middleware('auth');
    // End Routes


    Route::post('/logout', [LoginController::class, 'logout']);
    Route::get('/google/callback', [GoogleController::class, 'handleGoogleCallback']);
    Route::get('/google', [GoogleController::class, 'loginWithGoogle'])->name('google');
    Auth::routes();
    Route::get('{any}', function () {
        return view('home');
    })->where('any', '.*');
});


Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);
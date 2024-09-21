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


Route::middleware(['api'])->group(function () {
    // Chats Routes
        Route::get('/chat/{id}', [ChatController::class, 'index']); 
        Route::post('/chat/create', [ChatController::class, 'createChat']);
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
        Route::get('/current-user', function () { return response()->json(['id' => Auth::id()]);});
    // End


    // Friends Routes
        Route::get('/friends', [FriendController::class, 'getFriends']);
        Route::post('/friendRequest/{friendId}', [FriendController::class, 'sendRequest']);
        Route::post('/friendRequest/accept/{friendId}', [FriendController::class, 'acceptRequest']);
    // End Routes


    // Like Routes
        Route::post('/like/{itemType}/{id}', [LikeController::class, 'like']);
        Route::delete('/unlike/{itemType}/{id}', [LikeController::class, 'unlike']);
        Route::get('/likes/{itemType}/{id}', [LikeController::class, 'getLikes']);
    // End routes 

    
    //Profiles Routes
        Route::get('/user/{id}/photos', [ProfileController::class, 'getUserPhotos']);
        Route::get('/profile/{id}', [ProfileController::class, 'show']);
        Route::get('/Profile/edit', [ProfileController::class, 'edit'])->name('edit');
        Route::post('/profile/{id}', [ProfileController::class, 'update']); 
        Route::post('/Profile', [ProfileController::class, 'store'])->name('store');
    // End Routes


    // Users Routes
    Route::get('/users', [UserController::class, 'index']);
    Route::get('/users/{id}', [UserController::class, 'show']);
    Route::put('/users/{id}', [UserController::class, 'update']);
    Route::get('/user', [UserController::class, 'getUser']);
    // End Routes


    Route::post('/logout', [LoginController::class, 'logout']);
    Auth::routes();
    Route::get('{any}', function () {
        return view('home');
    })->where('any', '.*');
});


Route::post('/login', [LoginController::class, 'login']);
Route::get('/google/callback', [GoogleController::class, 'handleGoogleCallback']);
Route::get('/google', [GoogleController::class, 'loginWithGoogle'])->name('google');
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);
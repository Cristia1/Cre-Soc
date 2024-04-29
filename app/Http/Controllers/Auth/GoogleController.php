<?php

namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\GoogleAccount; 
use Illuminate\Http\Request;


class GoogleController extends Controller
{
    // public function loginWithGoogle()
    // {
    //     return Socialite::driver('MainLayout')->redirect();
    // }



    // public function handleGoogleCallback()
    // {
    //     if (Auth::check()) {
            
    //         return redirect()->to('/MainLayout');
    //     }

    //     try {
    //         $user = Socialite::driver('google')->user();
    //     } catch (\Exception $e) {
    //         return redirect()->to('/login')->withErrors(['google' => 'Google authentication failed.']);
    //     }

    //     $existingUser = User::where('email', $user->email)->first();

    //     if ($existingUser) {
            
    //         $googleAccount = GoogleAccount::where('google_id', $user->id)->first();

    //         if ($googleAccount) {
    //             Auth::login($existingUser);
    //         } else {
    //             GoogleAccount::create([
    //                 'user_id' => $existingUser->id,
    //                 'google_id' => $user->id,
    //             ]);

    //             Auth::login($existingUser);
    //         }
    //     } else {
    //         $newUser = User::create([
    //             'name' => $user->name,
    //             'email' => $user->email,
    //             'google_id' => $user->id,
    //         ]);

    //         GoogleAccount::create([
    //             'user_id' => $newUser->id,
    //             'google_id' => $user->id,
    //         ]);

    //         Auth::login($newUser);
    //     }

    //     return redirect()->to('/MainLayout');
    // }

}
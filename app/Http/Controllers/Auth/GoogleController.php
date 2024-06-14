<?php

// namespace App\Http\Controllers\Auth;

// use App\Http\Controllers\Controller;
// use App\Models\User;
// use Illuminate\Support\Facades\Auth;
// use Laravel\Socialite\Facades\Socialite;
// use App\Models\GoogleAccount;
// use Illuminate\Http\Request;

// class GoogleController extends Controller
// {

//     public function loginWithGoogle()
//     {
//         return Socialite::driver('Profile')->redirect();
//     }


//     public function handleGoogleCallback()
//     {
//         $user = Socialite::driver('google')->user();
//         $existingUser = User::where('email', $user->email)->first();

//         if ($existingUser) {
//             Auth::login($existingUser);
//         } else {
//             $newUser = User::create([
//                 'name' => $user->name,
//                 'email' => $user->email,
//                 'google_id' => $user->id,
//             ]);
//             Auth::login($newUser);
//         }

//         return redirect()->to('/MainLayout');
//     }
// }
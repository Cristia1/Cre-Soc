<?php

namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;



class LoginController extends Controller
{
    
    public function showLoginForm()
    {
        return view('auth.login');
    }


    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }


    public function handleGoogleCallback()
    {
        $user = Socialite::driver('google')->user();

        $existingUser = User::where('email', $user->email)->first();

        if ($existingUser) {
            Auth::login($existingUser);
        } else {
            $newUser = User::create([
                'name' => $user->name,
                'email' => $user->email,
                'google_id' => $user->id,
                'password' => encrypt(value: '123123123')

            ]);

            Auth::login($newUser);
        }

        return redirect()->to('/home');
    }

    public function logout()
    {
        Auth::logout(); 

        return redirect('/login');
    }
}
<?php

namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\GoogleAccount; 


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
        if (Auth::check()) {
            return redirect('/dashboard');
        }

        try {
            $user = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect()->to('/login')->withErrors(['google' => 'Google authentication failed.']);
        }

        $existingUser = User::where('email', $user->email)->first();

        if ($existingUser) {
            
            $googleAccount = GoogleAccount::where('google_id', $user->id)->first();

            if ($googleAccount) {
                Auth::login($existingUser);
            } else {
                GoogleAccount::create([
                    'user_id' => $existingUser->id,
                    'google_id' => $user->id,
                ]);

                Auth::login($existingUser);
            }
        } else {
            $newUser = User::create([
                'name' => $user->name,
                'email' => $user->email,
                'google_id' => $user->id,
                'password' => encrypt('123123123'),
            ]);

            GoogleAccount::create([
                'user_id' => $newUser->id,
                'google_id' => $user->id,
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
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    
    public function showProfile()
    {
        $user = Auth::user();
        return view('profile', compact('user'));
    }


    public function editProfile()
    {
        $user = Auth::user();
        return view('edit-profile', compact('user'));
    }


    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        return redirect()->route('profile.show')->with('success', 'Profilul a fost actualizat cu succes!');
    }


    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}

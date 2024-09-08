<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Photo;
use App\Models\User;


class ProfileController extends Controller
{
    public function show($id)
    {
        dd('sasas');
        $user = User::with(['posts.comments', 'images'])->find($id);
        
        if ($user) {
            return response()->json([
                'success' => true,
                'user' => $user
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'User not found'
            ]);
        }
    }


    public function edit()
    {
        $profile = Auth::user();
        return response()->json(['user' => $profile]);
    }


    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        $user->save();

        return response()->json(['message' => 'Profile updated successfully.']);
    }


    public function getUserPhotos($id)
    {
        $photos = Photo::where('user_id', $id)->get();

        $photos = $photos->map(function ($photo) {
            // Verificăm dacă fișierul există
            if (Storage::exists($photo->image)) {
                $url = Storage::url($photo->image);
            } else {
                $url = '/default-image.png'; // Imagine implicită dacă fișierul nu există
            }

            return [
                'id' => $photo->id,
                'url' => $url
            ];
        });

        return response()->json(['photos' => $photos]);
    }
}

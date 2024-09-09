<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Photo;
use App\Models\User;
use App\Models\Profile;


class ProfileController extends Controller
{
    public function show($id)
    {
        $profile = Profile::where('user_id', $id)->first();
        $user = User::find($id);  
        if ($user) {
            return response()->json([
                'success' => true,
                'user' => $user,
                'profile' => $profile,
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


    public function update(Request $request, $id)
    {
        $request->validate([
            'city' => 'required|string|max:255',
            'work' => 'required|string|max:255',
            'birthdate' => 'required|date',
            'marital_status' => 'required|in:single,married,divorced,widowed',
            'education' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'gender' => 'required|in:male,female',
            'favorite_movies' => 'nullable|string',
            'favorite_sports' => 'nullable|string',
            'favorite_books' => 'nullable|string',
        ]);

        $profile = Profile::where('user_id', $id)->first();
        
        if (!$profile) {
            $profile = new Profile();
            $profile->user_id = $id;
        }

        $profile->fill($request->all());
        $profile->save();

        return response()->json([
            'success' => true,
            'profile' => $profile
        ]);
    }


    public function getUserPhotos($id)
    {
        $photos = Photo::where('user_id', $id)->get();

        $photos = $photos->map(function ($photo) {
            if (Storage::exists($photo->image)) {
                $url = Storage::url($photo->image);
            } else {
                $url = '/default-image.png'; 
            }

            return [
                'id' => $photo->id,
                'url' => $url
            ];
        });

        return response()->json(['photos' => $photos]);
    }
}

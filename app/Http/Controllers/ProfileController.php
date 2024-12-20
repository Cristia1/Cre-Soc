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
    public function show($id) {
        $profile = Profile::find($id);
        if ($profile) {
            return response()->json(['profile' => $profile], 200);
        } 
    }
    
    

    public function edit()
    {
        $profile = Auth::user();
        return response()->json(['user' => $profile]);
    }


    public function store(Request $request)
    {
        $request->validate([
            'photo' => 'required|file|mimes:jpg,jpeg,png|max:2048', 
            'title' => 'required|string|max:255',
        ]);

        $path = $request->file('photo')->store('photos');
        return response()->json(['path' => $path], 201);
    }


    public function update(Request $request, $id)
    {
        $profile = Profile::where('user_id', $id)->first();
        if (!$profile) {
            return response()->json(['success' => false, 'message' => 'Profile not found']);
        }

        $validatedData = $request->validate([
            'city' => 'nullable|string|max:255',
            'work' => 'nullable|string|max:255',
            'birthdate' => 'nullable|date',
            'marital_status' => 'nullable|string',
            'education' => 'nullable|string|max:255',
            'phone_number' => 'nullable|string|max:15',
            'gender' => 'nullable|string|in:male,female',
            'favorite_movies' => 'nullable|string',
            'favorite_sports' => 'nullable|string',
            'favorite_books' => 'nullable|string',
        ]);

        $profile->update($validatedData);
        return response()->json([
            'success' => true,
            'profile' => $profile,
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
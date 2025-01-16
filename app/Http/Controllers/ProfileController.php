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
        if ($profile) {
            return response()->json(['success' => true, 'profile' => $profile], 200);
        }
        
        return response()->json(['success' => false, 'message' => 'Profile not found'], 404);
    }
    

    public function edit()
    {
        $profile = Auth::user();
        return response()->json(['user' => $profile]);
    }


    public function store(Request $request)
    {
        if ($request->has('photo')) {
            $request->validate([
                'photo' => 'required|file|mimes:jpg,jpeg,png|max:2048',
                'title' => 'required|string|max:255',
            ]);

            $photoPath = $request->file('photo')->store('photos', 'public');
            Photo::create([
                'title' => $request->title,
                'photo_path' => $photoPath,
                'user_id' => auth()->id(),
            ]);

            return response()->json(['success' => true, 'message' => 'Photo uploaded successfully']);
        }

        $request->validate([
            'city' => 'nullable|string|max:255',
            'work' => 'nullable|string|max:255',
            'birthdate' => 'nullable|date',
            'marital_status' => 'nullable|string|in:single,married,divorced,widowed',
            'education' => 'nullable|string|max:255',
            'phone_number' => 'nullable|string|max:20',
            'gender' => 'nullable|string|in:male,female',
            'favorite_movies' => 'nullable|string',
            'favorite_sports' => 'nullable|string',
            'favorite_books' => 'nullable|string',
        ]);

        $profile = Profile::updateOrCreate(
            ['user_id' => auth()->id()],
            $request->only([
                'city', 'work', 'birthdate', 'marital_status', 'education',
                'phone_number', 'gender', 'favorite_movies', 'favorite_sports', 'favorite_books',
            ])
        );

        return response()->json(['success' => true, 'profile' => $profile]);
    }

    

    public function update(Request $request, $id)
    {
        if ($request->has('photo')) {
            $request->validate([
                'photo' => 'required|file|mimes:jpg,jpeg,png|max:2048',
                'title' => 'required|string|max:255',
            ]);

            $profile = Profile::findOrFail($id);
            $photoPath = $request->file('photo')->store('photos', 'public');
            
            $profile->update([
                'photo_path' => $photoPath,
                'title' => $request->title,
            ]);

            return response()->json(['success' => true, 'message' => 'Photo updated successfully', 'profile' => $profile]);
        }

        $request->validate([
            'city' => 'nullable|string|max:255',
            'work' => 'nullable|string|max:255',
            'birthdate' => 'nullable|date',
            'marital_status' => 'nullable|string|in:single,married,divorced,widowed',
            'education' => 'nullable|string|max:255',
            'phone_number' => 'nullable|string|max:20',
            'gender' => 'nullable|string|in:male,female',
            'favorite_movies' => 'nullable|string',
            'favorite_sports' => 'nullable|string',
            'favorite_books' => 'nullable|string',
        ]);

        $profile = Profile::findOrFail($id);

        $profile->update($request->only([
            'city', 'work', 'birthdate', 'marital_status', 'education',
            'phone_number', 'gender', 'favorite_movies', 'favorite_sports', 'favorite_books',
        ]));

        return response()->json(['success' => true, 'message' => 'Profile updated successfully', 'profile' => $profile]);
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
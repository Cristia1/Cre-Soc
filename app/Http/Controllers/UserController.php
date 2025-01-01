<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Photo;
use App\Models\Post;


class UserController extends Controller
{

    public function index(Request $request)
    {
        $query = $request->input('query');
        $users = User::where('name', 'like', "%$query%")->get(['id', 'name']);

        foreach ($users as $user) {
            $photo = Photo::where('user_id', $user->id)->where('type', 'profil')->first();
            if ($photo && Storage::exists($photo->image)) {
                $user->profilUrl = Storage::url($photo->image);
            } else {
                $user->profilUrl = '/default-profile.png'; 
            }
        }
        return response()->json(['success' => true, 'users' => $users]);
    }


    public function show($id)
    {

        $user = User::with(['profile', 'photos', 'friends', 'posts'])->find($id);

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'User not found'], 404);
        }
        
        return response()->json([
            'success' => true,
            'user' => $user,
            'profile' => $user->profile,
            'photos' => $user->photos,
            'friends' => $user->friends,
            'posts' => $user->posts,
        ]);
    }


    public function edit()
    {
        $user = Auth::user();
        return response()->json(['success' => true, 'user' => $user]);
    }


    public function update(Request $request, $id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'User not found'], 404);
        }
        
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $user->update($request->all());
        return response()->json(['success' => true, 'user' => $user]);
    }

    
    public function getUser()
    {
        $user = Auth::user();
        if ($user) {
            return response()->json(['success' => true, 'user' => $user]);
        } else {
            return response()->json(['success' => false, 'message' => 'No user logged in']);
        }
    }

    public function getFriends($id)
    {
        $user = User::find($id);
    
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'User not found'], 404);
        }

        $friends = $user->friends()->get(['friends.id as friend_id', 'users.name']);

        return response()->json([
            'success' => true,
            'friends' => $friends,
        ]);
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $users = User::where('name', 'like', "%{$query}%")
            ->with('photo')
            ->with('profile')
            ->get();
            $users = $users->map(function ($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'profilUrl' => $user->photo ? Storage::url($user->photo->image) : '/default-profile.png',
                ];
            });                    

        return response()->json(['success' => true, 'users' => $users]);
    }
}
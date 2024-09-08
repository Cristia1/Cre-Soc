<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Photo;


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

        // Returnăm răspunsul JSON cu utilizatorii și poza de profil
        return response()->json(['success' => true, 'users' => $users]);
}




    public function show($id)
    {
        $user = User::find($id);
        if ($user) {
            return response()->json(['success' => true, 'user' => $user]);
        } else {
            return response()->json(['success' => false, 'message' => 'User not found']);
        }
    }

    public function edit()
    {
        $user = Auth::user();
        return response()->json(['success' => true, 'user' => $user]);
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);
        if ($user) {
            $user->update($request->all());
            return response()->json(['success' => true, 'user' => $user]);
        } else {
            return response()->json(['success' => false, 'message' => 'User not found']);
        }
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
}
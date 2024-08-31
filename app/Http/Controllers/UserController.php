<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
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
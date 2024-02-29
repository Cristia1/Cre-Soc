<?php

namespace App\Http\Controllers;


use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Events\UpdateInterface;


class UserController extends Controller
{
    public function index()
    {
        $users = User::paginate(15);
        return response()->json($users);
    }


    protected function doubleAuth(Request $request)
    {
        $doubleAuth = $request->only($this->username(), 'password');
        
        if ($request->has('google_id')) {
            $doubleAuth['google_id'] = $request->input('google_id');
        }

        return $doubleAuth;
    }
       
}

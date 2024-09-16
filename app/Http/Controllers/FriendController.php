<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Friend;
use Illuminate\Support\Facades\Auth;

class FriendController extends Controller
{
    public function getFriends()
    {
        $user = Auth::user();
        $friends = $user->friends; 
        return response()->json($friends);
    }


    public function sendRequest($friendId)
    {
        $userId = Auth::id();
        
        $existingRequest = Friend::where(function ($query) use ($userId, $friendId) {
            $query->where('user_id', $userId)->where('friend_id', $friendId);
        })->orWhere(function ($query) use ($userId, $friendId) { $query->where('user_id', $friendId)
                  ->where('friend_id', $userId);})->first();

        if ($existingRequest) {
            return response()->json([
                'message' => 'Friend request already exists or you are already friends.'
            ], 400);
        }

        $friendRequest = new Friend();
        $friendRequest->user_id = $userId;
        $friendRequest->friend_id = $friendId;
        $friendRequest->status = 'pending';
        $friendRequest->save();

        return response()->json(['message' => 'Friend request sent successfully!'], 200);
    }


    public function acceptRequest($friendId)
    {
        $userId = Auth::id();
        $friendRequest = Friend::where('user_id', $friendId)
                                ->where('friend_id', $userId)
                                ->where('status', 'pending')
                                ->first();

        if (!$friendRequest) {
            return response()->json(['message' => 'Friend request not found.'], 404);
        }

        $friendRequest->status = 'confirmed';
        $friendRequest->save();
        
        $reverseRequest = Friend::where('user_id', $userId)
                                ->where('friend_id', $friendId)
                                ->first();

        if ($reverseRequest) {
            $reverseRequest->status = 'confirmed';
            $reverseRequest->save();
        }

        return response()->json(['message' => 'Friend request accepted.']);
    }
}

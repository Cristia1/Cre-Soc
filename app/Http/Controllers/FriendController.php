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

        $friends = $user->friends()->with(['sender', 'receiver'])->get();

        return response()->json($friends);
    }


    public function getFriendRequests()
    {
        $userId = Auth::id();
        $requests = Friend::where('friend_id', $userId)
                        ->where('status', 'pending')
                        ->with('sender') 
                        ->distinct()
                        ->get();

        return response()->json($requests);
    }



    public function sendRequest(Request $request) 
    {
        $userId = Auth::id(); 
        $friendId = $request->input('receiver_id'); 

        if (!$friendId || !is_numeric($friendId)) {
            return response()->json(['error' => 'Invalid friend ID'], 400);
        }

        $existingRequest = Friend::where(function ($query) use ($userId, $friendId) {
            $query->where('user_id', $userId)->where('friend_id', $friendId);
        })->orWhere(function ($query) use ($userId, $friendId) {
            $query->where('user_id', $friendId)->where('friend_id', $userId);
        })->first();

        if ($existingRequest) {
            return response()->json(['message' => 'Friend request already exists.'], 400);
        }

        $friendRequest = new Friend();
        $friendRequest->user_id = $userId;
        $friendRequest->friend_id = $friendId;
        $friendRequest->status = 'pending';
        $friendRequest->save();

        return response()->json(['message' => 'Friend request sent!'], 200);
    }

    


    public function acceptRequest(Request $request)
    {
        $request->validate([
            'sender_id' => 'required|exists:users,id'
        ]);

       $friendRequest = Friend::where('receiver_id', Auth::id())
        ->where('sender_id', $request->sender_id)
        ->where('status', 'pending')
        ->first();

        if (!$friendRequest) {
            return response()->json(['message' => 'Friend request not found.'], 404);
        }

        $friendRequest->update(['status' => 'accepted']);

        return response()->json(['message' => 'Friend request accepted.']);
    }


    public function deleteRequest(Request $request)
    {
        $request->validate([
            'sender_id' => 'required|exists:users,id'
        ]);

        FriendRequest::where('receiver_id', Auth::id())
            ->where('sender_id', $request->sender_id)
            ->where('status', 'pending')
            ->delete();

        return response()->json(['message' => 'Friend request deleted!']);
    }

}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Friend;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FriendController extends Controller
{
    public function getFriends()
    {
        $userId = Auth::id();

        $friends = Friend::where(function ($query) use ($userId) {
                $query->where('sender_id', $userId)->where('status', 'confirmed');
            })
            ->orWhere(function ($query) use ($userId) {
                $query->where('receiver_id', $userId)->where('status', 'confirmed');
            })
            ->with(['sender.photo', 'receiver.photo']) 
            ->get();

        $friendsList = $friends->map(function ($friend) use ($userId) {
            $friendUser = $friend->sender_id == $userId ? $friend->receiver : $friend->sender;

            $profilePicture = null;
            if ($friendUser->photo) {
                $profilePicture = Storage::url($friendUser->photo->image);
            }

            return [
                'id' => $friend->id,
                'name' => $friendUser->name,
                'profilePicture' => $profilePicture ?: asset('storage/default-profile.jpg'),
                'status' => $friend->status,
            ];
        });

        return response()->json($friendsList);
    }


    
    public function getFriendRequests()
    {
        $userId = Auth::id();

        $requests = Friend::where('receiver_id', $userId)
                          ->where('status', 'pending')
                          ->with('sender:id,name,profile_picture')
                          ->get();    
        return response()->json($requests);
    }
    


    public function sendRequest(Request $request)
    {
        $senderId = Auth::id();
        $receiverId = $request->input('receiver_id');
    
        if ($senderId == $receiverId) {
            return response()->json(['message' => 'You cannot send a friend request to yourself.'], 400);
        }
    
        $receiverExists = \App\Models\User::where('id', $receiverId)->exists();
        if (!$receiverExists) {
            return response()->json(['message' => 'User not found.'], 404);
        }
    
        $existingRequest = Friend::where(function ($query) use ($senderId, $receiverId) {
            $query->where('sender_id', $senderId)->where('receiver_id', $receiverId);
        })->orWhere(function ($query) use ($senderId, $receiverId) {
            $query->where('sender_id', $receiverId)->where('receiver_id', $senderId);
        })->first();
    
        if ($existingRequest) {
            if ($existingRequest->status === 'confirmed') {
                return response()->json(['message' => 'You are already friends.'], 400);
            }
            return response()->json(['message' => 'Friend request already exists.'], 400);
        }
    
        Friend::create([
            'sender_id' => $senderId,
            'receiver_id' => $receiverId,
            'status' => 'pending'
        ]);
    
        return response()->json(['message' => 'Friend request sent successfully!'], 200);
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

        $friendRequest->update(['status' => 'confirmed']);

        return response()->json(['message' => 'Friend request accepted.']);
    }


    public function deleteRequest(Request $request)
    {
        $request->validate([
            'request_id' => 'required|exists:friends,id'
        ]);

        $friendRequest = Friend::find($request->request_id);

        if (!$friendRequest) {
            return response()->json(['message' => 'Friend request not found.'], 404);
        }
        $friendRequest->delete();

        return response()->json(['message' => 'The friend request has been deleted.']);
    }
}
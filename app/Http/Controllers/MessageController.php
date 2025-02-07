<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\Profile;
use Illuminate\Support\Facades\Auth;



class MessageController extends Controller
{


    public function sendMessage(Request $request)
    {
        $user = Auth::user(); 
        $request->validate([
            'receiver_name' => 'required|string|exists:users,name', 
            'content' => 'required|string|max:500',
        ]);

        $receiver = \App\Models\User::where('name', $request->receiver_name)->firstOrFail();
        $message = Message::create([
            'sender_id' => $user->id,
            'receiver_id' => $receiver->id,
            'content' => $request->content,
            'read' => false, 
        ]);

        $message = Message::with('sender', 'receiver')->find($message->id);
        
        $messages = Message::where('receiver_id', $user->id)
            ->orWhere('sender_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->with('sender', 'receiver') 
            ->get();

        return response()->json([
            'success' => true,
            'messages' => $messages,
            'message' => $message, 
        ]);
    }




    public function UserMessages()
    {
        $user = Auth::user();

       $messages = Message::with(['sender', 'receiver']) 
        ->where('receiver_id', $user->id)
        ->orWhere('sender_id', $user->id)
        ->orderBy('created_at', 'desc')
        ->get();

        return response()->json([
            'success' => true,
            'user' => [
                'id' => $user->id, 
                'name' => $user->name, 
            ],
            'messages' => $messages,
            'count' => $messages->count(),
        ]);
    }
}

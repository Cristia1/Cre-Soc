<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{


    public function sendMessage(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'content' => 'required|string|max:500',
        ]);

        $message = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'content' => $request->content,
        ]);
        return response()->json(['success' => true, 'message' => $message]);
    }


    public function getMessages($receiver_id)
    {
        $sender_id = Auth::id();

        $messages = Message::where(function($query) use ($sender_id, $receiver_id) {
                $query->where('sender_id', $sender_id)
                      ->where('receiver_id', $receiver_id);
            })
            ->orWhere(function($query) use ($sender_id, $receiver_id) {
                $query->where('sender_id', $receiver_id)
                      ->where('receiver_id', $sender_id);
            })
            ->orderBy('created_at', 'asc')
            ->get();
        return response()->json(['success' => true, 'messages' => $messages]);
    }
}

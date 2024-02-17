<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $primaryKey = 'message_id';

    protected $fillable = [
        'user_id',
        'sender_id',
        'friend_id',
        'receiver_id',
        'content',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function sender()
    {
        return $this->belongsTo(Sender::class, 'sender_id');
    }

    public function recipient()
    {
        return $this->belongsTo(Recipient::class, 'recipient_id');
    }

    public function friend()
    {
        return $this->belongsTo(Friend::class, 'friend_id');
    }
}


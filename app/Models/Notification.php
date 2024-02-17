<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $primaryKey = 'notification_id';

    protected $fillable = [
        'user_id',
        'sender_id',
        'notifiable_id',
        'notifiable_type',
        'chat_id',
        'message_id',
        'share_id',
        'like_id',
        'photo_id'
        'type',
        'message',
        'read',
    ];

    protected $casts = [
        'read' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function sender()
    {
        return $this->belongsTo(Sender::class, 'sender_id');
    }

    public function chat()
    {
        return $this->belongsTo(Chat::class, 'chat_id');
    }

    public function message()
    {
        return $this->belongsTo(Message::class, 'message_id');
    }

    public function share()
    {
        return $this->belongsTo(Share::class, 'share_id');
    }
    
    public function like()
    {
        return $this->belongsTo(Like::class, 'like_id');
    }

    public function photo()
    {
        return $this->belongsTo(Photo::class, 'photo_id');
    }
}

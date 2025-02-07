<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
   
    protected $table = 'notifications';

    
    protected $fillable = [
        'user_id',
        'message',
        'read',
    ];

    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function friend()
    {
        return $this->belongsTo(User::class, 'friend_id');
    }

    public function photo()
    {
        return $this->belongsTo(Photo::class, 'photo_id');
    }

    public function Post()
    {
        return $this->belongsTo(Post::class, 'post_id');
    }

    public function message()
    {
        return $this->belongsTo(message::class, 'message_id');
    }

    public function Like()
    {
        return $this->belongsTo(Like::class, 'like_id');
    }

    public function Comment()
    {
        return $this->belongsTo(Comment::class, 'comment_id');
    }

    public function Chat()
    {
        return $this->belongsTo(Chat::class, 'chat_id');
    }
}


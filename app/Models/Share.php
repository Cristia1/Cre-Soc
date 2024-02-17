<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Share extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'photo_id',
        'comment_id',
        'friend_id',
        'notification_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function photo()
    {
        return $this->belongsTo(Photo::class, 'photo_id');
    }

    public function comment()
    {
        return $this->belongsTo(Comment::class, 'comment_id');
    }

    public function friend()
    {
        return $this->belongsTo(Share::class, 'share_id');
    }

    public function profile()
    {
        return $this->belongsTo(Profile::class, 'profile_id');
    }

    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id');
    }

    
}

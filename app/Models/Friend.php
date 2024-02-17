<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Friend extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'profile_id',
        'comment_id',
        'friends_request',
        'notification_id',
        'post_id',
        'Number_of_friends',
        'privacy_setting',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function profile()
    {
        return $this->belongsTo(Profile::class, 'profile_id');
    }

    public function comment()
    {
        return $this->belongsTo(Comment::class, 'comment_id');
    }

    public function notification()
    {
        return $this->belongsTo(Notification::class, 'notification_id');
    }

    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id');
    }

    public function like()
    {
        return $this->belongsTo(User::class, 'like_id');
    }

    public function photo()
    {
        return $this->belongsTo(User::class, 'photo_id');
    }

    public function share()
    {
        return $this->belongsTo(User::class, 'share_id');
    }
}

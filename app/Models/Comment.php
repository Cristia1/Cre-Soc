<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'post_id',
        'photo_id',
        'friend_id',
        'profile_id',
        'parent_comment_id',
        'descriptions',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id');
    }

    public function foto()
    {
        return $this->belongsTo(Photo::class, 'photo_id');
    }

    public function friend()
    {
        return $this->belongsTo(friend::class, 'friend_id');
    }

    public function profile()
    {
        return $this->belongsTo(Profile::class, 'profile_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'profile_id',
        'share_id',
        'comment_id',
        'like_id',
        'description',
        'image_path',
        'upload_date',
        'likes_count',
        'comments_count',
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

    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id');
    }

    public function share()
    {
        return $this->belongsTo(Share::class, 'share_id');
    }

    
}

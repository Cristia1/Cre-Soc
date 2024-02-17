<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'foto_id',
        'share_id',
        'like_id',
        'content',
        'image_path',
        'privacy_setting',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function photo()
    {
        return $this->belongsTo(Photo::class, 'photo_id');
    }

    public function share()
    {
        return $this->belongsTo(Share::class, 'share_id');
    }

    public function like()
    {
        return $this->belongsTo(Like::class, 'like_id');
    }
}

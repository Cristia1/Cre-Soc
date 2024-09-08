<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected $table = 'photos';

    protected $fillable = [
        'user_id',
        'description',
        'image',
        'type',
        'position_x',
        'position_y',
    ];

    public $timestamps = true;

    public function isCover()
    {
        return $this->type === 'cover';
    }

    public function isProfile()
    {
        return $this->type === 'profile';
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }


    public function hasLikeFromUser($userId)
    {
        return $this->likes()->where('user_id', $userId)->exists();
    }

    public function likeCount()
    {
        return $this->likes()->count();
    }

}
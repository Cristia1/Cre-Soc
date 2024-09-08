<?php

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;


class User extends Authenticatable
{
    use HasApiTokens;

    protected $fillable = [
        'name', 
        'email', 
        'password', 
        'google_id', 
        'google_user_id', 
        'google_user_email',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function friends()
    {
        return $this->belongsToMany(User::class, 'friends', 'user_id', 'friend_id');
    }

    public function photo()
    {
        return $this->hasOne(Photo::class);
    }

    public function comments() {
        return $this->hasMany(Comment::class);
    }
    
    public function images() {
        return $this->hasMany(UserImage::class);
    }
}
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

    public function sentFriendRequests()
    {
        return $this->hasMany(Friend::class, 'sender_id'); 
    }

    public function friendRequests()
    {
        return $this->hasMany(FriendRequest::class, 'user_id');
    }

    public function receivedFriendRequests()
    {
        return $this->hasMany(Friend::class, 'receiver_id');
    }

    public function friends()
    {
        return $this->belongsToMany(User::class, 'friends', 'sender_id', 'receiver_id')
            ->wherePivot('status', 'confirmed')
            ->withTimestamps();
    }

    public function photos()
    {
        return $this->hasMany(Photo::class);
    }

    public function photo()
    {
        return $this->hasOne(Photo::class)->where('type', 'profil');
    }

    public function comments() {
        return $this->hasMany(Comment::class);
    }

    public function profile()
    {
        return $this->hasOne(Profile::class, 'user_id', 'id');
    }
}

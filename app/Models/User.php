<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    
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
}

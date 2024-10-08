<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
   
    protected $table = 'likes';

   
    protected $fillable = [
        'user_id',
        'post_id',
        'photo_id',
    ];

   
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    
    public function photo()
    {
        return $this->belongsTo(Photo::class);
    }

    public function likeable()
    {
        return $this->morphTo();
    }

    public function comment()
    {
        return $this->morphTo();
    }
}


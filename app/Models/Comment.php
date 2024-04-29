<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    
    protected $table = 'comments';

   
    protected $fillable = [
        'user_id',
        'descriptions',
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
}


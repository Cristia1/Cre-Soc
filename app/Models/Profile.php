<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
   
    protected $table = 'profiles';

   
    protected $fillable = [
        'user_id',
        'photo',
        'city',
        'work',
        'birthdate',
        'marital_status',
        'education',
        'phone_number',
        'gender',
        'favorite_movies',
        'favorite_sports',
        'favorite_books',
    ];

   
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function photo()
    {
        return $this->hasOne(Photo::class, 'user_id', 'user_id'); 
    }
}


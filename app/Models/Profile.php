<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'photo_id',
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
        return $this->belongsTo(User::class, 'user_id');
    }

    public function photo()
    {
        return $this->belongsTo(Photo::class, 'photo_id');
    }

    public function friend()
    {
        return $this->belongsTo(Friend::class, 'friend_id');
    }

    public function notifications()
    {
        return $this->belongsTo(Notification::class, 'notification_id');
    }
}

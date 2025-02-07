<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Friend extends Model
{
   
    protected $table = 'friends';

    protected $fillable = [
        'user_id',
        'friend_id',
    ];

   
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

   
    public function friend()
    {
        return $this->belongsTo(User::class, 'friend_id');
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

}


<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Friend extends Model
{
   
    protected $table = 'friends';

    protected $fillable = [
        'sender_id',  
        'receiver_id',
        'status', 
    ];

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
    
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }    
}


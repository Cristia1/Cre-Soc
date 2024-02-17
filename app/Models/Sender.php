<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sender extends Model
{
    use HasFactory;

    protected $primaryKey = 'sender_id';

    protected $fillable = [
        'message_id',
        'user_id',
    ];

    public function message()
    {
        return $this->belongsTo(Message::class, 'message_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}


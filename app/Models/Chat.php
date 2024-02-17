<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    protected $primaryKey = 'chat_id';

    protected $fillable = [
        'user_id',
        'notification_id',
        'messages_id',
        'request1_id',
        'request2_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function notifiation()
    {
        return $this->belongsTo(Notification::class, 'notification_id');
    }

    public function messages()
    {
        return $this->belongsTo(Messages::class, 'message_id');
    }
}


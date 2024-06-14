<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected $table = 'photos';

    protected $fillable = [
        'user_id',
        'description',
        'image',
        'position_x',
        'position_y',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

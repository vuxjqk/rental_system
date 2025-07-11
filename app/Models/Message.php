<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'sender_id',
        'receiver_id',
        'content',
        'is_read',
    ];

    public function tenant()
    {
        return $this->belongsTo(User::class);
    }

    public function landlord()
    {
        return $this->belongsTo(User::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatRoom extends Model
{
    use HasFactory;

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id')->select('id', 'name');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id')->select('id', 'name');
    }
}

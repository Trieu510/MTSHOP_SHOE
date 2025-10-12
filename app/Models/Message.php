<?php

// app/Models/Message.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'receiver_id',
        'content',
        'is_read',
    ];

    // Người gửi
    public function sender()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Người nhận
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
}

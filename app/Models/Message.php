<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'receiver_id',
        'content',
        'is_read',
        'is_recalled',
        'reply_to_id',
        'deleted_by_sender',
        'deleted_by_receiver',
        'type',        
        'file_path',
    ];

    protected $casts = [
        'is_read'             => 'boolean',
        'is_recalled'         => 'boolean',
        'deleted_by_sender'   => 'boolean',
        'deleted_by_receiver' => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | 🔸 QUAN HỆ
    |--------------------------------------------------------------------------
    */

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

    // Tin nhắn được trả lời
    public function replyTo()
    {
        return $this->belongsTo(Message::class, 'reply_to_id');
    }

    // Danh sách các tin nhắn trả lời tin hiện tại
    public function replies()
    {
        return $this->hasMany(Message::class, 'reply_to_id');
    }

    /*
    |--------------------------------------------------------------------------
    | 🧠 ACCESSORS & HELPER
    |--------------------------------------------------------------------------
    */

    /**
     * Kiểm tra tin nhắn này đã bị xóa cho người dùng hiện tại hay chưa
     */
    public function isDeletedFor($userId)
    {
        if ($this->user_id == $userId) {
            return (bool) $this->deleted_by_sender;
        }
        if ($this->receiver_id == $userId) {
            return (bool) $this->deleted_by_receiver;
        }
        return false;
    }

    /**
     * Kiểm tra người dùng hiện tại có phải chủ sở hữu tin nhắn không
     */
    public function isOwner($userId)
    {
        return $this->user_id == $userId;
    }

    /**
     * Lấy nội dung hiển thị thực tế (ẩn nếu thu hồi hoặc xóa)
     */
    public function getDisplayContentFor($userId)
    {
        if ($this->isDeletedFor($userId)) {
            return '<em class="text-muted">Tin nhắn đã bị xóa</em>';
        }

        if ($this->is_recalled) {
            return '<em class="text-muted">Tin nhắn đã được thu hồi</em>';
        }

        return e($this->content);
    }

    /*
    |--------------------------------------------------------------------------
    | 🧠 SCOPES
    |--------------------------------------------------------------------------
    */

    /**
     * Lọc ra những tin nhắn chưa bị xóa với người dùng cụ thể
     */
    public function scopeVisibleFor($query, $userId)
    {
        return $query->where(function ($q) use ($userId) {
            $q->where(function ($q2) use ($userId) {
                $q2->where('user_id', $userId)
                   ->where('deleted_by_sender', false);
            })
            ->orWhere(function ($q2) use ($userId) {
                $q2->where('receiver_id', $userId)
                   ->where('deleted_by_receiver', false);
            });
        });
    }
}

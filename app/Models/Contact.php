<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Contact extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int,string>
     */
    protected $fillable = [
        'user_id',
        'name',
        'email',
        'phone',
        'message',
        'reply',       // thêm
        'replied_at',  // thêm
    ];

    /**
     * Các trường kiểu ngày tháng
     *
     * @var array<string,string>
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'replied_at',  // thêm
    ];

    /**
     * Quan hệ: liên hệ thuộc về một user (nếu có)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected $casts = [
        'replied_at' => 'datetime',
    ];

}

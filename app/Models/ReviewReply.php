<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Review;
use App\Models\User;

class ReviewReply extends Model
{
    use HasFactory;

    protected $fillable = [
        'review_id',
        'admin_id',
        'content',
    ];

    // Mỗi phản hồi thuộc về 1 đánh giá
    public function review()
    {
        return $this->belongsTo(Review::class);
    }

    // Mỗi phản hồi thuộc về 1 admin (user role admin)
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}

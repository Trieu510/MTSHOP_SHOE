<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'user_id',
        'reason',
        'status',
    ];

    /**
     * Một yêu cầu trả hàng thuộc về một đơn hàng
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Một yêu cầu trả hàng thuộc về một người dùng
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Một yêu cầu có nhiều ảnh minh họa
     */
    public function images()
    {
        return $this->hasMany(ReturnImage::class);
    }

    public function getStatusLabelAttribute()
{
    return match ($this->status) {
        'pending' => 'Chờ xử lý',
        'approved' => 'Đã chấp nhận',
        'rejected' => 'Từ chối',
        'exchanged' => 'Đã đổi hàng',
        default => 'Không xác định',
    };
}

public function logs()
{
    return $this->hasMany(ReturnLog::class);
}


}

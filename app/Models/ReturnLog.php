<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'return_request_id',
        'status',
        'note',
        'admin_id',
    ];

    /**
     * Mỗi log thuộc về 1 yêu cầu trả hàng
     */
    public function returnRequest()
    {
        return $this->belongsTo(ReturnRequest::class);
    }

    /**
     * Admin đã thực hiện log này
     */
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}

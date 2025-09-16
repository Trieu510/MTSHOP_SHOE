<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'return_request_id',
        'path',
    ];

    /**
     * Mỗi ảnh thuộc về một yêu cầu hoàn trả
     */
    public function returnRequest()
    {
        return $this->belongsTo(ReturnRequest::class);
    }
}

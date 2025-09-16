<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingFee extends Model
{
    // Cho phép gán dữ liệu hàng loạt
    protected $fillable = [
        'province',  // Tên tỉnh/thành phố
        'fee',       // Phí vận chuyển (VNĐ)
    ];

    /**
     * Thiết lập kiểu dữ liệu của các thuộc tính.
     */
    protected $casts = [
        'fee' => 'integer',
    ];

    /**
     * Sử dụng format số khi hiển thị (ví dụ nếu bạn muốn format trong model)
     */
    public function getFormattedFeeAttribute()
    {
        return number_format($this->fee, 0, ',', '.') . ' ₫';
    }
}

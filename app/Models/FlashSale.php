<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\Category;

class FlashSale extends Model
{
    use HasFactory;

    protected $fillable = [
        'discount_percent',
        'discount_amount',
        'start_time',
        'end_time',
        'applies_to',         // NEW: phạm vi áp dụng ('all', 'category', 'product')
        'category_id',   // NEW: nếu scope là category
        'product_id',    // NEW: nếu scope là product
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time'   => 'datetime',
    ];

    /**
     * Kiểm tra nếu đang trong thời gian Flash Sale
     */
    public function isActive(): bool
    {
        $now = now();
        return $this->start_time <= $now && $this->end_time >= $now;
    }

    /**
     * Flash sale áp dụng cho 1 sản phẩm cụ thể
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Flash sale áp dụng cho 1 danh mục sản phẩm
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}

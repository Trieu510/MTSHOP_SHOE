<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'type',
        'value',
        'min_order_amount',
        'usage_limit',
        'used',
        'expires_at',
        'is_active',
        'scope',
        'category_id',
        'product_id',

        // 🔥 Dùng cho vòng quay
        'is_spin_prize',
        'chance',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'is_active' => 'boolean',
        'is_spin_prize' => 'boolean',
        'chance' => 'integer',
    ];

    // ⚙️ Quan hệ với category và product
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * ✅ Kiểm tra mã còn hiệu lực
     */
    public function isValid(): bool
    {
        return $this->is_active &&
               ($this->usage_limit === null || $this->used < $this->usage_limit) &&
               ($this->expires_at === null || Carbon::now()->lt($this->expires_at));
    }

    /**
     * ✅ Tính giá trị giảm
     */
    public function getDiscountAmount(float $orderTotal): float
    {
        if ($this->type === 'percent') {
            return round($orderTotal * ($this->value / 100), 0);
        }

        return $this->value;
    }

    /**
     * ✅ Kiểm tra mã áp dụng được cho sản phẩm hoặc danh mục nào
     */
    public function appliesToProduct($product): bool
    {
        if ($this->scope === 'all') return true;

        if ($this->scope === 'category') {
            return $product->category_id === $this->category_id;
        }

        if ($this->scope === 'product') {
            return $product->id === $this->product_id;
        }

        return false;
    }
}

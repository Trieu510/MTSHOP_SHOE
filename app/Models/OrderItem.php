<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int,string>
     */
    protected $fillable = [
        'order_id',
        'product_id',           // ← thêm đây
        'product_variant_id',
        'product_name',
        'price',
        'quantity',
        'subtotal',
    ];

    /**
     * Quan hệ: item thuộc về đơn hàng
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Quan hệ: item liên kết với sản phẩm
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Quan hệ: item liên kết với biến thể sản phẩm
     */
    public function variant()
    {
        return $this->belongsTo(ProductVariant::class, 'product_variant_id');
    }

    //kiểm tra đã đánh giá chưa
    public function isReviewedBy($userId)
{
    // fallback khi product_id bị thiếu
    $productId = $this->product_id ?: optional($this->variant)->product_id;

    if (!$productId || !$userId) {
        return false;
    }

    return \App\Models\Review::where('product_id', $productId)
        ->where('user_id', $userId)
        ->exists();
}
}

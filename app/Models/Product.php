<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Review;
use App\Models\OrderItem;
use App\Models\Category;
use App\Models\ProductVariant;
use App\Models\Wishlist;
use App\Models\FlashSale;


class Product extends Model
{
    use HasFactory;

    protected $fillable = [
    'category_id',
    'name',
    'slug',
    'price',
    'description',
    'sku',
    'brand',
    'material',
    'gender',
    'care_instructions',
    'youtube_id',
    ];

    // Tự động thêm average_rating vào JSON/array khi serialize
    protected $appends = ['average_rating','flash_sale_price', 'has_flash_sale'];

    /**
     * Sản phẩm thuộc về danh mục
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Sản phẩm có nhiều biến thể (size)
     */
    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    /**
     * Sản phẩm có nhiều ảnh
     */
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    /**
     * Sản phẩm có nhiều order items thông qua variants
     */
    public function orderItems()
    {
        return $this->hasManyThrough(
            OrderItem::class,
            ProductVariant::class,
            'product_id',          // FK trên product_variants
            'product_variant_id',  // FK trên order_items
            'id',                  // PK trên products
            'id'                   // PK trên product_variants
        );
    }

    /**
     * Sản phẩm có nhiều đánh giá
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function wishlists(): HasMany
    {
        return $this->hasMany(Wishlist::class);
    }

    /**
     * Lấy điểm trung bình của tất cả review, làm tròn 1 chữ số
     */
    public function getAverageRatingAttribute(): float
    {
        $avg = $this->reviews()->avg('rating') ?: 0;
        return round($avg, 1);
    }

    public function getPrimaryImageAttribute()
{
    $image = $this->images->first();
    return $image ? asset('storage/' . $image->path) : asset('images/default.jpg');
}

/**
     * Lấy giá flash sale nếu đang trong thời gian áp dụng
     */
    public function getFlashSalePriceAttribute()
{
    $now = now();
    $flashSales = FlashSale::where('start_time', '<=', $now)
        ->where('end_time', '>=', $now)
        ->get();

    foreach ($flashSales as $flashSale) {
        // Áp dụng cho tất cả sản phẩm
        if ($flashSale->applies_to === 'all') {
            return $this->applyFlashSaleDiscount($flashSale);
        }

        // Áp dụng theo danh mục
        if ($flashSale->applies_to === 'category' && $flashSale->category_id === $this->category_id) {
            return $this->applyFlashSaleDiscount($flashSale);
        }

        // Áp dụng theo sản phẩm
        if ($flashSale->applies_to === 'product' && $flashSale->product_id === $this->id) {
            return $this->applyFlashSaleDiscount($flashSale);
        }
    }

    return null; // Không có flash sale áp dụng
}


    /**
     * Kiểm tra sản phẩm có đang trong Flash Sale hay không
     */
    public function getHasFlashSaleAttribute(): bool
    {
        return $this->flash_sale_price !== null;
    }

    protected function applyFlashSaleDiscount($flashSale)
{

    if (!$this->price) return null;

    if ($flashSale->discount_percent) {
        return round($this->price * (1 - $flashSale->discount_percent / 100));
    }

    if ($flashSale->discount_amount) {
        return max($this->price - $flashSale->discount_amount, 0);
    }


    return null;
}

public function isNew(): bool
{
    return $this->created_at >= now()->subDays(7);
}


}

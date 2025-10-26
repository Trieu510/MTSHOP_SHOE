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
use App\Models\UserActivity; // 👈 cần để tính lượt xem

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

    // Thêm các thuộc tính động (hiển thị tự động khi gọi $product->toArray())
    protected $appends = [
        'average_rating',
        'flash_sale_price',
        'has_flash_sale',
        'view_count',
        'wishlist_count',
        'purchase_count',
    ];

    // ==================== QUAN HỆ ====================

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function orderItems()
    {
        return $this->hasManyThrough(
            OrderItem::class,
            ProductVariant::class,
            'product_id',
            'product_variant_id',
            'id',
            'id'
        );
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function wishlists(): HasMany
    {
        return $this->hasMany(Wishlist::class);
    }

    // ==================== THUỘC TÍNH TÍNH TOÁN ====================

    /** ⭐ Điểm trung bình đánh giá */
    public function getAverageRatingAttribute(): float
    {
        $avg = $this->reviews()->avg('rating') ?: 0;
        return round($avg, 1);
    }

    /** 🖼 Ảnh chính của sản phẩm */
    public function getPrimaryImageAttribute()
    {
        $image = $this->images->first();
        return $image ? asset('storage/' . $image->path) : asset('images/default.jpg');
    }

    /** ⚡ Giá Flash Sale */
    public function getFlashSalePriceAttribute()
    {
        $now = now();
        $flashSales = FlashSale::where('start_time', '<=', $now)
            ->where('end_time', '>=', $now)
            ->get();

        foreach ($flashSales as $flashSale) {
            if ($flashSale->applies_to === 'all') {
                return $this->applyFlashSaleDiscount($flashSale);
            }
            if ($flashSale->applies_to === 'category' && $flashSale->category_id === $this->category_id) {
                return $this->applyFlashSaleDiscount($flashSale);
            }
            if ($flashSale->applies_to === 'product' && $flashSale->product_id === $this->id) {
                return $this->applyFlashSaleDiscount($flashSale);
            }
        }

        return null;
    }

    /** ✅ Có đang trong Flash Sale không */
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

    /** 🆕 Kiểm tra sản phẩm mới trong 7 ngày */
    public function isNew(): bool
    {
        return $this->created_at >= now()->subDays(7);
    }

    // ==================== 🎯 THỐNG KÊ TRENDING ====================

    /** 👀 Đếm lượt xem trong 7 ngày gần nhất */
    public function getViewCountAttribute()
    {
        return UserActivity::where('product_id', $this->id)
            ->where('action', 'view')
            ->where('created_at', '>=', now()->subDays(7))
            ->count();
    }

    /** ❤️ Đếm số người thêm vào wishlist */
    public function getWishlistCountAttribute()
    {
        return $this->wishlists()->count();
    }

    /** 🛒 Đếm số lượt mua trong 7 ngày gần nhất */
    public function getPurchaseCountAttribute()
    {
        return $this->orderItems()
            ->whereHas('order', function ($q) {
                $q->where('status', 'completed')
                  ->where('created_at', '>=', now()->subDays(7));
            })
            ->count();
    }
}

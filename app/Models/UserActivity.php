<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use App\Services\TrendingService;

class UserActivity extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'product_id', 'action'];

    protected static function booted()
    {
        static::created(function ($activity) {
            // 🧹 Xóa cache trending cũ
            Cache::forget('trending_products');

            // ⚡ Tự động tính lại trending và cache lại
            (new TrendingService())->getTrendingProducts(8);
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

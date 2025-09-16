<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Product;

class Wishlist extends Model
{
    use HasFactory;

    // Cho phép gán hàng loạt
    protected $fillable = [
        'user_id',
        'product_id',
    ];

    /**
     * Wishlist thuộc về User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Wishlist liên kết tới Product
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

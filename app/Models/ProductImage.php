<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'product_id',
        'path',
        'is_primary',
    ];

    /**
     * Quan hệ: ảnh thuộc về sản phẩm
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

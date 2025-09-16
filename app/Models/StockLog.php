<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_variant_id',
        'type',
        'quantity',
        'note',
        'admin_id',
    ];

    /**
     * Biến thể sản phẩm liên quan đến log
     */
    public function variant()
    {
        return $this->belongsTo(ProductVariant::class, 'product_variant_id');
    }

    /**
     * Admin đã thực hiện log này
     */
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}

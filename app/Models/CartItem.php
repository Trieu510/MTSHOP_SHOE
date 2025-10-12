<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_variant_id',
        'quantity',
    ];

    /**
     * CartItem thuộc về User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * CartItem thuộc về ProductVariant
     */
    public function variant()
    {
        return $this->belongsTo(ProductVariant::class, 'product_variant_id');
    }
}

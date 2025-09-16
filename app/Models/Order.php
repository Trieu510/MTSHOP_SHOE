<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int,string>
     */
    protected $fillable = [
        'user_id',
        'name',
        'phone',
        'address',
        'shipping_fee',
        'total_amount',
        'status',
        'payment_method',
        'note',
        'email',
    ];

    /**
     * Quan hệ: đơn hàng thuộc về 1 user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Quan hệ: đơn hàng có nhiều OrderItem
     */
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}

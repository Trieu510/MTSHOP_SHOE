<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Order;
use App\Models\Contact;
use App\Models\Review;
use App\Models\Wishlist; // ← import Wishlist
use App\Models\Address;
use App\Models\CartItem;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'address',
        'is_admin',
        'status',
        'avatar',
        'google_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_admin' => 'boolean',
    ];

    /**
     * Quan hệ: user có nhiều đơn hàng
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Quan hệ: user có nhiều cart items
     */
    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    /**
 * Kiểm tra xem người dùng đã mua sản phẩm (và đơn hàng ở trạng thái completed)
 */
public function hasPurchasedProduct($productId)
{
    return $this->orders()
        ->where('status', 'completed') // Chỉ đơn hoàn thành
        ->whereHas('items', function ($query) use ($productId) {
            $query->where('product_id', $productId);
        })
        ->exists();
}


    /**
     * Quan hệ: user có nhiều liên hệ
     */
    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }

    /**
     * Quan hệ: user có nhiều đánh giá (reviews)
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Quan hệ: user có nhiều mục yêu thích (wishlists)
     */
    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function defaultAddress()
    {
    return $this->hasOne(Address::class)->where('is_default', 1);
    }

    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'user_id');
    }

    /**
     * Quan hệ: user có nhiều tin nhắn đã nhận
     */
    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    /**
     * Alias cho messages() — để tương thích với controller admin
     */
    public function messages()
    {
        return $this->hasMany(Message::class, 'user_id');
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'thumbnail',
        'is_featured',
        'is_visible',
        'post_category_id'
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'is_visible' => 'boolean',
    ];

    // Tự động tạo slug nếu chưa có
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($post) {
            if (empty($post->slug)) {
                $post->slug = Str::slug($post->title);
            }
        });
    }

    // Mối quan hệ với danh mục (nếu có)
    public function category()
{
    return $this->belongsTo(PostCategory::class, 'post_category_id');
}


    // Truy cập đường dẫn ảnh đại diện
    public function getThumbnailUrlAttribute()
    {
        return $this->thumbnail
            ? asset('storage/' . $this->thumbnail)
            : asset('images/no-image.png');
    }

    public function postCategory()
{
    return $this->belongsTo(\App\Models\PostCategory::class);
}

}

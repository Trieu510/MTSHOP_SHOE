<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReviewMedia extends Model
{
    use HasFactory;

    protected $fillable = [
        'review_id',
        'file_path',
        'file_type',
    ];

    /**
     * Media thuộc về 1 Review
     */
    public function review()
    {
        return $this->belongsTo(Review::class);
    }
}

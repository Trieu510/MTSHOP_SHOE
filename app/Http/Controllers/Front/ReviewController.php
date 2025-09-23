<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Review;
use App\Models\ReviewMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ReviewController extends Controller
{
    /**
     * Lưu đánh giá mới cho sản phẩm.
     */
    public function store(Request $request, string $slug)
    {
        $request->validate([
            'rating'  => 'required|integer|between:1,5',
            'comment' => 'nullable|string|max:1000',
            'media.*' => 'nullable|file|mimes:jpg,jpeg,png,webp,mp4,mov,avi|max:20480', // 20MB
        ]);

        $product = Product::where('slug', $slug)->firstOrFail();

        // Đã đánh giá rồi
        if (Review::where('product_id', $product->id)->where('user_id', Auth::id())->exists()) {
            return back()->with('error', 'Bạn đã đánh giá sản phẩm này rồi.');
        }

        // ✅ Kiểm tra đã mua chưa
        if (!Auth::user()->hasPurchasedProduct($product->id)) {
            return back()->with('error', 'Bạn chỉ có thể đánh giá sản phẩm sau khi đã mua thành công.');
        }

        // Tạo review
        $review = Review::create([
            'product_id' => $product->id,
            'user_id'    => Auth::id(),
            'rating'     => $request->rating,
            'comment'    => $request->comment,
        ]);

        // Upload media nếu có
        if ($request->hasFile('media')) {
            foreach ($request->file('media') as $file) {
                $path = $file->store('reviews', 'public');
                $type = str_contains($file->getMimeType(), 'video') ? 'video' : 'image';

                ReviewMedia::create([
                    'review_id' => $review->id,
                    'file_path' => $path,
                    'file_type' => $type,
                ]);
            }
        }

        return back()->with('success', 'Cảm ơn bạn đã đánh giá sản phẩm!');
    }

    /**
     * Cập nhật đánh giá đã tồn tại.
     */
    public function update(Request $request, string $slug, Review $review)
    {
        $request->validate([
            'rating'       => 'required|integer|between:1,5',
            'comment'      => 'nullable|string|max:1000',
            'media.*'      => 'nullable|file|mimes:jpg,jpeg,png,webp,mp4,mov,avi|max:20480',
            'delete_media' => 'nullable|array',
        ]);

        $product = Product::where('slug', $slug)->firstOrFail();

        if ($review->product_id !== $product->id || $review->user_id !== Auth::id()) {
            abort(403);
        }

        // Cập nhật nội dung review
        $review->update([
            'rating'  => $request->rating,
            'comment' => $request->comment,
        ]);

        // Xoá media cũ nếu có chọn
        if ($request->delete_media) {
            foreach ($request->delete_media as $mediaId) {
                $media = ReviewMedia::where('id', $mediaId)
                    ->where('review_id', $review->id)
                    ->first();
                if ($media) {
                    Storage::disk('public')->delete($media->file_path);
                    $media->delete();
                }
            }
        }

        // Upload thêm media mới
        if ($request->hasFile('media')) {
            foreach ($request->file('media') as $file) {
                $path = $file->store('reviews', 'public');
                $type = str_contains($file->getMimeType(), 'video') ? 'video' : 'image';

                ReviewMedia::create([
                    'review_id' => $review->id,
                    'file_path' => $path,
                    'file_type' => $type,
                ]);
            }
        }

        return back()->with('success', 'Cập nhật đánh giá thành công!');
    }

    /**
     * Xóa một đánh giá.
     */
    public function destroy(string $slug, Review $review)
    {
        $product = Product::where('slug', $slug)->firstOrFail();

        if ($review->product_id !== $product->id || $review->user_id !== Auth::id()) {
            abort(403);
        }

        // Xóa media kèm theo
        foreach ($review->media as $media) {
            Storage::disk('public')->delete($media->file_path);
            $media->delete();
        }

        $review->delete();

        return back()->with('success', 'Xóa đánh giá thành công!');
    }
}

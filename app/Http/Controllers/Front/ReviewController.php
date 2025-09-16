<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Lưu đánh giá mới cho sản phẩm.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $slug
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, string $slug)
{
    $request->validate([
        'rating'  => 'required|integer|between:1,5',
        'comment' => 'nullable|string|max:1000',
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

    Review::create([
        'product_id' => $product->id,
        'user_id'    => Auth::id(),
        'rating'     => $request->rating,
        'comment'    => $request->comment,
    ]);

    return back()->with('success', 'Cảm ơn bạn đã đánh giá sản phẩm!');
}


    /**
     * Cập nhật đánh giá đã tồn tại.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $slug
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, string $slug, Review $review)
    {
        // Validate dữ liệu đầu vào
        $request->validate([
            'rating'  => 'required|integer|between:1,5',
            'comment' => 'nullable|string|max:1000',
        ]);

        // Lấy sản phẩm theo slug
        $product = Product::where('slug', $slug)->firstOrFail();

        // Chỉ cho phép chủ review chỉnh sửa và review phải thuộc về sản phẩm
        if ($review->product_id !== $product->id || $review->user_id !== Auth::id()) {
            abort(403);
        }

        // Cập nhật
        $review->update([
            'rating'  => $request->rating,
            'comment' => $request->comment,
        ]);

        return back()->with('success', 'Cập nhật đánh giá thành công!');
    }

    /**
     * Xóa một đánh giá.
     *
     * @param  string  $slug
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(string $slug, Review $review)
    {
        // Lấy sản phẩm theo slug
        $product = Product::where('slug', $slug)->firstOrFail();

        // Chỉ cho phép chủ review xóa và review phải thuộc về sản phẩm
        if ($review->product_id !== $product->id || $review->user_id !== Auth::id()) {
            abort(403);
        }

        // Xóa
        $review->delete();

        return back()->with('success', 'Xóa đánh giá thành công!');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\ReviewReply;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Hiển thị danh sách tất cả đánh giá.
     */
    public function index(Request $request)
{
    $query = Review::with(['user', 'product'])->orderBy('created_at', 'desc');

    if ($request->filled('user')) {
        $query->whereHas('user', function ($q) use ($request) {
            $q->where('name', 'like', '%' . $request->user . '%');
        });
    }

    if ($request->filled('product')) {
        $query->whereHas('product', function ($q) use ($request) {
            $q->where('name', 'like', '%' . $request->product . '%');
        });
    }

    if ($request->filled('rating')) {
        $query->where('rating', $request->rating);
    }

    $reviews = $query->paginate(20)->withQueryString();

    return view('admin.reviews.index', compact('reviews'));
}


    /**
     * Xóa một đánh giá.
     */
    public function destroy(Review $review)
    {
        $review->delete();
        return redirect()->route('admin.reviews.index')
                         ->with('success','Xóa đánh giá thành công.');
    }

   public function reply(Request $request, Review $review)
{
    $request->validate([
        'admin_reply' => 'required|string|max:1000',
    ]);

    // Check nếu đã phản hồi thì không cho phản hồi nữa
    if ($review->reply) {
        return redirect()->back()->with('error', 'Đánh giá này đã được phản hồi.');
    }

    ReviewReply::create([
        'review_id' => $review->id,
        'admin_id' => auth()->id(), // hoặc User::admin()->id
        'content' => $request->admin_reply,
    ]);

    return redirect()->route('admin.reviews.index')
                     ->with('success', 'Phản hồi đánh giá thành công.');
}


}

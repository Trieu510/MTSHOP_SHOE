<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    // Thêm vào yêu thích
    public function store($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();

        Wishlist::firstOrCreate([
            'user_id'    => Auth::id(),
            'product_id' => $product->id,
        ]);

        return back()->with('success', 'Đã thêm vào danh sách yêu thích.');
    }

    // Xóa khỏi yêu thích
    public function destroy($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();

        Wishlist::where('user_id', Auth::id())
                ->where('product_id', $product->id)
                ->delete();

        return back()->with('success', 'Đã xóa khỏi danh sách yêu thích.');
    }

    // Hiển thị danh sách yêu thích
    public function index()
    {
        // Lấy tất cả wishlist cùng product và ảnh của nó
        $items = Auth::user()
                     ->wishlists()
                     ->with('product.images')
                     ->get();

        return view('front.wishlist.index', compact('items'));
    }

    public function toggle(Product $product)
{
    $wishlist = Wishlist::where('user_id', Auth::id())
                        ->where('product_id', $product->id)
                        ->first();

    if ($wishlist) {
        $wishlist->delete();
        return back()->with('success', 'Đã xóa khỏi danh sách yêu thích.');
    } else {
        Wishlist::create([
            'user_id' => Auth::id(),
            'product_id' => $product->id,
        ]);
        return back()->with('success', 'Đã thêm vào danh sách yêu thích.');
    }
}

}

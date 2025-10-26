<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use App\Models\Product;
use App\Models\UserActivity; // ✅ Thêm dòng này
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    /**
     * ❤️ Thêm vào danh sách yêu thích
     */
    public function store($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();

        $wishlist = Wishlist::firstOrCreate([
            'user_id'    => Auth::id(),
            'product_id' => $product->id,
        ]);

        // ✅ Ghi lại hành động "wishlist" để hệ thống học hành vi yêu thích
        UserActivity::create([
            'user_id'    => Auth::id(),
            'product_id' => $product->id,
            'action'     => 'wishlist',
        ]);

        return back()->with('success', 'Đã thêm vào danh sách yêu thích.');
    }

    /**
     * 💔 Xóa khỏi danh sách yêu thích
     */
    public function destroy($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();

        Wishlist::where('user_id', Auth::id())
                ->where('product_id', $product->id)
                ->delete();

        return back()->with('success', 'Đã xóa khỏi danh sách yêu thích.');
    }

    /**
     * 📋 Hiển thị danh sách yêu thích của người dùng
     */
    public function index()
    {
        $items = Auth::user()
                     ->wishlists()
                     ->with('product.images')
                     ->get();

        return view('front.wishlist.index', compact('items'));
    }

    /**
     * ❤️ Toggle thêm/xóa khỏi danh sách yêu thích
     */
    public function toggle(Product $product)
    {
        $wishlist = Wishlist::where('user_id', Auth::id())
                            ->where('product_id', $product->id)
                            ->first();

        if ($wishlist) {
            // 💔 Nếu đã có thì xóa
            $wishlist->delete();
            return back()->with('success', 'Đã xóa khỏi danh sách yêu thích.');
        } else {
            // ❤️ Nếu chưa có thì thêm mới
            Wishlist::create([
                'user_id'    => Auth::id(),
                'product_id' => $product->id,
            ]);

            // ✅ Ghi lại hành động "wishlist"
            UserActivity::create([
                'user_id'    => Auth::id(),
                'product_id' => $product->id,
                'action'     => 'wishlist',
            ]);

            return back()->with('success', 'Đã thêm vào danh sách yêu thích.');
        }
    }
}

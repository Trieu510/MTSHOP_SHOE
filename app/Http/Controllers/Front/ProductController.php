<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\UserActivity;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * 🛍️ Danh sách sản phẩm (có tìm kiếm, lọc, sắp xếp)
     */
    public function index(Request $request)
    {
        $categories = Category::all();

        $query = Product::with('images');

        // Lọc theo danh mục
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Lọc theo giới tính
        if ($request->filled('gender')) {
            $query->where('gender', $request->gender);
        }

        // Tìm kiếm theo tên
        if ($q = $request->input('q')) {
            $query->where('name', 'like', "%{$q}%");
        }

        // Lọc theo khoảng giá
        if ($min = $request->input('min_price')) {
            $query->where('price', '>=', $min);
        }
        if ($max = $request->input('max_price')) {
            $query->where('price', '<=', $max);
        }

        // Sắp xếp
        switch ($request->input('sort')) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'trending': // ✅ Thêm sắp xếp theo “đang hot”
                $query->withCount(['wishlists', 'orderItems'])
                      ->orderByDesc('view_count');
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }

        // Phân trang
        $products = $query->paginate(12)->appends($request->query());

        return view('front.products.index', compact('products', 'categories'));
    }

    /**
     * 🧾 Hiển thị chi tiết sản phẩm + gợi ý + lịch sử xem
     */
    public function show($slug)
    {
        // 1️⃣ Lấy sản phẩm chính
        $product = Product::with([
            'images',
            'variants',
            'reviews.user',
            'reviews.reply',
        ])->where('slug', $slug)->firstOrFail();

        // 2️⃣ Ghi lại lượt xem sản phẩm — tránh trùng trong 5 phút
        $sessionKey = 'viewed_product_' . $product->id;
        if (!session()->has($sessionKey)) {
            UserActivity::create([
                'user_id'    => auth()->id(),
                'product_id' => $product->id,
                'action'     => 'view',
            ]);
            session()->put($sessionKey, true);
            session()->save();
        }

        // 3️⃣ Tính điểm trung bình đánh giá
        $averageRating = $product->reviews()->avg('rating');

        // 4️⃣ Gợi ý 4 sản phẩm cùng danh mục
        $recommended = Product::with('images')
            ->where('category_id', $product->category_id)
            ->where('id', '<>', $product->id)
            ->inRandomOrder()
            ->take(4)
            ->get();

        // 5️⃣ Lưu sản phẩm vừa xem vào session
        $recentlyViewed = session()->get('recently_viewed', []);
        $recentlyViewed = collect($recentlyViewed)
            ->prepend($product->id)
            ->unique()
            ->take(10);
        session()->put('recently_viewed', $recentlyViewed);

        // 6️⃣ Lấy danh sách sản phẩm vừa xem
        $recentProducts = Product::with('images')
            ->whereIn('id', $recentlyViewed->filter(fn($id) => $id != $product->id))
            ->get();

        // 7️⃣ Trả về view
        return view('front.products.show', compact(
            'product',
            'averageRating',
            'recommended',
            'recentProducts'
        ));
    }

    /**
     * 🔍 Autocomplete cho thanh tìm kiếm
     */
    public function autocomplete(Request $request)
    {
        $keyword = $request->query('query');

        $products = Product::where('name', 'LIKE', "%{$keyword}%")
            ->with(['images' => fn($q) => $q->where('is_primary', true)])
            ->limit(8)
            ->get()
            ->map(function ($product) {
                return [
                    'name'  => $product->name,
                    'slug'  => $product->slug,
                    'price' => number_format($product->price, 0, ',', '.') . '₫',
                    'image' => $product->images->first()?->path
                        ? asset('storage/' . $product->images->first()->path)
                        : asset('images/default.jpg'),
                ];
            });

        return response()->json($products);
    }
}

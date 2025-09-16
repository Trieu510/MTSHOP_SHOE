<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of products (public).
     * Supports search, filter, sort, pagination.
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
        default:
            $query->orderBy('created_at', 'desc');
    }

    // Phân trang + giữ các tham số truy vấn
    $products = $query->paginate(12)
                      ->appends($request->query());

    return view('front.products.index', compact('products', 'categories'));
}

    /**
     * Display the specified product by slug, including its reviews
     * and 4 recommended products from the same category.
     */
    public function show($slug)
{
    // 1. Lấy sản phẩm chính
    $product = Product::with([
        'images',
        'variants',
        'reviews.user',
        'reviews.reply', 
    ])
    ->where('slug', $slug)
    ->firstOrFail();

    // 2. Tính điểm đánh giá trung bình
    $averageRating = $product->reviews()->avg('rating');

    // 3. Lấy 4 sản phẩm gợi ý cùng danh mục, trừ chính nó
    $recommended = Product::with('images')
        ->where('category_id', $product->category_id)
        ->where('id', '<>', $product->id)
        ->inRandomOrder()
        ->take(4)
        ->get();

    // 4. Lưu sản phẩm vừa xem vào session
    $recentlyViewed = session()->get('recently_viewed', []);
    $recentlyViewed = collect($recentlyViewed)
        ->prepend($product->id)
        ->unique()
        ->take(10);
    session()->put('recently_viewed', $recentlyViewed);

    // 5. Lấy danh sách sản phẩm vừa xem (trừ sản phẩm hiện tại)
    $recentProducts = Product::with('images')
        ->whereIn('id', $recentlyViewed->filter(fn($id) => $id != $product->id))
        ->get();


    // 6. Trả về view
    return view('front.products.show', compact(
        'product',
        'averageRating',
        'recommended',
        'recentProducts'
    ));
}


    public function autocomplete(Request $request)
{
    $keyword = $request->query('query');

    $products = Product::where('name', 'LIKE', "%{$keyword}%")
        ->with(['images' => fn($q) => $q->where('is_primary', true)])
        ->limit(8)
        ->get()
        ->map(function ($product) {
            return [
                'name' => $product->name,
                'slug' => $product->slug,
                'price' => number_format($product->price, 0, ',', '.') . '₫',
                'image' => $product->images->first()?->path
                    ? asset('storage/' . $product->images->first()->path)
                    : asset('images/default.jpg'),
            ];
        });

    return response()->json($products);
}

}

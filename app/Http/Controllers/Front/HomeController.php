<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Product;
use App\Models\Category;
use App\Models\Post;
use App\Models\FlashSale;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the home page with banners and products.
     */
    public function index(Request $request)
    {
        // Lấy banner theo độ ưu tiên
        $banners = Banner::orderBy('priority', 'desc')->get();

        // Xây dựng query sản phẩm
        $query = Product::with('images');

        // Tìm kiếm theo tên
        if ($keyword = $request->input('q')) {
            $query->where('name', 'like', '%' . $keyword . '%');
        }

        // Lọc giá
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

        // Phân trang 12 sản phẩm
        $products = $query->paginate(12)->appends($request->query());

        // Lấy danh mục thương hiệu nổi bật
        $featuredBrands = Category::whereIn('slug', ['nike', 'adidas', 'vans', 'puma', 'mlb', 'newbalance'])->get();

        // Lấy flash sale đang hoạt động
        $flashSale = FlashSale::where('start_time', '<=', now())
            ->where('end_time', '>=', now())
            ->latest()
            ->first();

        // Lấy danh sách sản phẩm đang trong flash sale
        $flashSaleProducts = collect();
        if ($flashSale) {
            $flashSaleProducts = Product::with('images')
                ->get()
                ->filter(fn ($product) => $product->has_flash_sale)
                ->take(8); // lấy tối đa 8 sản phẩm
        }

        return view('front.home', compact(
            'banners',
            'products',
            'featuredBrands',
            'flashSale',
            'flashSaleProducts'
        ));
    }
}

<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class CompareController extends Controller
{
    /**
     * Hiển thị danh sách sản phẩm đang so sánh
     */
    public function index()
    {
        $compareIds = session('compare', []);
        $products = Product::with(['images', 'variants'])->whereIn('id', $compareIds)->get();

        return view('front.compare.index', compact('products'));
    }

    /**
     * Thêm sản phẩm vào danh sách so sánh (session)
     */
    public function add($id)
    {
        $compare = session('compare', []);

        if (!in_array($id, $compare)) {
            if (count($compare) >= 3) {
                return back()->with('error', 'Bạn chỉ có thể so sánh tối đa 3 sản phẩm!');
            }
            $compare[] = $id;
            session(['compare' => $compare]);
        }

        return back()->with('success', 'Đã thêm sản phẩm vào danh sách so sánh!');
    }

    /**
     * Xóa 1 sản phẩm khỏi danh sách so sánh
     */
    public function remove($id)
    {
        $compare = session('compare', []);
        $compare = array_filter($compare, fn($item) => $item != $id);
        session(['compare' => $compare]);

        return back()->with('success', 'Đã xóa sản phẩm khỏi danh sách so sánh!');
    }

    /**
     * Xóa toàn bộ danh sách so sánh
     */
    public function clear()
    {
        session()->forget('compare');
        return back()->with('success', 'Đã xóa tất cả sản phẩm so sánh!');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FlashSale;
use App\Models\Product;
use App\Models\Category;

class FlashSaleController extends Controller
{
    /**
     * Danh sách flash sale
     */
    public function index()
    {
        $flashSales = FlashSale::orderByDesc('id')->get();
        return view('admin.flash_sales.index', compact('flashSales'));
    }

    /**
     * Form tạo mới
     */
    public function create()
    {
        $products = Product::all();
        $categories = Category::all();
    return view('admin.flash_sales.create', compact('products', 'categories'));
    }

    /**
     * Lưu flash sale mới
     */
    public function store(Request $request)
    {
        $request->validate([
        'discount_percent' => 'nullable|numeric|min:0|max:100',
        'discount_amount'  => 'nullable|numeric|min:0',
        'applies_to'       => 'required|in:all,category,product',
        'product_id'       => 'nullable|exists:products,id',
        'category_id'      => 'nullable|exists:categories,id',
        'start_time'       => 'required|date',
        'end_time'         => 'required|date|after:start_time',
    ]);

    $data = $request->all();

    // Reset nếu không cần thiết
    if ($data['applies_to'] !== 'product') {
        $data['product_id'] = null;
    }
    if ($data['applies_to'] !== 'category') {
        $data['category_id'] = null;
    }

    FlashSale::create($data);

    return redirect()->route('admin.flash-sales.index')->with('success', 'Tạo Flash Sale thành công!');
    }

    /**
     * Form chỉnh sửa
     */
    public function edit($id)
    {
        $flashSale = FlashSale::findOrFail($id);
        $products = Product::all();
        $categories = Category::all();
    return view('admin.flash_sales.edit', compact('flashSale', 'products', 'categories'));
    }

    /**
     * Cập nhật flash sale
     */
    public function update(Request $request, $id)
    {
        $request->validate([
        'discount_percent' => 'nullable|numeric|min:0|max:100',
        'discount_amount'  => 'nullable|numeric|min:0',
        'applies_to'       => 'required|in:all,category,product',
        'product_id'       => 'nullable|exists:products,id',
        'category_id'      => 'nullable|exists:categories,id',
        'start_time'       => 'required|date',
        'end_time'         => 'required|date|after:start_time',
    ]);

    $flashSale = FlashSale::findOrFail($id);
    $data = $request->all();

    if ($data['applies_to'] !== 'product') {
        $data['product_id'] = null;
    }
    if ($data['applies_to'] !== 'category') {
        $data['category_id'] = null;
    }

    $flashSale->update($data);

    return redirect()->route('admin.flash-sales.index')->with('success', 'Cập nhật Flash Sale thành công!');
    }

    /**
     * Xoá flash sale
     */
    public function destroy($id)
    {
        $flashSale = FlashSale::findOrFail($id);
        $flashSale->delete();

        return redirect()->route('admin.flash-sales.index')->with('success', 'Đã xoá Flash Sale!');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductVariant;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category', 'variants', 'images')
            ->orderBy('created_at', 'desc');

        // Lọc theo tên sản phẩm
        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        // Lọc theo danh mục
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Lọc theo khoảng giá
        if ($request->filled('price_min')) {
            $query->where('price', '>=', $request->price_min);
        }

        if ($request->filled('price_max')) {
            $query->where('price', '<=', $request->price_max);
        }

        $products = $query->get();
        $categories = Category::orderBy('name')->get();

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:150|unique:products',
        'category_id' => 'required|exists:categories,id',
        'price' => 'required|numeric|min:0',
        'description' => 'nullable|string',
        'sku' => 'nullable|string|max:100',
        'brand' => 'nullable|string|max:100',
        'material' => 'nullable|string|max:100',
        'care_instructions' => 'nullable|string|max:255',
        'sizes' => 'required|array',
        'sizes.*' => 'required|string|max:20',
        'images' => 'required|array',
        'images.*' => 'image|max:2048',
        'gender' => 'required|in:male,female,unisex',
        'youtube_id' => 'nullable|string|max:255', // ✅ thêm dòng này
    ]);

    // ✅ Trích xuất ID nếu admin dán link
    $youtubeId = $this->extractYoutubeId($request->youtube_id ?? null);

    $product = Product::create([
        'category_id' => $request->category_id,
        'name' => $request->name,
        'slug' => Str::slug($request->name),
        'price' => $request->price,
        'description' => $request->description,
        'sku' => $request->sku,
        'brand' => $request->brand,
        'material' => $request->material,
        'care_instructions' => $request->care_instructions,
        'gender' => $request->gender,
        'youtube_id' => $youtubeId, // ✅ thêm dòng này
    ]);

    foreach ($request->sizes as $index => $size) {
        ProductVariant::create([
            'product_id' => $product->id,
            'size' => $size,
            'stock' => 0,
        ]);
    }

    foreach ($request->images as $i => $image) {
        $path = $image->store('products', 'public');
        ProductImage::create([
            'product_id' => $product->id,
            'path' => $path,
            'is_primary' => $i === 0,
        ]);
    }

    return redirect()->route('admin.products.index')
                     ->with('success', 'Thêm sản phẩm thành công.');
}


    public function show(Product $product)
    {
        $product->load('category', 'variants', 'images');
        return view('admin.products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = Category::orderBy('name')->get();
        $product->load('variants', 'images');
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
{
    $request->validate([
        'name' => 'required|string|max:150|unique:products,name,' . $product->id,
        'category_id' => 'required|exists:categories,id',
        'price' => 'required|numeric|min:0',
        'description' => 'nullable|string',
        'sku' => 'nullable|string|max:100',
        'brand' => 'nullable|string|max:100',
        'material' => 'nullable|string|max:100',
        'care_instructions' => 'nullable|string|max:255',
        'sizes' => 'required|array',
        'sizes.*' => 'required|string|max:20',
        'images' => 'nullable|array',
        'images.*' => 'image|max:2048',
        'gender' => 'required|in:male,female,unisex',
        'youtube_id' => 'nullable|string|max:255', // ✅ Thêm dòng này
    ]);

    // ✅ Trích xuất ID từ link nếu có
    $youtubeId = $this->extractYoutubeId($request->youtube_id ?? null);

    $product->update([
        'category_id' => $request->category_id,
        'name' => $request->name,
        'slug' => Str::slug($request->name),
        'price' => $request->price,
        'description' => $request->description,
        'sku' => $request->sku,
        'brand' => $request->brand,
        'material' => $request->material,
        'care_instructions' => $request->care_instructions,
        'gender' => $request->gender,
        'youtube_id' => $youtubeId, // ✅ Thêm dòng này
    ]);

    $product->variants()->delete();
    foreach ($request->sizes as $index => $size) {
        ProductVariant::create([
            'product_id' => $product->id,
            'size' => $size,
            'stock' => 0,
        ]);
    }

    if ($request->hasFile('images')) {
        foreach ($product->images as $img) {
            Storage::disk('public')->delete($img->path);
        }
        $product->images()->delete();

        foreach ($request->images as $i => $image) {
            $path = $image->store('products', 'public');
            ProductImage::create([
                'product_id' => $product->id,
                'path' => $path,
                'is_primary' => $i === 0,
            ]);
        }
    }

    return redirect()->route('admin.products.index')
                     ->with('success', 'Cập nhật sản phẩm thành công.');
}


    public function destroy(Product $product)
    {
        foreach ($product->images as $img) {
            Storage::disk('public')->delete($img->path);
        }

        $product->delete();

        return redirect()->route('admin.products.index')
                         ->with('success', 'Xóa sản phẩm thành công.');
    }

    private function extractYoutubeId($url)
{
    if (!$url) return null;

    $url = trim($url);
    if (strlen($url) === 11) return $url; // Đã là ID

    preg_match('/(?:v=|\/|embed\/|be\/)([0-9A-Za-z_-]{11})/', $url, $matches);
    return $matches[1] ?? null;
}

}

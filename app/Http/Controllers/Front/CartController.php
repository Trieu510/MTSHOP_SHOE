<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\ProductVariant;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CartController extends Controller
{
    // Hiển thị giỏ hàng
    // Hiển thị giỏ hàng
public function index()
{
    $cart = session('cart', []);

    foreach ($cart as $key => $item) {
        $product = \App\Models\Product::find($item['product_id']);
        if ($product) {
            $cart[$key]['price']          = $product->flash_sale_price ?? $product->price;
            $cart[$key]['original_price'] = $product->price;
            $cart[$key]['is_flash_sale']  = $product->has_flash_sale;
        }
    }

    // Cập nhật lại session để đảm bảo giá mới nhất
    session(['cart' => $cart]);

    // Tính tổng giá trị giỏ hàng
    $total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);

    // ✅ Lấy tất cả coupon admin đã tạo còn hiệu lực
    $activeCoupons = Coupon::where('is_active', 1)
        ->where(function ($query) {
            $query->whereNull('expires_at')
                  ->orWhere('expires_at', '>', Carbon::now());
        })
        ->get();

    return view('front.cart.index', compact('cart', 'total', 'activeCoupons'));
}


    // Thêm vào giỏ
    public function store(Request $request)
    {
        $request->validate([
            'variant_id' => 'required|exists:product_variants,id',
            'quantity'   => 'required|integer|min:1',
        ]);

        $variant = ProductVariant::with('product.images')->findOrFail($request->variant_id);

        // Chặn hết hàng
        if ($variant->stock <= 0) {
            return back()->with('error', "Sản phẩm size {$variant->size} đã hết hàng.");
        }

        $cart  = session('cart', []);
        $rowId = $variant->id;

        $currentQty = isset($cart[$rowId]) ? (int)$cart[$rowId]['quantity'] : 0;
        $addQty     = (int)$request->quantity;
        $newQty     = $currentQty + $addQty;

        // Chặn vượt tồn
        if ($newQty > $variant->stock) {
            return back()->with('error', "Chỉ còn {$variant->stock} sản phẩm size {$variant->size}.");
        }

        if (isset($cart[$rowId])) {
            $cart[$rowId]['quantity'] = $newQty;
        } else {
            $cart[$rowId] = [
                'product_id'      => $variant->product->id,
                'name'            => $variant->product->name,
                'price'           => $variant->product->flash_sale_price ?? $variant->product->price,
                'original_price'  => $variant->product->price,
                'is_flash_sale'   => $variant->product->has_flash_sale,
                'variant'         => $variant->size,
                'quantity'        => $addQty,
                'image'           => optional($variant->product->images->first())->path,
            ];
        }

        session(['cart' => $cart]);
        return back()->with('success', 'Đã thêm vào giỏ hàng.');
    }

    // Cập nhật số lượng
    public function update(Request $request, $rowId)
    {
        $request->validate(['quantity' => 'required|integer|min:1']);

        $cart = session('cart', []);
        if (!isset($cart[$rowId])) {
            return back()->with('error', 'Sản phẩm không tồn tại trong giỏ.');
        }

        $variant = ProductVariant::findOrFail($rowId);
        $newQty  = (int)$request->quantity;

        // Chặn vượt tồn
        if ($newQty > $variant->stock) {
            return back()->with('error', "Chỉ còn {$variant->stock} sản phẩm size {$variant->size}.");
        }

        $cart[$rowId]['quantity'] = $newQty;

        session(['cart' => $cart]);
        return back()->with('success', 'Cập nhật giỏ hàng thành công.');
    }

    // Xóa mục khỏi giỏ
    public function destroy($rowId)
    {
        $cart = session('cart', []);
        if (isset($cart[$rowId])) {
            unset($cart[$rowId]);
        }
        session(['cart' => $cart]);
        return back()->with('success', 'Đã xóa sản phẩm khỏi giỏ.');
    }

    // Mua ngay (Buy Now)
    public function buyNow(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'variant_id' => 'required|exists:product_variants,id',
            'quantity'   => 'required|integer|min:1',
        ]);

        $variant = ProductVariant::with('product.images')->findOrFail($request->variant_id);
        $product = $variant->product;
        $qty     = (int)$request->quantity;

        // Chặn vượt tồn
        if ($qty > $variant->stock) {
            return back()->with('error', "Chỉ còn {$variant->stock} sản phẩm size {$variant->size}.");
        }

        $rowId = $variant->id;

        $item = [
            'product_id'     => $product->id,
            'name'           => $product->name,
            'price'          => $product->flash_sale_price ?? $product->price,
            'original_price' => $product->price,
            'is_flash_sale'  => $product->has_flash_sale,
            'variant'        => $variant->size,
            'quantity'       => $qty,
            'image'          => optional($product->images->first())->path,
        ];

        // Mua ngay: thay thế giỏ chỉ còn 1 item
        session(['cart' => [$rowId => $item]]);

        return redirect()->route(auth()->check() ? 'checkout.index' : 'orders.quick');
    }
}

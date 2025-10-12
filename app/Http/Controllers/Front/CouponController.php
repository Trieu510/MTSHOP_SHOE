<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Coupon;
use App\Models\Product;

class CouponController extends Controller
{
    public function apply(Request $request)
    {
        $request->validate([
            'coupon_code' => 'required|string'
        ]);

        $code = $request->coupon_code;
        $coupon = Coupon::where('code', $code)->first();

        if (!$coupon || !$coupon->isValid()) {
            return back()->with('coupon_error', 'Mã giảm giá không hợp lệ hoặc đã hết hạn.');
        }

        $cart = session('cart', []);
        if (empty($cart)) {
            return back()->with('coupon_error', 'Giỏ hàng trống, không thể áp dụng mã.');
        }

        // Tính tổng giá trị đơn hàng được áp dụng
        $discountableTotal = 0;

        foreach ($cart as $item) {
            // Truy vấn sản phẩm từ DB để lấy category_id
            $product = Product::find($item['product_id']);
            if (!$product) continue;

            $itemProduct = (object)[
                'id'          => $product->id,
                'category_id' => $product->category_id
            ];

            if ($coupon->appliesToProduct($itemProduct)) {
                $discountableTotal += $item['price'] * $item['quantity'];
            }
        }

        if ($discountableTotal <= 0) {
            return back()->with('coupon_error', 'Mã không áp dụng cho sản phẩm trong giỏ hàng.');
        }

        if ($coupon->min_order_amount && $discountableTotal < $coupon->min_order_amount) {
            return back()->with('coupon_error', 'Đơn hàng chưa đủ điều kiện để áp dụng mã giảm giá.');
        }

        $discount = $coupon->getDiscountAmount($discountableTotal);

        session()->put('coupon', [
            'code'     => $coupon->code,
            'discount' => $discount
        ]);

        return back()->with('success', 'Áp dụng mã giảm giá thành công.');
    }

    public function remove(Request $request)
{
    $code = $request->input('code'); // nhận mã muốn xóa

    // Nếu đang áp dụng coupon chính
    if (session()->has('coupon') && session('coupon.code') === $code) {
        session()->forget('coupon');
    }

    // Nếu mã nằm trong danh sách mã quay trúng
    $wonCoupons = session('won_coupons', []);
    if (in_array($code, $wonCoupons)) {
        $wonCoupons = array_filter($wonCoupons, fn($c) => $c !== $code);
        session(['won_coupons' => $wonCoupons]);
    }

    return redirect()->route('cart.index')->with('success', "Đã xóa mã $code.");
}

}

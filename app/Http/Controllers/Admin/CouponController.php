<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Coupon;
use App\Models\Category;
use App\Models\Product;
use Carbon\Carbon;

class CouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::latest()->paginate(10);
        return view('admin.coupons.index', compact('coupons'));
    }

    public function create()
    {
        $categories = Category::all();
        $products   = Product::all();
        return view('admin.coupons.create', compact('categories', 'products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code'             => 'required|string|unique:coupons,code',
            'type'             => 'required|in:percent,fixed',
            'value'            => 'required|numeric|min:0',
            'min_order_amount' => 'nullable|numeric|min:0',
            'usage_limit'      => 'nullable|integer|min:1',
            'expires_at'       => 'nullable|string',
            'is_active'        => 'nullable',
            'scope'            => 'required|in:all,category,product',
            'category_id'      => 'nullable|exists:categories,id',
            'product_id'       => 'nullable|exists:products,id',
            'is_spin_prize'    => 'nullable|boolean',
            'chance'           => 'nullable|integer|min:0|max:100',
        ]);

        if ($request->filled('expires_at')) {
            try {
                $validated['expires_at'] = Carbon::createFromFormat('d/m/Y', $request->expires_at)->format('Y-m-d');
            } catch (\Exception $e) {
                return back()->withInput()->withErrors(['expires_at' => 'Ngày không hợp lệ (dd/mm/yyyy)']);
            }
        }

        $validated['is_active']    = $request->has('is_active');
        $validated['is_spin_prize'] = $request->has('is_spin_prize');
        $validated['chance']       = $request->input('chance', 0);
        $validated['used']         = 0;

        Coupon::create($validated);

        return redirect()->route('admin.coupons.index')->with('success', 'Đã thêm mã giảm giá!');
    }

    public function edit(Coupon $coupon)
    {
        $categories = Category::all();
        $products   = Product::all();
        return view('admin.coupons.edit', compact('coupon', 'categories', 'products'));
    }

    public function update(Request $request, Coupon $coupon)
    {
        $validated = $request->validate([
            'code'             => 'required|string|unique:coupons,code,' . $coupon->id,
            'type'             => 'required|in:percent,fixed',
            'value'            => 'required|numeric|min:0',
            'min_order_amount' => 'nullable|numeric|min:0',
            'usage_limit'      => 'nullable|integer|min:1',
            'expires_at'       => 'nullable|string',
            'is_active'        => 'nullable',
            'scope'            => 'required|in:all,category,product',
            'category_id'      => 'nullable|exists:categories,id',
            'product_id'       => 'nullable|exists:products,id',
            'is_spin_prize'    => 'nullable|boolean',
            'chance'           => 'nullable|integer|min:0|max:100',
        ]);

        if ($request->filled('expires_at')) {
            try {
                $validated['expires_at'] = Carbon::createFromFormat('d/m/Y', $request->expires_at)->format('Y-m-d');
            } catch (\Exception $e) {
                return back()->withInput()->withErrors(['expires_at' => 'Ngày không hợp lệ (dd/mm/yyyy)']);
            }
        }

        $validated['is_active']     = $request->has('is_active');
        $validated['is_spin_prize'] = $request->has('is_spin_prize');
        $validated['chance']        = $request->input('chance', 0);

        $coupon->update($validated);

        return redirect()->route('admin.coupons.index')->with('success', 'Đã cập nhật mã giảm giá!');
    }

    public function destroy(Coupon $coupon)
    {
        $coupon->delete();
        return redirect()->route('admin.coupons.index')->with('success', 'Đã xoá mã giảm giá!');
    }
}

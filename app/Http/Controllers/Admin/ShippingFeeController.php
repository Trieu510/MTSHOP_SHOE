<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ShippingFee;
use Illuminate\Http\Request;

class ShippingFeeController extends Controller
{
    /**
     * Hiển thị danh sách phí vận chuyển.
     */
    public function index(Request $request)
{
    // Lấy danh sách tỉnh/thành để đổ vào select box
    $provinces = ShippingFee::select('province')->distinct()->orderBy('province')->pluck('province');

    // Xử lý lọc nếu có truyền province
    $query = ShippingFee::query();

    if ($request->filled('province')) {
        $query->where('province', $request->province);
    }

    $shippingFees = $query->orderBy('province')->paginate(10)->withQueryString();

    return view('admin.shipping_fees.index', compact('shippingFees', 'provinces'));
}


    /**
     * Hiển thị form tạo mới.
     */
    public function create()
    {
        return view('admin.shipping_fees.create');
    }

    /**
     * Lưu phí vận chuyển mới.
     */
    public function store(Request $request)
    {
        $request->validate([
            'province' => 'required|string|max:100|unique:shipping_fees,province',
            'fee' => 'required|integer|min:0',
        ]);

        ShippingFee::create($request->only('province', 'fee'));

        return redirect()->route('admin.shipping_fees.index')
            ->with('success', 'Thêm phí vận chuyển thành công!');
    }

    /**
     * Hiển thị form chỉnh sửa.
     */
    public function edit(ShippingFee $shippingFee)
    {
        return view('admin.shipping_fees.edit', compact('shippingFee'));
    }

    /**
     * Cập nhật phí vận chuyển.
     */
    public function update(Request $request, ShippingFee $shippingFee)
    {
        $request->validate([
            'province' => 'required|string|max:100|unique:shipping_fees,province,' . $shippingFee->id,
            'fee' => 'required|integer|min:0',
        ]);

        $shippingFee->update($request->only('province', 'fee'));

        return redirect()->route('admin.shipping_fees.index')
            ->with('success', 'Cập nhật phí vận chuyển thành công!');
    }

    /**
     * Xoá phí vận chuyển.
     */
    public function destroy(ShippingFee $shippingFee)
    {
        $shippingFee->delete();

        return redirect()->route('admin.shipping_fees.index')
            ->with('success', 'Xoá phí vận chuyển thành công!');
    }
}

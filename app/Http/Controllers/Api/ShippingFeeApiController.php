<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ShippingFee;
use Illuminate\Http\Request;

class ShippingFeeApiController extends Controller
{
    /**
     * Trả về phí vận chuyển dựa trên tên tỉnh
     * GET /api/shipping-fee?province=Hà Nội
     */
    public function getFeeByProvince(Request $request)
    {
        $province = $request->query('province');

        if (!$province) {
            return response()->json([
                'success' => false,
                'message' => 'Vui lòng cung cấp tên tỉnh.',
            ], 400);
        }

        $fee = ShippingFee::where('province', $province)->value('fee');

        return response()->json([
            'success' => true,
            'province' => $province,
            'fee' => $fee ?? 0, // Trả về 0 nếu không có
        ]);
    }
}

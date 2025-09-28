<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SpinLog;
use App\Models\Coupon;
use Illuminate\Support\Facades\Auth;

class SpinController extends Controller
{
    /**
     * Hiển thị giao diện vòng quay
     */
    public function index()
    {
        return view('front.spin.index');
    }

    /**
     * Xử lý khi người dùng quay
     */
    public function spin(Request $request)
    {
        $user = Auth::user();

        // ✅ Mỗi user chỉ được quay 1 lần/ngày
        $todaySpins = SpinLog::where('user_id', $user->id)
            ->whereDate('created_at', now()->toDateString())
            ->count();

        if ($todaySpins >= 1) {
            return response()->json([
                'success' => false,
                'message' => 'Bạn đã quay hôm nay, hãy thử lại vào ngày mai nhé!'
            ]);
        }

        // ✅ Danh sách phần thưởng với tỉ lệ %
        $prizes = [
            ['label' => 'Giảm 10%', 'coupon_id' => 1, 'chance' => 40],
            ['label' => 'Giảm 20%', 'coupon_id' => 2, 'chance' => 20],
            ['label' => 'Miễn phí ship', 'coupon_id' => 3, 'chance' => 20],
            ['label' => 'Chúc bạn may mắn lần sau', 'coupon_id' => null, 'chance' => 20],
        ];

        // ✅ Random theo tỉ lệ
        $rand = rand(1, 100);
        $current = 0;
        $result = null;

        foreach ($prizes as $prize) {
            $current += $prize['chance'];
            if ($rand <= $current) {
                $result = $prize;
                break;
            }
        }

        // ✅ Lấy thông tin coupon (nếu có)
        $coupon = null;
        if (!empty($result['coupon_id'])) {
            $coupon = Coupon::where('id', $result['coupon_id'])
                ->where('is_active', 1)
                ->where(function ($q) {
                    $q->whereNull('expires_at')
                      ->orWhere('expires_at', '>', now());
                })
                ->first();
        }

        // ✅ Lưu log kết quả
        $log = SpinLog::create([
            'user_id'   => $user->id,
            'coupon_id' => $coupon->id ?? null,
            'prize'     => $result['label'],
        ]);

        // ✅ Nếu có coupon hợp lệ → lưu vào session user_coupons
        if ($coupon) {
            $userCoupons = session('user_coupons', []);
            $userCoupons[$coupon->id] = $coupon->code;
            session(['user_coupons' => $userCoupons]);
        }

        return response()->json([
            'success' => true,
            'prize'   => $result['label'],
            'coupon'  => $coupon ? $coupon->code : null, // trả về mã code để user copy
        ]);
    }
}

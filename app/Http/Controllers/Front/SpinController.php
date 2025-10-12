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
        // ✅ Lấy coupon hợp lệ để hiển thị trên vòng quay
        $coupons = Coupon::where('is_active', 1)
            ->where('is_spin_prize', 1) // chỉ coupon dùng cho vòng quay
            ->where(function ($q) {
                $q->whereNull('expires_at')
                  ->orWhere('expires_at', '>', now());
            })
            ->where(function ($q) {
                $q->whereNull('usage_limit')
                  ->orWhereColumn('used', '<', 'usage_limit');
            })
            ->get();

        // ✅ Thêm 1 ô mặc định "Chúc bạn may mắn lần sau"
        $defaultPrize = (object)[
            'id'    => null,
            'code'  => null,
            'label' => 'Chúc bạn may mắn lần sau',
            'chance'=> 50, // mặc định tỉ lệ trượt cao
        ];

        return view('front.spin.index', compact('coupons', 'defaultPrize'));
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

        // ✅ Lấy danh sách coupon hợp lệ
        $coupons = Coupon::where('is_active', 1)
            ->where('is_spin_prize', 1)
            ->where(function ($q) {
                $q->whereNull('expires_at')
                  ->orWhere('expires_at', '>', now());
            })
            ->where(function ($q) {
                $q->whereNull('usage_limit')
                  ->orWhereColumn('used', '<', 'usage_limit');
            })
            ->get();

        // ✅ Thêm ô mặc định "Chúc bạn may mắn lần sau"
        $defaultPrize = (object)[
            'id'    => null,
            'code'  => null,
            'label' => 'Chúc bạn may mắn lần sau',
            'chance'=> 50,
        ];

        // ✅ Gom tất cả phần thưởng
        $allPrizes = $coupons->map(function ($c) {
            return (object)[
                'id'    => $c->id,
                'code'  => $c->code,
                'label' => "Bạn nhận được: " . $c->code,
                'chance'=> $c->chance ?? 1,
                'model' => $c
            ];
        })->toArray();

        $allPrizes[] = $defaultPrize;

        // ✅ Random theo trọng số chance
        $weighted = [];
        foreach ($allPrizes as $p) {
            for ($i = 0; $i < $p->chance; $i++) {
                $weighted[] = $p;
            }
        }

        $prize = collect($weighted)->random();

        // ✅ Nếu là coupon thật → tăng số lần đã dùng
        if ($prize->id) {
            $prize->model->increment('used');
        }

        // ✅ Xác định index trên vòng quay để frontend quay đúng ô
        $prizesList = array_values($allPrizes);
        $index = collect($prizesList)->search(fn($p) => $p->id === $prize->id);

        // ✅ Lưu log kết quả
        SpinLog::create([
            'user_id'   => $user->id,
            'coupon_id' => $prize->id,
            'prize'     => $prize->label,
        ]);

        // ✅ Lưu coupon trúng vào session
        if ($prize->code) {
            $wonCoupons = session('won_coupons', []);
            if (!in_array($prize->code, $wonCoupons)) {
                $wonCoupons[] = $prize->code;
            }
            session(['won_coupons' => $wonCoupons]);
        }

        return response()->json([
            'success' => true,
            'prize'   => $prize->label,
            'coupon'  => $prize->code,
            'index'   => $index, // 👉 để frontend tính góc xoay
        ]);
    }
}

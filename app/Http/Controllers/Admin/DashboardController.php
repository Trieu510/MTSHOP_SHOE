<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Services\TrendingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Hiển thị trang tổng quan admin.
     */
    public function index(Request $request)
    {
        // ===============================
        // 📊 1️⃣ THỐNG KÊ DOANH THU & ĐƠN HÀNG
        // ===============================

        // Tổng đơn hoàn thành
        $totalOrders = Order::where('status', 'completed')->count();

        // Doanh thu hôm nay
        $todayRevenue = Order::where('status', 'completed')
            ->whereDate('created_at', Carbon::today())
            ->sum('total_amount');

        // Doanh thu hôm qua
        $yesterdayRevenue = Order::where('status', 'completed')
            ->whereDate('created_at', Carbon::yesterday())
            ->sum('total_amount');

        // Doanh thu tháng này
        $monthRevenue = Order::where('status', 'completed')
            ->whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', Carbon::now()->month)
            ->sum('total_amount');

        // Doanh thu tháng trước
        $lastMonthRevenue = Order::where('status', 'completed')
            ->whereYear('created_at', Carbon::now()->subMonth()->year)
            ->whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->sum('total_amount');

        // Tăng trưởng % hôm nay vs hôm qua
        $growthToday = $yesterdayRevenue > 0
            ? round((($todayRevenue - $yesterdayRevenue) / $yesterdayRevenue) * 100)
            : null;

        // Tăng trưởng % tháng này vs tháng trước
        $growthMonth = $lastMonthRevenue > 0
            ? round((($monthRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100)
            : null;

        // ===============================
        // 🏆 2️⃣ TOP SẢN PHẨM BÁN CHẠY
        // ===============================
        $topProducts = Product::select('products.id', 'products.name', DB::raw('SUM(order_items.quantity) as total_sold'))
            ->join('product_variants', 'products.id', '=', 'product_variants.product_id')
            ->join('order_items', 'product_variants.id', '=', 'order_items.product_variant_id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.status', 'completed')
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('total_sold')
            ->limit(5)
            ->get();

        // ===============================
        // 🔥 3️⃣ TOP SẢN PHẨM HOT (7 NGÀY)
        // ===============================
        $trendingService = new TrendingService();
        $trendingProducts = $trendingService->getTrendingProducts(5, 7);

        // ===============================
        // 🧾 4️⃣ ĐƠN HÀNG GẦN NHẤT
        // ===============================
        $recentOrders = Order::with('user')
            ->latest()
            ->take(5)
            ->get();

        // ===============================
        // 📤 Trả dữ liệu sang view
        // ===============================
        return view('admin.dashboard', compact(
            'totalOrders',
            'todayRevenue',
            'monthRevenue',
            'growthToday',
            'growthMonth',
            'topProducts',
            'recentOrders',
            'trendingProducts' // ✅ thêm biến mới
        ));
    }
}

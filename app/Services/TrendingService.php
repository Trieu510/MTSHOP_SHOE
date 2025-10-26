<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TrendingService
{
    /**
     * 📊 Lấy danh sách sản phẩm trending (hot)
     * - Dựa trên: lượt mua, wishlist, lượt xem trong khoảng thời gian nhất định
     * - Công thức điểm hotness = mua x 3 + wishlist x 2 + xem x 1
     */
    public function getTrendingProducts($limit = 8, $days = 7)
    {
        // ⏳ Nếu $days = 0 => lấy toàn thời gian
        $fromDate = $days > 0 ? Carbon::now()->subDays($days) : null;

        // 🛒 Đếm số lượt mua từ OrderItem
        $purchaseCounts = DB::table('order_items')
            ->select('product_id', DB::raw('COUNT(*) as purchase_count'))
            ->when($fromDate, fn($q) => $q->where('created_at', '>=', $fromDate))
            ->groupBy('product_id');

        // ❤️ Đếm số lượt wishlist
        $wishlistCounts = DB::table('wishlists')
            ->select('product_id', DB::raw('COUNT(*) as wishlist_count'))
            ->groupBy('product_id');

        // 👀 Đếm số lượt xem (UserActivity)
        $viewCounts = DB::table('user_activities')
            ->select('product_id', DB::raw('COUNT(*) as view_count'))
            ->where('action', 'view')
            ->when($fromDate, fn($q) => $q->where('created_at', '>=', $fromDate))
            ->groupBy('product_id');

        // 🧩 Kết hợp 3 nguồn dữ liệu và tính điểm hot
        $trending = DB::table('products')
            ->leftJoinSub($purchaseCounts, 'purchases', 'products.id', '=', 'purchases.product_id')
            ->leftJoinSub($wishlistCounts, 'wishlists', 'products.id', '=', 'wishlists.product_id')
            ->leftJoinSub($viewCounts, 'views', 'products.id', '=', 'views.product_id')
            ->select(
                'products.id',
                DB::raw('COALESCE(purchases.purchase_count, 0) as purchase_count'),
                DB::raw('COALESCE(wishlists.wishlist_count, 0) as wishlist_count'),
                DB::raw('COALESCE(views.view_count, 0) as view_count'),
                DB::raw('(COALESCE(purchases.purchase_count,0)*3 + COALESCE(wishlists.wishlist_count,0)*2 + COALESCE(views.view_count,0)) as score')
            )
            ->orderByDesc('score')
            ->limit($limit)
            ->get();

        // Không có sản phẩm hot
        if ($trending->isEmpty()) {
            return collect();
        }

        $productIds = $trending->pluck('id')->toArray();
        $orderedIds = implode(',', $productIds);

        // 🖼️ Lấy chi tiết sản phẩm + ảnh
        return Product::with('images')
            ->whereIn('id', $productIds)
            ->orderByRaw("FIELD(id, $orderedIds)")
            ->get()
            ->map(function ($product) use ($trending) {
                $row = $trending->firstWhere('id', $product->id);
                $product->purchase_count = $row->purchase_count ?? 0;
                $product->wishlist_count = $row->wishlist_count ?? 0;
                $product->view_count = $row->view_count ?? 0;
                $product->score = $row->score ?? 0;
                return $product;
            });
    }
}

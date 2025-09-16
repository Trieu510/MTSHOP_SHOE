<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SalesExport;
use App\Exports\OrdersExport;

class ReportController extends Controller
{
    /**
     * Hiển thị báo cáo doanh thu dưới dạng biểu đồ.
     */
    public function sales(Request $request)
    {
        $start = $request->input('start_date')
               ? Carbon::parse($request->input('start_date'))
               : now()->startOfMonth();
        $end   = $request->input('end_date')
               ? Carbon::parse($request->input('end_date'))
               : now();

        $type = $request->input('type', 'day');

        switch ($type) {
            case 'week':
                $raw = Order::selectRaw("YEAR(created_at) as year, WEEK(created_at, 3) as week, SUM(total_amount) as total")
                    ->whereBetween('created_at', [$start, $end])
                    ->groupBy('year', 'week')
                    ->orderBy('year')->orderBy('week')
                    ->get();

                $labels = $raw->map(fn($r) => 'Tuần ' . $r->week . '/' . $r->year)->toArray();
                $values = $raw->pluck('total')->toArray();
                break;

            case 'month':
                $raw = Order::selectRaw("YEAR(created_at) as year, MONTH(created_at) as month, SUM(total_amount) as total")
                    ->whereBetween('created_at', [$start, $end])
                    ->groupBy('year', 'month')
                    ->orderBy('year')->orderBy('month')
                    ->get();

                $labels = $raw->map(fn($r) => 'Tháng ' . $r->month . '/' . $r->year)->toArray();
                $values = $raw->pluck('total')->toArray();
                break;

            case 'quarter':
                $raw = Order::selectRaw("YEAR(created_at) as year, QUARTER(created_at) as quarter, SUM(total_amount) as total")
                    ->whereBetween('created_at', [$start, $end])
                    ->groupBy('year', 'quarter')
                    ->orderBy('year')->orderBy('quarter')
                    ->get();

                $labels = $raw->map(fn($r) => 'Q' . $r->quarter . '/' . $r->year)->toArray();
                $values = $raw->pluck('total')->toArray();
                break;

            default:
                $raw = Order::select(
                        DB::raw('DATE(created_at) as date'),
                        DB::raw('SUM(total_amount) as total')
                    )
                    ->whereBetween('created_at', [$start, $end])
                    ->groupBy('date')
                    ->orderBy('date', 'asc')
                    ->get();

                $labels = $raw->pluck('date')
                              ->map(fn($d) => Carbon::parse($d)->format('d/m'))
                              ->toArray();
                $values = $raw->pluck('total')->toArray();
        }

        $totalRevenue = array_sum($values);

        // Báo cáo theo danh mục
        $categoryRevenue = DB::table('orders')
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->join('product_variants', 'order_items.product_variant_id', '=', 'product_variants.id')
            ->join('products', 'product_variants.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->whereBetween('orders.created_at', [$start, $end])
            ->groupBy('categories.name')
            ->select('categories.name as category', DB::raw('SUM(order_items.quantity * order_items.price) as revenue'))
            ->orderByDesc('revenue')
            ->get();

        return view('admin.reports.sales', compact(
            'labels', 'values', 'totalRevenue', 'start', 'end', 'categoryRevenue', 'type'
        ));
    }

    public function exportSales(Request $request)
    {
        $fileName = 'sales_report_' . now()->format('Ymd_His') . '.xlsx';
        return Excel::download(new SalesExport(
            $request->input('start_date'),
            $request->input('end_date')
        ), $fileName);
    }

    public function orders(Request $request)
    {
        $raw = Order::select('status', DB::raw('COUNT(*) as count'))
                    ->groupBy('status')
                    ->orderBy('status')
                    ->get();

        $labels = $raw->pluck('status')
                      ->map(fn($s) => ucfirst($s))
                      ->toArray();
        $values = $raw->pluck('count')->toArray();

        return view('admin.reports.orders', compact('labels', 'values'));
    }

    public function exportOrders()
    {
        $fileName = 'orders_report_' . now()->format('Ymd_His') . '.xlsx';
        return Excel::download(new OrdersExport, $fileName);
    }
}

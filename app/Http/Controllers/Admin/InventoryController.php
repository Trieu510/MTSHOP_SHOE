<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductVariant;
use App\Models\StockLog;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\StockLogExport;
use Illuminate\Support\Facades\Auth;

class InventoryController extends Controller
{
    /**
     * Hiển thị danh sách tồn kho theo size (variant).
     */
    public function index(Request $request)
    {
        $query = ProductVariant::with('product.category');

        // Lọc theo tên sản phẩm
        if ($request->filled('keyword')) {
            $query->whereHas('product', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->keyword . '%');
            });
        }

        // Lọc theo tồn kho thấp (≤ 5)
        if ($request->input('low_stock') == '1') {
            $query->where('stock', '<=', 5);
        }

        // Lọc theo danh mục
        if ($request->filled('category_id')) {
            $query->whereHas('product', function ($q) use ($request) {
                $q->where('category_id', $request->category_id);
            });
        }

        $variants = $query->orderBy('stock', 'asc')->paginate(15)->withQueryString();

        return view('admin.inventories.index', compact('variants'));
    }

    public function edit($id)
{
    $variant = ProductVariant::with('product')->findOrFail($id);
    $product = $variant->product()->with('variants')->first();
    return view('admin.inventories.edit_multi', compact('product'));
}


public function update(Request $request, $id)
{
    $request->validate([
        'quantities' => 'required|array',
        'quantities.*' => 'nullable|integer|min:0',
        'notes' => 'nullable|array',
        'notes.*' => 'nullable|string|max:1000',
    ]);

    foreach ($request->quantities as $variantId => $qty) {
        if ($qty > 0) {
            $variant = ProductVariant::find($variantId);
            if ($variant) {
                // Cộng thêm kho
                $variant->increment('stock', $qty);

                // Ghi log
                StockLog::create([
                    'product_variant_id' => $variant->id,
                    'type' => 'import',
                    'quantity' => $qty,
                    'note' => $request->notes[$variantId] ?? null,
                    'admin_id' => Auth::id(),
                ]);
            }
        }
    }

    return redirect()->route('admin.inventory.index')->with('success', 'Đã nhập kho cho các size.');
}


public function logsByVariant(Request $request, $id)
{
    $variant = ProductVariant::with('product')->findOrFail($id);

    $logsQuery = $variant->stockLogs()->with('admin');

    if ($request->filled('start_date')) {
        $logsQuery->whereDate('created_at', '>=', $request->start_date);
    }

    if ($request->filled('end_date')) {
        $logsQuery->whereDate('created_at', '<=', $request->end_date);
    }

    $logs = $logsQuery->latest()->paginate(10);

    return view('admin.inventories.logs_by_variant', compact('variant', 'logs'));
}



public function logs(Request $request)
{
    $logsQuery = \App\Models\StockLog::with(['variant.product', 'admin']);

    if ($request->filled('start_date')) {
        $logsQuery->whereDate('created_at', '>=', $request->start_date);
    }

    if ($request->filled('end_date')) {
        $logsQuery->whereDate('created_at', '<=', $request->end_date);
    }

    $logs = $logsQuery->latest()->paginate(15);

    return view('admin.inventories.logs', compact('logs'));
}

}

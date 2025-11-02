@extends('layouts.admin')

@section('title', 'Dashboard')

@push('styles')
<style>
    :root {
        --primary-color: #6366f1;
        --primary-hover: #4f46e5;
        --accent-color: #f59e0b;
        --text-dark: #1e293b;
        --text-muted: #64748b;
        --light-bg: #f8fafc;
        --card-bg: #ffffff;
        --border-color: #e2e8f0;
        --shadow-sm: 0 1px 3px rgba(0,0,0,0.05);
        --shadow-md: 0 4px 6px rgba(0,0,0,0.08);
        --shadow-lg: 0 10px 15px rgba(0,0,0,0.1);
        --shadow-xl: 0 20px 25px rgba(0,0,0,0.12);
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        --border-radius: 0.75rem;
        --border-radius-lg: 1rem;
    }

    /* ===== Page Header ===== */
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2.5rem;
        padding-bottom: 1.5rem;
        border-bottom: 1px solid var(--border-color);
    }

    .page-title {
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--text-dark);
        position: relative;
        display: inline-block;
        padding-bottom: 0.5rem;
    }

    .page-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 50px;
        height: 4px;
        background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
        border-radius: 2px;
    }

    .breadcrumb {
        background-color: rgba(99, 102, 241, 0.08);
        padding: 0.5rem 1rem;
        border-radius: var(--border-radius);
        margin-bottom: 0;
    }

    .breadcrumb-item {
        font-size: 0.875rem;
    }

    .breadcrumb-item a {
        color: var(--primary-color);
        text-decoration: none;
        transition: var(--transition);
        font-weight: 500;
    }

    .breadcrumb-item a:hover {
        color: var(--primary-hover);
    }

    .breadcrumb-item.active {
        color: var(--text-muted);
    }

    .breadcrumb-item + .breadcrumb-item::before {
        color: var(--text-muted);
    }

    /* ===== Stat Cards ===== */
    .stat-card {
        background: var(--card-bg);
        border-radius: var(--border-radius-lg);
        box-shadow: var(--shadow-md);
        transition: var(--transition);
        overflow: hidden;
        border: none;
        position: relative;
        height: 100%;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-lg);
    }

    .stat-card .card-body {
        padding: 1.5rem;
        position: relative;
    }

    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1rem;
        background: linear-gradient(135deg, rgba(99, 102, 241, 0.1), rgba(245, 158, 11, 0.1));
        color: var(--primary-color);
        font-size: 1.5rem;
    }

    .stat-card .card-title {
        font-size: 0.875rem;
        font-weight: 600;
        color: var(--text-muted);
        margin-bottom: 0.5rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .stat-card .card-value {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 0;
    }

    .stat-card .card-currency {
        font-size: 1rem;
        font-weight: 600;
        color: var(--text-muted);
        margin-left: 0.25rem;
    }

    /* ===== Top Products Card ===== */
    .top-products-card {
        background: var(--card-bg);
        border-radius: var(--border-radius-lg);
        box-shadow: var(--shadow-md);
        transition: var(--transition);
        border: none;
        height: 100%;
    }

    .top-products-card:hover {
        box-shadow: var(--shadow-lg);
    }

    .top-products-card .card-header {
        background: var(--card-bg);
        border-bottom: 1px solid var(--border-color);
        padding: 1.25rem 1.5rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-top-left-radius: var(--border-radius-lg) !important;
        border-top-right-radius: var(--border-radius-lg) !important;
    }

    .top-products-card .card-title {
        font-size: 1.125rem;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 0;
    }

    .top-products-card .view-all {
        font-size: 0.875rem;
        font-weight: 600;
        color: var(--primary-color);
        text-decoration: none;
        transition: var(--transition);
    }

    .top-products-card .view-all:hover {
        color: var(--primary-hover);
    }

    .top-products-card .table {
        margin-bottom: 0;
    }

    .top-products-card .table thead th {
        background: var(--light-bg);
        font-weight: 600;
        color: var(--text-muted);
        border-bottom: 1px solid var(--border-color);
        padding: 1rem 1.5rem;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
    }

    .top-products-card .table tbody tr {
        transition: var(--transition);
    }

    .top-products-card .table tbody tr:hover {
        background-color: rgba(99, 102, 241, 0.03);
    }

    .top-products-card .table td,
    .top-products-card .table th {
        padding: 1rem 1.5rem;
        vertical-align: middle;
        border-bottom: 1px solid var(--border-color);
    }

    .top-products-card .table td:last-child {
        font-weight: 700;
        color: var(--primary-color);
    }

    .product-rank {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        background-color: var(--light-bg);
        color: var(--text-dark);
        font-weight: 700;
        font-size: 0.75rem;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .product-rank.top-1 {
        background-color: var(--primary-color);
        color: white;
    }

    .product-rank.top-2 {
        background-color: rgba(99, 102, 241, 0.2);
    }

    .product-rank.top-3 {
        background-color: rgba(99, 102, 241, 0.1);
    }

    /* ===== Responsive Adjustments ===== */
    @media (max-width: 992px) {
        .page-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
        }

        .breadcrumb {
            width: 100%;
        }
    }

    @media (max-width: 768px) {
        .page-title {
            font-size: 1.5rem;
        }

        .stat-card .card-body {
            padding: 1.25rem;
        }

        .stat-icon {
            width: 40px;
            height: 40px;
            font-size: 1.25rem;
        }

        .stat-card .card-value {
            font-size: 1.25rem;
        }

        .top-products-card .card-header {
            padding: 1rem;
        }

        .top-products-card .card-title {
            font-size: 1rem;
        }

        .top-products-card .table th,
        .top-products-card .table td {
            padding: 0.75rem 1rem;
        }
        .table td, .table th {
    color: #e2e8f0;
}
.table tbody tr:hover {
    background-color: rgba(99, 102, 241, 0.1) !important;
}
.text-warning { color: #fbbf24 !important; }
.text-white a:hover {
    color: #a5b4fc !important;
}

    }
</style>
@endpush

@section('content')
<div class="container-fluid py-4">
    <!-- Page Header -->
    <div class="page-header">
        <h2 class="page-title">Dashboard</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
            </ol>
        </nav>
    </div>

    <!-- Stat Cards -->
    <div class="row g-4">
    <!-- Tổng đơn hàng -->
    <div class="col-md-6 col-xl-3">
        <div class="card stat-card">
            <div class="card-body">
                <div class="stat-icon">
                    <i class="bi bi-cart4"></i>
                </div>
                <h5 class="card-title">Tổng đơn hàng</h5>
                <p class="card-value">{{ number_format($totalOrders) }}</p>
            </div>
        </div>
    </div>

    <!-- Doanh thu hôm nay -->
    <div class="col-md-6 col-xl-3">
        <div class="card stat-card">
            <div class="card-body">
                <div class="stat-icon">
                    <i class="bi bi-currency-dollar"></i>
                </div>
                <h5 class="card-title">Doanh thu hôm nay</h5>
                <p class="card-value">{{ number_format($todayRevenue, 0) }}<span class="card-currency">₫</span></p>
                @if(!is_null($growthToday))
                    <p class="text-sm text-muted mt-1">
                        <i class="bi {{ $growthToday >= 0 ? 'bi-graph-up-arrow text-success' : 'bi-graph-down-arrow text-danger' }}"></i>
                        {{ $growthToday >= 0 ? '+' : '-' }}{{ abs($growthToday) }}% so với hôm qua
                    </p>
                @else
                    <p class="text-sm text-muted mt-1">Không có dữ liệu hôm qua</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Doanh thu tháng này -->
    <div class="col-md-6 col-xl-3">
        <div class="card stat-card">
            <div class="card-body">
                <div class="stat-icon">
                    <i class="bi bi-calendar2-week"></i>
                </div>
                <h5 class="card-title">Doanh thu tháng này</h5>
                <p class="card-value">{{ number_format($monthRevenue, 0) }}<span class="card-currency">₫</span></p>
                @if(!is_null($growthMonth))
                    <p class="text-sm text-muted mt-1">
                        <i class="bi {{ $growthMonth >= 0 ? 'bi-graph-up-arrow text-success' : 'bi-graph-down-arrow text-danger' }}"></i>
                        {{ $growthMonth >= 0 ? '+' : '-' }}{{ abs($growthMonth) }}% so với tháng trước
                    </p>
                @else
                    <p class="text-sm text-muted mt-1">Không có dữ liệu tháng trước</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Sản phẩm phổ biến -->
    <div class="col-md-6 col-xl-3">
        <div class="card stat-card">
            <div class="card-body">
                <div class="stat-icon">
                    <i class="bi bi-graph-up"></i>
                </div>
                <h5 class="card-title">Sản phẩm phổ biến</h5>
                <p class="card-value">{{ $topProducts->first()?->name ?? 'N/A' }}</p>
            </div>
        </div>
    </div>
</div>


<!-- 🏆 Top bán chạy + 🔥 Top hot -->
<div class="row mt-4 g-4">
    <!-- 🏆 Top sản phẩm bán chạy -->
    <div class="col-lg-6">
        <div class="card top-products-card h-100">
            <div class="card-header">
                <h5 class="card-title">🏆 Top 5 sản phẩm bán chạy</h5>
                <a href="{{ route('admin.products.index') }}" class="view-all">
                    Xem tất cả <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Sản phẩm</th>
                                <th>Số lượng bán</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($topProducts as $index => $product)
                            <tr>
                                <td><div class="product-rank top-{{ $index + 1 }}">{{ $index + 1 }}</div></td>
                                <td>{{ $product->name }}</td>
                                <td class="fw-bold text-primary">{{ number_format($product->total_sold) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- 🔥 Top sản phẩm hot -->
    <div class="col-lg-6">
        <div class="card top-products-card h-100">
            <div class="card-header">
                <h5 class="card-title">🔥 Top sản phẩm hot (7 ngày gần nhất)</h5>
                <a href="{{ route('products.trending') }}" target="_blank" class="view-all">
                    Xem chi tiết <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Sản phẩm</th>
                                <th>👀</th>
                                <th>❤️</th>
                                <th>🛒</th>
                                <th>🔥</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($trendingProducts as $index => $product)
                            <tr>
                                <td><div class="product-rank top-{{ $index + 1 }}">{{ $index + 1 }}</div></td>
                                <td>
                                    <a href="{{ route('products.show', $product->slug) }}" target="_blank"
                                       class="text-decoration-none fw-semibold text-white"  >
                                       {{ $product->name }}
                                    </a>
                                </td>
                                <td>{{ $product->view_count ?? 0 }}</td>
                                <td>{{ $product->wishlist_count ?? 0 }}</td>
                                <td>{{ $product->purchase_count ?? 0 }}</td>
                                <td class="fw-bold text-warning">{{ $product->score ?? 0 }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="6" class="text-center text-muted py-3">Chưa có dữ liệu xu hướng</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 🧾 Đơn hàng gần nhất -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card top-products-card">
            <div class="card-header">
                <h5 class="card-title">🧾 Đơn hàng gần nhất</h5>
                <a href="{{ route('admin.orders.index') }}" class="view-all">
                    Xem tất cả <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Mã đơn</th>
                                <th>Khách hàng</th>
                                <th>Ngày đặt</th>
                                <th>Tổng tiền</th>
                                <th>Trạng thái</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentOrders as $order)
                            <tr>
                                <td>#{{ $order->id }}</td>
                                <td>{{ $order->user->name ?? $order->name }}</td>
                                <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                <td>{{ number_format($order->total_amount, 0) }}₫</td>
                                <td><span class="badge bg-secondary">{{ ucfirst($order->status) }}</span></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

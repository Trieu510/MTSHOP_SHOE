@extends('layouts.admin')

@section('title', 'Báo cáo doanh thu')

@section('content')
<div class="container-fluid py-4">
    <h1 class="fw-bold mb-4 text-dark">📊 Báo cáo Doanh thu</h1>

    <div class="row g-4">
        {{-- Bộ lọc ngày và tổng doanh thu --}}
        <div class="col-md-4">
            <div class="card border-0 shadow-lg rounded-4 h-100">
                <div class="card-body">
                    <form method="GET" action="{{ route('admin.reports.sales') }}">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Từ ngày</label>
                            <input type="date" name="start_date" class="form-control shadow-sm rounded-3"
                                   value="{{ $start->format('Y-m-d') }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Đến ngày</label>
                            <input type="date" name="end_date" class="form-control shadow-sm rounded-3"
                                   value="{{ $end->format('Y-m-d') }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Loại thống kê</label>
                            <select name="type" class="form-select shadow-sm rounded-3">
                                <option value="day" {{ $type === 'day' ? 'selected' : '' }}>Theo ngày</option>
                                <option value="week" {{ $type === 'week' ? 'selected' : '' }}>Theo tuần</option>
                                <option value="month" {{ $type === 'month' ? 'selected' : '' }}>Theo tháng</option>
                                <option value="quarter" {{ $type === 'quarter' ? 'selected' : '' }}>Theo quý</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 rounded-pill shadow-sm">
                            <i class="bi bi-funnel-fill me-1"></i> Lọc dữ liệu
                        </button>
                    </form>

                    <hr class="my-4">

                    <div class="text-center">
                        <h6 class="text-muted">Tổng doanh thu</h6>
                        <h4 class="text-danger fw-bold">
                            {{ number_format($totalRevenue, 0) }} ₫
                        </h4>
                    </div>
                </div>
            </div>
        </div>

        {{-- Biểu đồ --}}
        <div class="col-md-8">
            <div class="card border-0 shadow-lg rounded-4">
                <div class="card-body p-4">
                    <div class="chart-container" style="position: relative; height: 360px;">
                        <canvas id="salesChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Chi tiết doanh thu --}}
    <div class="card shadow-lg border-0 rounded-4 mt-4">
        <div class="card-body p-4">
            <h5 class="fw-bold text-dark mb-3">📅 Chi tiết doanh thu</h5>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Thời gian</th>
                            <th>Doanh thu</th>
                            <th>Tỷ lệ (%)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($labels as $index => $label)
                        <tr>
                            <td>{{ $label }}</td>
                            <td>{{ number_format($values[$index], 0) }} ₫</td>
                            <td>
                                {{ number_format(($totalRevenue > 0 ? $values[$index] / $totalRevenue * 100 : 0), 1) }}%
                                <div class="progress mt-1" style="height: 8px;">
                                    <div class="progress-bar bg-primary" role="progressbar"
                                         style="width: {{ $values[$index] / max($totalRevenue, 1) * 100 }}%;">
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="text-end mt-4">
                <a href="{{ route('admin.reports.sales.export', ['start_date' => $start->format('Y-m-d'), 'end_date' => $end->format('Y-m-d')]) }}"
                   class="btn btn-success btn-lg rounded-pill shadow-sm">
                    <i class="bi bi-file-earmark-excel me-2"></i> Xuất Excel
                </a>
            </div>
        </div>
    </div>

    {{-- Doanh thu theo danh mục sản phẩm --}}
    <div class="card shadow-lg border-0 rounded-4 mt-4">
        <div class="card-body p-4">
            <h5 class="fw-bold text-dark mb-3">🗂️ Doanh thu theo danh mục sản phẩm</h5>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Danh mục</th>
                            <th>Doanh thu</th>
                            <th>Tỷ lệ (%)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $totalCategoryRevenue = $categoryRevenue->sum('revenue'); @endphp
                        @foreach($categoryRevenue as $cat)
                        <tr>
                            <td>{{ $cat->category }}</td>
                            <td>{{ number_format($cat->revenue, 0) }} ₫</td>
                            <td>
                                {{ number_format($cat->revenue / max($totalCategoryRevenue, 1) * 100, 1) }}%
                                <div class="progress mt-1" style="height: 8px;">
                                    <div class="progress-bar bg-success" role="progressbar"
                                         style="width: {{ $cat->revenue / max($totalCategoryRevenue, 1) * 100 }}%;"></div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const labels = {!! json_encode($labels) !!};
    const dataPoints = {!! json_encode($values) !!};

    const ctx = document.getElementById('salesChart').getContext('2d');
    const gradient = ctx.createLinearGradient(0, 0, 0, 360);
    gradient.addColorStop(0, 'rgba(0, 123, 255, 0.4)');
    gradient.addColorStop(1, 'rgba(0, 123, 255, 0.05)');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels,
            datasets: [{
                label: 'Doanh thu (₫)',
                data: dataPoints,
                fill: true,
                backgroundColor: gradient,
                borderColor: '#007bff',
                tension: 0.4,
                pointBackgroundColor: '#fff',
                pointBorderColor: '#007bff',
                pointRadius: 5,
                pointHoverRadius: 8
            }]
        },
        options: {
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: ctx => ` ${new Intl.NumberFormat('vi-VN').format(ctx.parsed.y)} ₫`
                    }
                },
                title: {
                    display: true,
                    text: 'Biểu đồ doanh thu',
                    font: { size: 18 },
                    padding: { bottom: 20 }
                }
            },
            scales: {
                y: {
                    ticks: {
                        callback: value => new Intl.NumberFormat('vi-VN').format(value) + ' ₫'
                    },
                    grid: { color: '#e9ecef' }
                },
                x: {
                    ticks: {
                        maxRotation: 45,
                        minRotation: 45
                    },
                    grid: { display: false }
                }
            }
        }
    });
</script>
@endpush
@endsection

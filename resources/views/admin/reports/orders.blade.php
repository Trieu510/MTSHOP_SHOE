@extends('layouts.admin')

@section('title', 'Báo cáo đơn hàng')

@section('content')
<div class="container-fluid py-4">
    @include('admin.partials.alerts')

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold text-dark">📦 Báo cáo Đơn hàng</h1>
        <a href="{{ route('admin.reports.orders.export') }}" class="btn btn-success btn-lg rounded-pill shadow-sm">
            <i class="bi bi-file-earmark-excel me-2"></i> Xuất Excel
        </a>
    </div>

    {{-- Biểu đồ --}}
    <div class="card shadow-lg border-0 rounded-4 mb-4">
        <div class="card-body d-flex justify-content-center py-5">
            <canvas id="ordersChart" style="max-width: 450px; width: 100%; height: 350px;"></canvas>
        </div>
    </div>

    {{-- Chi tiết --}}
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-body p-4">
            <h5 class="fw-bold text-dark mb-3">📋 Chi tiết số liệu đơn hàng</h5>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Trạng thái</th>
                            <th>Số lượng đơn</th>
                            <th>Tỷ lệ (%)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($labels as $index => $label)
                            <tr>
                                <td>{{ $label }}</td>
                                <td>{{ $values[$index] }}</td>
                                <td>
                                    {{ number_format(($values[$index] / array_sum($values) * 100), 1) }}%
                                    <div class="progress mt-1" style="height: 8px;">
                                        <div class="progress-bar" role="progressbar"
                                             style="width: {{ ($values[$index] / array_sum($values) * 100) }}%; background-color: hsl({{ $index * 60 % 360 }}, 70%, 60%);"
                                             aria-valuenow="{{ ($values[$index] / array_sum($values) * 100) }}"
                                             aria-valuemin="0" aria-valuemax="100">
                                        </div>
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
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const orderLabels = {!! json_encode($labels) !!};
    const orderValues = {!! json_encode($values) !!};

    new Chart(document.getElementById('ordersChart'), {
        type: 'doughnut',
        data: {
            labels: orderLabels,
            datasets: [{
                data: orderValues,
                backgroundColor: orderLabels.map((_, i) => `hsl(${i * 60 % 360}, 70%, 60%)`),
                borderWidth: 2,
                borderColor: '#fff',
                hoverOffset: 20
            }]
        },
        options: {
            maintainAspectRatio: false,
            cutout: '55%',
            plugins: {
                legend: {
                    position: window.innerWidth > 768 ? 'right' : 'bottom',
                    labels: {
                        boxWidth: 14,
                        padding: 20,
                        font: { size: 14 },
                        usePointStyle: true,
                        pointStyle: 'circle'
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    cornerRadius: 8,
                    padding: 12,
                    callbacks: {
                        label: ctx => `${ctx.label}: ${ctx.parsed} đơn (${(ctx.parsed / ctx.dataset.data.reduce((a, b) => a + b, 0) * 100).toFixed(1)}%)`
                    }
                },
                title: {
                    display: true,
                    text: '📈 Tỷ lệ đơn hàng theo trạng thái',
                    padding: { bottom: 20, top: 10 },
                    font: { size: 18, weight: 'bold' },
                    color: '#1f2a44'
                }
            },
            animation: {
                animateScale: true,
                animateRotate: true
            }
        }
    });
</script>

<style>
.card {
    transition: transform 0.2s;
}
.card:hover {
    transform: translateY(-2px);
}
.btn {
    transition: all 0.2s;
}
.btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}
.table th, .table td {
    font-size: 0.95rem;
    padding: 12px;
}
.table-light {
    background-color: #f8f9fc !important;
}
.progress {
    background-color: #e9ecef;
    border-radius: 4px;
}
</style>
@endpush

@extends('layouts.admin')

@section('title', 'Lịch sử nhập kho')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-dark">Lịch sử nhập kho</h2>
    </div>

    @include('admin.partials.alerts')

    <div class="card shadow-lg border-0 rounded-4 bg-gradient-light">
        <div class="px-3 pt-3">
            <!-- Form lọc tìm kiếm -->
            <form method="GET" class="row g-2 align-items-end">
                <div class="col-md-3">
                    <label class="form-label">Từ ngày</label>
                    <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Đến ngày</label>
                    <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-funnel"></i> Lọc
                    </button>
                    @if(request()->has('start_date') || request()->has('end_date'))
                        <a href="{{ route('admin.inventory.logs.index') }}" class="btn btn-outline-secondary ms-2">
                            <i class="bi bi-x-circle"></i> Xóa lọc
                        </a>
                    @endif
                </div>
                <div class="col-md-3 text-end">
                    <a href="{{ route('admin.inventory.logs.export', request()->all()) }}" class="btn btn-success">
                        <i class="bi bi-file-earmark-excel"></i> Xuất Excel
                    </a>
                </div>
            </form>
        </div>

        <div class="table-responsive p-3 pt-0">
            <table class="table mb-0 align-middle">
                <thead class="table-light">
                    <tr>
                        <th class="text-center">#</th>
                        <th>Sản phẩm</th>
                        <th class="text-center">Size</th>
                        <th class="text-center">Số lượng</th>
                        <th>Ghi chú</th>
                        <th>Người nhập</th>
                        <th class="text-center">Thời gian</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($logs as $log)
                        <tr class="table-row">
                            <td class="text-center">{{ $log->id }}</td>
                            <td>{{ $log->variant->product->name ?? '[N/A]' }}</td>
                            <td class="text-center">{{ $log->variant->size ?? '-' }}</td>
                            <td class="text-center">{{ $log->quantity }}</td>
                            <td>{{ $log->note ?? '-' }}</td>
                            <td>{{ $log->admin->name ?? 'Admin' }}</td>
                            <td class="text-center">{{ $log->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">Không có log nhập kho nào.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Phân trang -->
        <div class="card-footer bg-transparent border-0 p-4">
            {{ $logs->links() }}
        </div>
    </div>
</div>

<style>
    /* Sử dụng lại các style từ giao diện trước */
    .bg-gradient-light {
        background: linear-gradient(180deg, #ffffff, #f8f9fc);
        box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    .card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
    }

    .table-row {
        transition: background-color 0.3s ease;
    }

    .table-row:hover {
        background-color: #f1f3f5;
    }

    .table th, .table td {
        font-size: 0.95rem;
        padding: 12px;
        vertical-align: middle;
    }

    .table-light {
        background-color: #f8f9fc !important;
    }

    .btn-success {
        transition: all 0.3s ease;
    }

    .btn-success:hover {
        background-color: #146c43;
        transform: translateY(-2px);
    }

    .form-control {
        transition: all 0.3s ease;
        border: 1px solid #dee2e6;
    }

    .form-control:focus {
        border-color: #86b7fe;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
    }

    @media (max-width: 768px) {
        .table-responsive {
            font-size: 0.9rem;
        }

        .row.g-2.align-items-end {
            gap: 10px;
        }

        .col-md-3 {
            width: 100%;
        }

        .btn {
            width: 100%;
            margin-bottom: 5px;
        }
    }
</style>
@endsection

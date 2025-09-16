@extends('layouts.admin')

@section('title', 'Phí Vận Chuyển')

@section('content')
<style>
    .shipping-fees-container {
        background: linear-gradient(135deg, #f5f7fa 0%, #e4e7eb 100%);
        min-height: 100vh;
        padding: 2rem;
    }

    .card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }

    .card:hover {
        transform: translateY(-5px);
    }

    .table {
        border-radius: 10px;
        overflow: hidden;
    }

    .table th {
        background: #f8f9fa;
        border-bottom: 2px solid #dee2e6;
        padding: 1rem;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.9rem;
        color: #495057;
    }

    .table td {
        vertical-align: middle;
        padding: 1rem;
        border-bottom: 1px solid #e9ecef;
    }

    .table tr:hover {
        background: #f1f3f5;
    }

    .btn-primary {
        background: #007bff;
        border: none;
        border-radius: 8px;
        padding: 0.75rem 1.5rem;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        background: #0056b3;
        transform: translateY(-2px);
    }

    .btn-outline-warning, .btn-outline-danger {
        border-radius: 8px;
        padding: 0.5rem 1rem;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-outline-warning:hover, .btn-outline-danger:hover {
        transform: translateY(-2px);
    }

    .alert {
        border-radius: 10px;
        padding: 1rem;
        animation: fadeIn 0.5s ease-in;
    }

    .alert-success {
        background: #d4edda;
        color: #155724;
        border: none;
    }

    .table-responsive {
        border-radius: 10px;
        overflow: hidden;
    }

    .pagination {
        justify-content: center;
        margin-top: 1.5rem;
    }

    .pagination .page-link {
        border-radius: 8px;
        margin: 0 0.2rem;
        transition: all 0.3s ease;
    }

    .pagination .page-link:hover {
        background: #007bff;
        color: white;
    }

    .pagination .page-item.active .page-link {
        background: #007bff;
        border-color: #007bff;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @media (max-width: 768px) {
        .shipping-fees-container {
            padding: 1rem;
        }

        .table {
            font-size: 0.9rem;
        }

        .btn {
            padding: 0.5rem 0.75rem;
        }
    }
</style>

<div class="container-fluid shipping-fees-container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-dark fw-bold"><i class="bi bi-truck me-2"></i>Danh sách Phí Vận Chuyển</h2>
        <a href="{{ route('admin.shipping_fees.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-2"></i>Thêm mới
        </a>
    </div>

    @include('admin.partials.alerts')
<form method="GET" action="{{ route('admin.shipping_fees.index') }}" class="row g-3 mb-4">
    <div class="col-md-4">
        <select name="province" class="form-select">
            <option value="">-- Tất cả Tỉnh/Thành --</option>
            @foreach($provinces as $province)
                <option value="{{ $province }}" {{ request('province') == $province ? 'selected' : '' }}>
                    {{ $province }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-2">
        <button type="submit" class="btn btn-outline-primary w-100">
            <i class="bi bi-filter-circle me-1"></i> Lọc
        </button>
    </div>
    <div class="col-md-2">
        <a href="{{ route('admin.shipping_fees.index') }}" class="btn btn-outline-secondary w-100">
            <i class="bi bi-x-circle me-1"></i> Đặt lại
        </a>
    </div>
</form>

    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Tỉnh/Thành</th>
                        <th>Phí Ship (VNĐ)</th>
                        <th class="text-center">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($shippingFees as $i => $fee)
                        <tr>
                            <td>{{ $loop->iteration + ($shippingFees->currentPage() - 1) * $shippingFees->perPage() }}</td>
                            <td class="fw-medium">{{ $fee->province }}</td>
                            <td>{{ number_format($fee->fee, 0, ',', '.') }} ₫</td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('admin.shipping_fees.edit', $fee) }}" class="btn btn-sm btn-outline-warning">
                                        <i class="bi bi-pencil me-1"></i>Sửa
                                    </a>
                                    <form action="{{ route('admin.shipping_fees.destroy', $fee) }}" method="POST" class="d-inline" onsubmit="return confirm('Xóa mục này?');">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger">
                                            <i class="bi bi-trash3 me-1"></i>Xoá
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    @if($shippingFees->isEmpty())
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">
                                <i class="bi bi-info-circle me-2"></i>Chưa có dữ liệu
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
        <div class="p-3">
            {{ $shippingFees->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection

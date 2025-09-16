@extends('layouts.admin')

@section('title', 'Quản lý Đơn hàng')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-dark">Danh sách Đơn hàng</h2>
    </div>

    @include('admin.partials.alerts')

    <form method="GET" action="{{ route('admin.orders.index') }}" class="row g-3 mb-4">
    <div class="col-md-2">
        <input type="number" name="order_id" class="form-control" placeholder="Mã đơn" value="{{ request('order_id') }}">
    </div>
    <div class="col-md-2">
        <input type="text" name="customer" class="form-control" placeholder="Khách hàng" value="{{ request('customer') }}">
    </div>
    <div class="col-md-2">
        <input type="number" name="total_min" class="form-control" placeholder="Tổng tiền từ" value="{{ request('total_min') }}">
    </div>
    <div class="col-md-2">
        <input type="number" name="total_max" class="form-control" placeholder="Tổng tiền đến" value="{{ request('total_max') }}">
    </div>
    <div class="col-md-2">
        <select name="status" class="form-select">
            <option value="">-- Trạng thái --</option>
            <option value="pending" {{ request('status')=='pending' ? 'selected' : '' }}>Chờ xử lý</option>
            <option value="confirmed" {{ request('status')=='confirmed' ? 'selected' : '' }}>Đã xác nhận</option>
            <option value="processing" {{ request('status')=='processing' ? 'selected' : '' }}>Đang vận chuyển</option>
            <option value="completed" {{ request('status')=='completed' ? 'selected' : '' }}>Đã hoàn thành</option>
            <option value="canceled" {{ request('status')=='canceled' ? 'selected' : '' }}>Đã hủy</option>
        </select>
    </div>
    <div class="col-md-2">
        <input type="date" name="date" class="form-control" value="{{ request('date') }}">
    </div>
    <div class="col-md-1 d-grid">
        <button class="btn btn-dark"><i class="bi bi-search"></i></button>
    </div>
    <div class="col-md-1 d-grid">
        <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Xóa lọc</a>
    </div>
</form>


    <div class="card shadow-lg border-0 rounded-4 bg-gradient-light">
        <div class="table-responsive p-3">
            <table class="table align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Mã đơn</th>
                        <th>Khách hàng</th>
                        <th>Tổng tiền</th>
                        <th>Trạng thái</th>
                        <th>Ngày đặt</th>
                        <th class="text-center">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                    <tr class="table-row">
                        <th scope="row">{{ $loop->iteration + ($orders->currentPage()-1)*$orders->perPage() }}</th>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->user?->name ?? 'Khách vãng lai' }}</td>
                        <td>{{ number_format($order->total_amount, 0) }} ₫</td>
                        <td>
                            @php
    $statusClass = match($order->status) {
        'pending' => 'warning',
        'confirmed' => 'primary',
        'processing' => 'info',
        'completed' => 'success',
        'canceled' => 'danger',
        default => 'secondary',
    };

    $statusText = match($order->status) {
        'pending' => 'Chờ xử lý',
        'confirmed' => 'Đã xác nhận',
        'processing' => 'Đang vận chuyển',
        'completed' => 'Đã hoàn thành',
        'canceled' => 'Đã hủy',
        default => ucfirst($order->status),
    };
@endphp

<span class="badge custom-badge bg-{{ $statusClass }}">
    {{ $statusText }}
</span>

                        </td>
                        <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-outline-primary btn-icon">
                                    <i class="bi bi-eye-fill"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    /* Custom CSS để cải tiến giao diện */
    body {
        background-color: #f8f9fc;
    }

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

    .custom-badge {
        border-radius: 12px;
        padding: 6px 12px;
        font-size: 0.85rem;
        font-weight: 500;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .custom-badge:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
    }

    .btn-icon {
        border-radius: 50%;
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    .btn-outline-primary.btn-icon:hover {
        background-color: #007bff;
        border-color: #007bff;
        color: #fff;
        transform: scale(1.1);
    }

    .btn-outline-danger.btn-icon:hover {
        background-color: #dc3545;
        border-color: #dc3545;
        color: #fff;
        transform: scale(1.1);
    }

    h2 {
        color: #1a1a1a;
        font-size: 1.8rem;
    }

    .table th, .table td {
        font-size: 0.95rem;
        padding: 12px;
    }

    .table-light {
        background-color: #f8f9fc !important;
    }

    @media (max-width: 768px) {
        .table-responsive {
            font-size: 0.9rem;
        }

        .btn-icon {
            width: 32px;
            height: 32px;
        }

        .custom-badge {
            font-size: 0.8rem;
            padding: 5px 10px;
        }

        .d-flex.gap-2 {
            gap: 8px !important;
        }
    }
</style>
@endsection

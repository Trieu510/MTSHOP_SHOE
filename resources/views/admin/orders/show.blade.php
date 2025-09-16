@extends('layouts.admin')

@section('title', 'Chi tiết Đơn hàng')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <h2 class="fw-bold text-dark mb-0">Chi tiết Đơn hàng #{{ $order->id }}</h2>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.orders.print', $order->id) }}" target="_blank" class="btn btn-outline-primary">
            <i class="bi bi-printer me-1"></i> In đơn hàng
        </a>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary btn-back">
            <i class="bi bi-arrow-left-circle me-1"></i> Quay về
        </a>
    </div>
</div>


    @include('admin.partials.alerts')

    <div class="row g-4">
        <div class="col-md-6">
            <div class="card shadow-lg border-0 mb-4 rounded-4 bg-gradient-light">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0 fw-semibold text-dark">Thông tin Khách hàng</h5>
                </div>
                <div class="card-body">
                    <p><strong>Tên:</strong> {{ $order->user?->name ?? $order->name }}</p>
                    <p><strong>SĐT:</strong> {{ $order->phone }}</p>
                    <p><strong>Địa chỉ:</strong> {{ $order->address }}</p>
                </div>
            </div>

            <div class="card shadow-lg border-0 rounded-4 bg-gradient-light">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0 fw-semibold text-dark">Cập nhật Trạng thái</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.orders.update', $order) }}" method="POST">
                        @csrf @method('PUT')
                        <div class="mb-4">
                            <label for="status" class="form-label fw-semibold text-dark">Trạng thái</label>
                            <select id="status" name="status" class="form-select form-control-custom @error('status') is-invalid @enderror">
                                <option value="pending" {{ $order->status=='pending' ? 'selected' : '' }}>Chờ xử lý</option>
                                <option value="confirmed" {{ $order->status=='confirmed' ? 'selected' : '' }}>Đã xác nhận</option>
                                <option value="processing" {{ $order->status=='processing' ? 'selected' : '' }}>Đang vận chuyển</option>
                                <option value="completed" {{ $order->status=='completed' ? 'selected' : '' }}>Hoàn thành</option>
                                
                            </select>
                            @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <button type="submit" class="btn btn-primary btn-save">
                            <i class="bi bi-save2 me-1"></i> Lưu trạng thái
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow-lg border-0 rounded-4 bg-gradient-light">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0 fw-semibold text-dark">Chi tiết Sản phẩm</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Ảnh</th>
                                    <th>Sản phẩm</th>
                                    <th>Size</th>
                                    <th>Giá</th>
                                    <th>Số lượng</th>
                                    <th>Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody>
    @foreach($order->items as $item)
        <tr class="table-row">
            <td>{{ $loop->iteration }}</td>

            <td>
                @php
                    $image = optional($item->variant->product->images->first())->path;
                @endphp
                @if($image)
                    <img src="{{ asset('storage/' . $image) }}" alt="Ảnh" width="60" style="border-radius: 8px;">
                @else
                    <span class="text-muted">Không ảnh</span>
                @endif
            </td>

            <td>{{ $item->product_name }}</td>
            <td>{{ $item->variant->size ?? '-' }}</td>
            <td>{{ number_format($item->price, 0) }} ₫</td>
            <td>{{ $item->quantity }}</td>
            <td class="fw-bold">{{ number_format($item->subtotal, 0) }} ₫</td>
        </tr>
    @endforeach

    <tr class="table-secondary">
        <td colspan="6" class="text-end fw-bold">Tổng cộng:</td>
        <td class="fw-bold">{{ number_format($order->total_amount, 0) }} ₫</td>
    </tr>
</tbody>

                        </table>
                    </div>
                </div>
            </div>
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

    .card-header {
        padding: 16px 20px;
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
    }

    .table-light {
        background-color: #f8f9fc !important;
    }

    .table-secondary {
        background-color: #e9ecef !important;
        font-size: 0.95rem;
    }

    .form-control-custom {
        border-radius: 8px;
        border: 1px solid #ced4da;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3E%3Cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3E%3C/svg%3E");
        background-size: 12px;
    }

    .form-control-custom:focus {
        border-color: #0066CC;
        box-shadow: 0 0 0 0.2rem rgba(0, 102, 204, 0.25);
    }

    .btn-back, .btn-save {
        border-radius: 8px;
        padding: 10px 20px;
        transition: all 0.3s ease;
    }

    .btn-back:hover {
        background-color: #5a6268;
        transform: scale(1.05);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    }

    .btn-save:hover {
        background-color: #0052a3;
        transform: scale(1.05);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    }

    h2 {
        color: #1a1a1a;
        font-size: 1.8rem;
    }

    h5 {
        color: #1a1a1a;
        font-size: 1.2rem;
    }

    p, .form-label {
        font-size: 0.95rem;
    }

    @media (max-width: 768px) {
        .table-responsive {
            font-size: 0.9rem;
        }

        .btn-back, .btn-save {
            width: 100%;
            text-align: center;
            margin-bottom: 10px;
        }

        .card-header {
            padding: 12px 16px;
        }

        .table th, .table td {
            padding: 10px;
        }
    }
</style>
@endsection

@extends('layouts.admin')

@section('title', 'Quản lý Flash Sale')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-dark">Quản lý Flash Sale</h2>
        <a href="{{ route('admin.flash-sales.create') }}" class="btn btn-primary btn-add">
            <i class="bi bi-plus-circle me-1"></i> Tạo mới
        </a>
    </div>

    @include('admin.partials.alerts')

    <div class="card shadow-lg border-0 rounded-4 bg-gradient-light">
        <div class="px-3 pt-3">
            <!-- Form lọc tìm kiếm (nếu cần) -->
            <!-- Có thể thêm form tìm kiếm tương tự giao diện danh mục -->
        </div>

        <div class="table-responsive p-3 pt-0">
            <table class="table mb-0 align-middle">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Áp dụng cho</th>
                        <th>Giảm theo %</th>
                        <th>Giảm cố định</th>
                        <th>Bắt đầu</th>
                        <th>Kết thúc</th>
                        <th>Trạng thái</th>
                        <th class="text-center">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($flashSales as $sale)
                    <tr class="table-row">
                        <td>{{ $sale->id }}</td>
                        <td>
                            @if($sale->applies_to == 'all')
                                <span class="text-primary fw-medium">Tất cả SP</span>
                            @elseif($sale->applies_to == 'category')
                                <span class="text-info fw-medium">Danh mục: {{ optional($sale->category)->name }}</span>
                            @elseif($sale->applies_to == 'product')
                                <span class="text-success fw-medium">SP: {{ optional($sale->product)->name }}</span>
                            @else
                                -
                            @endif
                        </td>
                        <td>{{ $sale->discount_percent ?? '-' }}%</td>
                        <td>{{ $sale->discount_amount ? number_format($sale->discount_amount) . '₫' : '-' }}</td>
                        <td>{{ $sale->start_time }}</td>
                        <td>{{ $sale->end_time }}</td>
                        <td>
                            @if($sale->isActive())
                                <span class="badge bg-success">Đang diễn ra</span>
                            @else
                                <span class="badge bg-secondary">Không hoạt động</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                @if($sale->isActive())
                                    <a href="{{ route('admin.flash-sales.edit', $sale->id) }}"
                                       class="btn btn-sm btn-outline-warning btn-icon">
                                        <i class="bi bi-pencil-fill"></i>
                                    </a>
                                @endif
                                <form action="{{ route('admin.flash-sales.destroy', $sale->id) }}"
                                      method="POST"
                                      class="d-inline"
                                      onsubmit="return confirm('Bạn có chắc muốn xoá?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger btn-icon">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach

                    @if($flashSales->isEmpty())
                        <tr>
                            <td colspan="8" class="text-center text-muted">
                                <i class="bi bi-info-circle me-1"></i>Chưa có Flash Sale nào.
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    /* Giữ nguyên các style từ giao diện danh mục */
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

    .btn-add {
        border-radius: 8px;
        padding: 10px 20px;
        transition: all 0.3s ease;
    }

    .btn-add:hover {
        background-color: #0052a3;
        transform: scale(1.05);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
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

    .btn-outline-warning.btn-icon:hover {
        background-color: #ffc107;
        border-color: #ffc107;
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

    .badge {
        padding: 0.5rem 1rem;
        border-radius: 12px;
        font-weight: 500;
    }

    @media (max-width: 768px) {
        .table-responsive {
            font-size: 0.9rem;
        }

        .btn-icon {
            width: 32px;
            height: 32px;
        }

        .btn-add {
            width: 100%;
            text-align: center;
        }

        .d-flex.gap-2 {
            gap: 8px !important;
        }
    }
</style>
@endsection

@extends('layouts.admin')

@section('title', 'Danh sách mã giảm giá')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-dark"><i class="bi bi-tags me-2"></i>Danh sách mã giảm giá</h2>
        <a href="{{ route('admin.coupons.create') }}" class="btn btn-primary btn-add">
            <i class="bi bi-plus-circle me-1"></i> Thêm mã mới
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
                        <th>#</th>
                        <th>Mã</th>
                        <th>Loại</th>
                        <th>Giá trị</th>
                        <th>Phạm vi</th>
                        <th>Giới hạn / Đã dùng</th>
                        <th>Kích hoạt</th>
                        <th>Hết hạn</th>
                        <th class="text-center">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($coupons as $coupon)
                    <tr class="table-row">
                        <td>{{ $loop->iteration + ($coupons->currentPage() - 1) * $coupons->perPage() }}</td>
                        <td class="fw-medium">{{ $coupon->code }}</td>
                        <td>{{ $coupon->type === 'percent' ? 'Phần trăm' : 'Số tiền' }}</td>
                        <td>
                            {{ $coupon->type === 'percent' ? $coupon->value . '%' : number_format($coupon->value, 0, ',', '.') . '₫' }}
                        </td>
                        <td>
                            @switch($coupon->scope)
                                @case('all')
                                    <span class="text-primary fw-medium">Toàn bộ</span>
                                    @break
                                @case('category')
                                    <span class="text-info fw-medium">Danh mục: {{ $coupon->category->name ?? '-' }}</span>
                                    @break
                                @case('product')
                                    <span class="text-success fw-medium">Sản phẩm: {{ $coupon->product->name ?? '-' }}</span>
                                    @break
                            @endswitch
                        </td>
                        <td>{{ $coupon->usage_limit ?? '-' }} / {{ $coupon->used ?? 0 }}</td>
                        <td>
                            @if ($coupon->is_active)
                                <span class="badge bg-success">Đang hoạt động</span>
                            @else
                                <span class="badge bg-secondary">Tắt</span>
                            @endif
                        </td>
                        <td>
                            {{ $coupon->expires_at ? \Carbon\Carbon::parse($coupon->expires_at)->format('d/m/Y') : '-' }}
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <a href="{{ route('admin.coupons.edit', $coupon->id) }}"
                                   class="btn btn-sm btn-outline-warning btn-icon">
                                    <i class="bi bi-pencil-fill"></i>
                                </a>
                                <form action="{{ route('admin.coupons.destroy', $coupon->id) }}"
                                      method="POST"
                                      class="d-inline"
                                      onsubmit="return confirm('Bạn chắc chắn muốn xoá?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger btn-icon">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center text-muted">
                            <i class="bi bi-info-circle me-1"></i>Chưa có mã giảm giá nào.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-3">
                {{ $coupons->links() }}
            </div>
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

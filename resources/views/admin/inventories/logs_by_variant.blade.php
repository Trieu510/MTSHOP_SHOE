@extends('layouts.admin')

@section('title', 'Lịch sử nhập kho - ' . $variant->product->name . ' - Size ' . $variant->size)

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-dark">
            Lịch sử nhập kho:
            <span class="text-primary">{{ $variant->product->name }}</span>
            (Size <span class="text-info">{{ $variant->size }}</span>)
        </h2>
        <a href="{{ route('admin.inventory.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left-circle me-1"></i> Quay lại
        </a>
    </div>

    @include('admin.partials.alerts')

    <div class="card shadow-lg border-0 rounded-4 bg-gradient-light">
        <div class="table-responsive p-3">
            <table class="table mb-0 align-middle">
                <thead class="table-light">
                    <tr>
                        <th class="text-center">#</th>
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
                            <td class="text-center">
                                <span class="badge bg-primary rounded-pill px-3 py-1">
                                    {{ $log->quantity }}
                                </span>
                            </td>
                            <td>{{ $log->note ?? '-' }}</td>
                            <td>{{ $log->admin->name ?? 'Admin' }}</td>
                            <td class="text-center">
                                <span class="text-muted">
                                    {{ $log->created_at->format('d/m/Y') }}
                                </span>
                                <br>
                                <small class="text-muted">
                                    {{ $log->created_at->format('H:i:s') }}
                                </small>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                <i class="bi bi-info-circle me-2"></i>
                                Không có log nhập kho nào.
                            </td>
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

    .badge.bg-primary {
        font-weight: 500;
        min-width: 40px;
    }

    .btn-outline-secondary {
        transition: all 0.3s ease;
    }

    .btn-outline-secondary:hover {
        background-color: #6c757d;
        color: white;
    }

    @media (max-width: 768px) {
        .table-responsive {
            font-size: 0.9rem;
        }

        .d-flex.justify-content-between {
            flex-direction: column;
            gap: 15px;
        }

        h2 {
            font-size: 1.5rem;
        }

        .btn-outline-secondary {
            width: 100%;
        }
    }
</style>
@endsection

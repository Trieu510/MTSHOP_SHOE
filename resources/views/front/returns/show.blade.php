@extends('layouts.front')

@section('title', 'Chi tiết hoàn hàng')

@section('content')
<div class="container py-4">
    <div class="d-flex align-items-center mb-4">
        <div class="icon-circle bg-primary text-white me-3">
            <i class="fas fa-undo"></i>
        </div>
        <h2 class="mb-0">Chi tiết yêu cầu hoàn hàng</h2>
    </div>

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <h5 class="mb-3">Thông tin yêu cầu</h5>

            <div class="mb-3">
                <strong>Mã đơn hàng:</strong>
                #{{ $return->order->id }}
            </div>

            <div class="mb-3">
                <strong>Lý do hoàn hàng:</strong>
                <div class="mt-1 text-muted">{{ $return->reason }}</div>
            </div>

            <div class="mb-3">
                <strong>Trạng thái xử lý:</strong>
                @php
                    $statusColor = [
                        'pending'   => 'warning',
                        'approved'  => 'success',
                        'rejected'  => 'danger',
                        'processing'=> 'primary',
                    ][$return->status] ?? 'secondary';
                @endphp
                <span class="badge bg-{{ $statusColor }}">
                    {{ ucfirst($return->status) }}
                </span>
            </div>

            <div class="mb-3">
                <strong>Thời gian gửi:</strong>
                {{ $return->created_at->format('H:i d/m/Y') }}
            </div>

            @if($return->images->count())
                <div class="mb-3">
                    <strong>Hình ảnh đính kèm:</strong>
                    <div class="row mt-2">
                        @foreach($return->images as $image)
                            <div class="col-md-3 col-6 mb-3">
                                <a href="{{ asset('storage/' . $image->path) }}" target="_blank">
                                    <img src="{{ asset('storage/' . $image->path) }}" class="img-fluid rounded shadow-sm border" alt="Ảnh hoàn hàng">
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i>Quay lại đơn hàng
            </a>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .icon-circle {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .card {
        border-radius: 10px;
    }

    .badge {
        font-size: 0.9rem;
        padding: 0.4em 0.7em;
    }
</style>
@endpush

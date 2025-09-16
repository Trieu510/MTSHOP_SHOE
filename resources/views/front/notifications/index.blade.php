@extends('layouts.front')

@section('content')
<div class="container py-4">
    <div class="d-flex align-items-center mb-4">
        <div class="icon-circle bg-primary text-white me-3">
            <i class="fas fa-bell"></i>
        </div>
        <h2 class="mb-0">Thông báo của bạn</h2>
    </div>

    @foreach($notifications as $notification)
        @php
            $type = $notification->data['type'] ?? 'order';
            $icon = $type === 'return' ? '🔁' : '🛒';
        @endphp

        <div class="card mb-3 shadow-sm border-0 {{ is_null($notification->read_at) ? 'unread-notification' : 'read-notification' }}">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div class="flex-grow-1 me-3">
                    <div class="notification-content">
                        <span class="me-2" style="font-size: 1.2rem;">{{ $icon }}</span>
                        {{ $notification->data['message'] ?? 'Thông báo' }}
                    </div>

                    {{-- Xử lý thông báo đơn hàng --}}
                    @if(($notification->data['type'] ?? '') === 'order' && isset($notification->data['order_id']))
                        <div class="d-flex flex-wrap gap-2 mt-2" id="confirm-section-{{ $notification->id }}">
        <button type="button"
    class="btn btn-sm btn-success"
    onclick="confirmReceived({{ $notification->id }}, {{ $notification->data['order_id'] ?? 0 }})">
    <i class="fas fa-check-circle me-1"></i>Đã nhận hàng
</button>

    </div>
                    @elseif(($notification->data['type'] ?? '') === 'return')
                        <a href="{{ route('returns.show', ['return' => $notification->data['return_request_id']]) }}" class="btn btn-sm btn-outline-primary mt-2">
                            <i class="fas fa-eye me-1"></i>Xem chi tiết
                        </a>
                    @endif

                    <small class="text-muted d-block mt-2">
                        <i class="far fa-clock me-1"></i>{{ $notification->created_at->diffForHumans() }}
                    </small>
                </div>

                @if(is_null($notification->read_at))
                    <form action="{{ route('notifications.read', $notification->id) }}" method="POST">
                        @csrf
                        <button class="btn btn-sm btn-primary rounded-pill px-3">
                            <i class="fas fa-check me-1"></i>Đánh dấu đã đọc
                        </button>
                    </form>
                @else
                    <span class="badge bg-secondary rounded-pill px-3">
                        <i class="fas fa-check me-1"></i>Đã đọc
                    </span>
                @endif
            </div>
        </div>
    @endforeach

    <div class="mt-4">
        {{ $notifications->links() }}
    </div>

    @if($notifications->count() === 0)
        <div class="text-center py-5">
            <i class="far fa-bell fa-3x text-muted mb-3"></i>
            <p class="text-muted">Bạn chưa có thông báo nào</p>
            <a href="{{ route('home') }}" class="btn btn-outline-primary">
                <i class="fas fa-home me-1"></i>Về trang chủ
            </a>
        </div>
    @endif
</div>
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    window.confirmReceived = function(notificationId, orderId) {
        fetch(`/orders/${orderId}/confirm`, {
            method: 'PUT',
            headers: {
                'X-CSRF-TOKEN': token,
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({})
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                const section = document.getElementById('confirm-section-' + notificationId);
                section.innerHTML =
                    '<div class="alert alert-success py-2 px-3 mb-2">' +
                        'MTSHOP cảm ơn bạn đã mua hàng <i class="fas fa-heart text-danger"></i>' +
                    '</div>' +
                    '<a href="/orders/' + orderId + '#review" class="btn btn-sm btn-warning text-white">' +
                        '<i class="fas fa-star me-1"></i>Đánh giá sản phẩm' +
                    '</a>';
            } else {
                alert(data.message || 'Không thể xác nhận.');
            }
        })
        .catch(err => {
            alert('Đã xảy ra lỗi khi gửi xác nhận!');
            console.error(err);
        });
    };
});
</script>
@endpush




<style>
.icon-circle {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.unread-notification {
    border-left: 4px solid #0d6efd;
    background-color: #f8f9fa;
}

.read-notification {
    opacity: 0.85;
}

.notification-content {
    margin-bottom: 0.5rem;
    line-height: 1.5;
}

.card {
    transition: all 0.2s ease;
    border-radius: 8px;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}

.pagination {
    justify-content: center;
}
</style>
@endsection

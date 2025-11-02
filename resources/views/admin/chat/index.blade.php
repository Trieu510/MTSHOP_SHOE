@extends('layouts.admin')

@section('title', 'Hộp thoại khách hàng')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Poppins:wght@600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/animate.css@4.1.1/animation.min.css">

<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --success-gradient: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        --warning-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        --gold: #ffd700;
        --dark: #2d3748;
        --light: #f7fafc;
        --shadow: 0 20px 25px -5px rgba(0, 0,0, 0.1), 0 10px 10px -5px rgba(0, 0,0, 0.04);
    }

    .page-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 2rem 0;
        margin: -1.5rem -1.5rem 2rem -1.5rem;
        border-radius: 1rem;
        position: relative;
        overflow: hidden;
    }

    .page-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.1'%3E%3Ccircle cx='30' cy='30' r='1'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        animation: float 20s ease-in-out infinite;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-20px); }
    }

    .page-title {
        font-family: 'Poppins', sans-serif;
        font-size: 2rem;
        font-weight: 700;
        margin: 0;
        position: relative;
        z-index: 2;
    }

    .page-subtitle {
        font-size: 1.1rem;
        opacity: 0.9;
        margin-top: 0.5rem;
        position: relative;
        z-index: 2;
    }

    .stats-badge {
        background: rgba(255,255,255,0.2);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255,255,255,0.3);
        padding: 0.5rem 1rem;
        border-radius: 50px;
        font-weight: 600;
        font-size: 1rem;
        position: relative;
        z-index: 2;
    }

    .chat-card {
        border: none;
        border-radius: 1.5rem;
        overflow: hidden;
        box-shadow: var(--shadow);
        background: white;
        transition: all 0.3s ease;
    }

    .chat-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 35px 60px -12px rgba(0,0,0,0.15);
    }

    .table-custom {
        margin: 0;
        font-family: 'Inter', sans-serif;
    }

    .table-custom thead {
        background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%);
        border: none;
    }

    .table-custom thead th {
        border: none;
        font-weight: 600;
        color: #4a5568;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 1px;
        padding: 1.5rem 1rem;
        position: relative;
    }

    .table-custom thead th::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 40px;
        height: 2px;
        background: var(--primary-gradient);
        border-radius: 1px;
    }

    .table-custom tbody td {
        padding: 1.25rem 1rem;
        border-color: rgba(226, 232, 240, 0.5);
        vertical-align: middle;
        transition: all 0.2s ease;
    }

    .table-custom tbody tr:hover {
        background: linear-gradient(90deg, #f7fafc 0%, #edf2f7 100%);
        transform: scale(1.01);
    }

    .customer-avatar {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid white;
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        transition: transform 0.3s ease;
    }

    .customer-avatar:hover {
        transform: scale(1.1);
    }

    .customer-info h6 {
        font-family: 'Poppins', sans-serif;
        font-weight: 700;
        color: var(--dark);
        margin: 0 0 0.25rem 0;
        font-size: 1rem;
    }

    .customer-info small {
        color: #718096;
        font-weight: 500;
    }

    .message-preview {
        font-size: 0.9rem;
        color: #4a5568;
        max-width: 250px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        padding: 0.5rem 0.75rem;
        background: #f7fafc;
        border-radius: 15px;
        border-left: 4px solid var(--primary-gradient);
        margin: 0.25rem 0;
    }

    .time-badge {
        background: linear-gradient(135deg, #48bb78, #38a169);
        color: white;
        padding: 0.35rem 0.75rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        white-space: nowrap;
    }

    .chat-btn {
        background: var(--primary-gradient);
        border: none;
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 50px;
        font-weight: 700;
        font-size: 0.9rem;
        transition: all 0.3s ease;
        box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
        position: relative;
        overflow: hidden;
    }

    .chat-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 20px 40px rgba(102, 126, 234, 0.4);
        color: white;
    }

    .chat-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
        transition: left 0.5s;
    }

    .chat-btn:hover::before {
        left: 100%;
    }

    .empty-state {
        padding: 4rem 2rem;
        text-align: center;
        color: #a0aec0;
    }

    .empty-icon {
        font-size: 6rem;
        margin-bottom: 1.5rem;
        opacity: 0.5;
        animation: bounce 2s infinite;
    }

    @keyframes bounce {
        0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
        40% { transform: translateY(-10px); }
        60% { transform: translateY(-5px); }
    }

    .alert-custom {
        border: none;
        border-radius: 1rem;
        box-shadow: var(--shadow);
        animation: slideInDown 0.5s ease;
    }

    @keyframes slideInDown {
        from { transform: translateY(-20px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }

    /* Responsive */
    @media (max-width: 768px) {
        .page-title { font-size: 1.5rem; }
        .message-preview { max-width: 180px; }
        .table-custom thead th { padding: 1rem 0.5rem; font-size: 0.7rem; }
        .table-custom tbody td { padding: 1rem 0.5rem; }
    }

    .dot-unread {
    position: absolute;
    top: 0;
    right: 0;
    width: 12px;
    height: 12px;
    background: #ff4b2b;
    border-radius: 50%;
    border: 2px solid #fff;
    box-shadow: 0 0 8px rgba(255, 75, 43, 0.6);
}

</style>
@endpush

@section('content')
<div class="container-fluid py-4">
    <!-- Page Header -->
    <div class="page-header animate__animated animate__fadeIn">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="page-title mb-0">
                        <i class="fas fa-comments me-3" style="font-size: 2.5rem; opacity: 0.9;"></i>
                        Hộp thoại khách hàng
                    </h1>
                    <p class="page-subtitle mb-0">Quản lý & trả lời tin nhắn từ khách hàng</p>
                </div>
                <div class="col-md-4 text-md-end mt-3 mt-md-0">
                    <span class="stats-badge">
                        <i class="fas fa-users me-2"></i>
                        {{ $customers->count() }} khách hàng
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Success Alert -->
    @if(session('success'))
        <div class="alert alert-success alert-custom position-relative">
            <i class="fas fa-check-circle me-3"></i>
            {{ session('success') }}
            <button type="button" class="btn-close position-absolute top-50 end-0 translate-middle-y me-3" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Chat Table Card -->
    <div class="chat-card animate__animated animate__fadeInUp">
        <div class="table-responsive">
            <table class="table table-custom">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 8%;">
                            <i class="fas fa-hashtag"></i>
                        </th>
                        <th style="width: 28%;">
                            <i class="fas fa-user"></i> Khách hàng
                        </th>
                        <th style="width: 22%;">
                            <i class="fas fa-envelope"></i> Email
                        </th>
                        <th style="width: 25%;">
                            <i class="fas fa-comment"></i> Tin nhắn gần nhất
                        </th>
                        <th class="text-center" style="width: 10%;">
                            <i class="fas fa-clock"></i>
                        </th>
                        <th class="text-center" style="width: 12%;">
                            <i class="fas fa-play"></i>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($customers as $index => $customer)
@php
    $lastMessage = $customer->messages()->latest()->first();
    $hasUnread = $customer->messages()
        ->where('receiver_id', Auth::id())
        ->where('is_read', false)
        ->exists();
@endphp
                        <tr class="animate__animated animate__fadeIn" style="animation-delay: {{ $index * 0.1 }}s;">
                            <td class="text-center fw-bold text-primary">{{ $index + 1 }}</td>

                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="position-relative me-3">
    <img src="{{ $customer->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($customer->name) . '&background=667eea&color=fff&size=48&bold=true' }}"
         alt="{{ $customer->name }}" class="customer-avatar">

    @if($hasUnread)
        <span class="dot-unread"></span>
    @endif
</div>

                                    <div class="customer-info">
                                        <h6>{{ $customer->name }}</h6>
                                        <small>{{ Str::limit($customer->email, 25) }}</small>
                                    </div>
                                </div>
                            </td>

                            <td>
                                <a href="mailto:{{ $customer->email }}" class="text-decoration-none text-muted fw-medium">
                                    {{ Str::limit($customer->email, 25) }}
                                </a>
                            </td>

                            <td>
                                @if($lastMessage)
                                    <div class="message-preview">
                                        @if($lastMessage->type === 'text')
                                            {{ Str::limit($lastMessage->content, 40) }}
                                        @elseif($lastMessage->type === 'image')
                                            <i class="fas fa-image text-info me-1"></i> Ảnh
                                        @elseif($lastMessage->type === 'file')
                                            <i class="fas fa-paperclip text-success me-1"></i> File
                                        @endif
                                    </div>
                                @else
                                    <span class="text-muted fst-italic">Chưa có tin nhắn</span>
                                @endif
                            </td>

                            <td class="text-center">
                                @if($lastMessage)
                                    <span class="time-badge">
                                        {{ $lastMessage->created_at->diffForHumans() }}
                                    </span>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>

                            <td class="text-center">
                                <a href="{{ route('admin.chat.show', $customer->id) }}" class="btn chat-btn">
                                    <i class="fas fa-comments me-1"></i>
                                    Xem ngay
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="empty-state">
                                <div class="empty-icon">
                                    <i class="fas fa-comments"></i>
                                </div>
                                <h4>😌 Chưa có khách hàng nào nhắn tin</h4>
                                <p class="lead">Khách hàng sẽ xuất hiện ở đây khi họ bắt đầu trò chuyện!</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Smooth hover effects
    document.querySelectorAll('.chat-card tbody tr').forEach(row => {
        row.addEventListener('mouseenter', () => {
            row.style.transform = 'scale(1.02)';
        });
        row.addEventListener('mouseleave', () => {
            row.style.transform = 'scale(1)';
        });
    });

    // Auto refresh every 30s
    setTimeout(() => {
        window.location.reload();
    }, 30000);
</script>
@endpush

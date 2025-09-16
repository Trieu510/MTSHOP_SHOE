@extends('layouts.front')

@section('title', 'Chi tiết liên hệ')

@push('styles')
<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --glass-effect: rgba(255, 255, 255, 0.15);
        --text-dark: #1e293b;
        --text-light: #64748b;
        --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        --transition-all: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* ===== Back Button ===== */
    .back-btn {
        display: inline-flex;
        align-items: center;
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(203, 213, 225, 0.5);
        color: #6366f1;
        font-weight: 500;
        transition: var(--transition-all);
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        margin-bottom: 2rem;
    }
    .back-btn:hover {
        background: rgba(255, 255, 255, 0.9);
        color: #4f46e5;
        transform: translateY(-2px);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
    }
    .back-btn i {
        margin-right: 0.5rem;
    }

    /* ===== Contact Card ===== */
    .contact-card {
        border-radius: 16px;
        overflow: hidden;
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(15px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        box-shadow: var(--shadow-xl);
        transition: var(--transition-all);
    }
    .contact-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
    }
    .contact-header {
        background: var(--primary-gradient);
        padding: 1.5rem;
        color: white;
    }
    .contact-header h5 {
        font-weight: 600;
        margin: 0;
        display: flex;
        align-items: center;
    }
    .contact-header h5 i {
        margin-right: 0.75rem;
        font-size: 1.25rem;
    }
    .contact-body {
        padding: 2rem;
    }

    /* ===== Detail List ===== */
    .detail-list {
        margin-bottom: 2.5rem;
    }
    .detail-row {
        display: flex;
        padding: 1rem 0;
        border-bottom: 1px solid rgba(203, 213, 225, 0.3);
    }
    .detail-row:last-child {
        border-bottom: none;
    }
    .detail-label {
        flex: 0 0 200px;
        font-weight: 600;
        color: var(--text-dark);
    }
    .detail-value {
        flex: 1;
        color: var(--text-light);
    }
    .message-content {
        white-space: pre-line;
        line-height: 1.7;
        padding: 1rem;
        background: rgba(241, 245, 249, 0.5);
        border-radius: 8px;
    }

    /* ===== Reply Section ===== */
    .reply-section {
        margin-top: 2.5rem;
    }
    .reply-header {
        display: flex;
        align-items: center;
        margin-bottom: 1rem;
    }
    .reply-title {
        font-weight: 600;
        color: var(--text-dark);
        margin: 0;
    }
    .reply-time {
        font-size: 0.85rem;
        color: var(--text-light);
        margin-left: 1rem;
    }
    .reply-content {
        background: rgba(236, 253, 245, 0.5);
        border-left: 4px solid #10b981;
        padding: 1.5rem;
        border-radius: 0 8px 8px 0;
        white-space: pre-line;
        line-height: 1.7;
    }
    .no-reply {
        text-align: center;
        padding: 2rem;
        color: var(--text-light);
        font-style: italic;
        background: rgba(241, 245, 249, 0.5);
        border-radius: 8px;
    }
    .no-reply i {
        font-size: 2rem;
        margin-bottom: 1rem;
        color: #cbd5e1;
    }

    /* ===== Background Elements ===== */
    .contact-bg-elements {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        overflow: hidden;
        z-index: -1;
    }
    .contact-bg-elements .circle {
        position: absolute;
        border-radius: 50%;
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
    }
    .contact-bg-elements .circle-1 {
        width: 250px;
        height: 250px;
        top: -50px;
        right: -50px;
    }
    .contact-bg-elements .circle-2 {
        width: 150px;
        height: 150px;
        bottom: -30px;
        left: -30px;
    }

    /* ===== Responsive Adjustments ===== */
    @media (max-width: 768px) {
        .detail-row {
            flex-direction: column;
        }
        .detail-label {
            flex: 1;
            margin-bottom: 0.5rem;
        }
        .contact-body {
            padding: 1.5rem;
        }
        .reply-header {
            flex-direction: column;
            align-items: flex-start;
        }
        .reply-time {
            margin-left: 0;
            margin-top: 0.25rem;
        }
    }
    @media (max-width: 576px) {
        .back-btn {
            padding: 0.6rem 1rem;
            font-size: 0.9rem;
        }
        .contact-header {
            padding: 1.25rem;
        }
        .contact-header h5 {
            font-size: 1.1rem;
        }
    }
</style>
@endpush

@section('content')
<div class="container py-5 position-relative">
    <!-- Background elements -->
    <div class="contact-bg-elements">
        <div class="circle circle-1"></div>
        <div class="circle circle-2"></div>
    </div>

    <a href="{{ route('contacts.index') }}" class="back-btn" data-aos="fade-up">
        <i class="fas fa-arrow-left"></i>
        Quay lại lịch sử liên hệ
    </a>

    <div class="contact-card" data-aos="fade-up" data-aos-delay="100">
        <div class="contact-header">
            <h5>
                <i class="fas fa-info-circle"></i>
                Chi tiết liên hệ #{{ $contact->id }}
            </h5>
        </div>
        <div class="contact-body">
            <div class="detail-list">
                <div class="detail-row">
                    <div class="detail-label">Họ tên</div>
                    <div class="detail-value">{{ $contact->name }}</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Email</div>
                    <div class="detail-value">{{ $contact->email }}</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Số điện thoại</div>
                    <div class="detail-value">{{ $contact->phone ?: '-' }}</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Gửi lúc</div>
                    <div class="detail-value">{{ $contact->created_at->format('d/m/Y H:i') }}</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Nội dung</div>
                    <div class="detail-value">
                        <div class="message-content">{{ $contact->message }}</div>
                    </div>
                </div>
            </div>

            @if($contact->reply)
                <div class="reply-section" data-aos="fade-up" data-aos-delay="200">
                    <div class="reply-header">
                        <h6 class="reply-title">Phản hồi từ ShoeSport</h6>
                        <span class="reply-time">Phản hồi lúc {{ $contact->replied_at->format('d/m/Y H:i') }}</span>
                    </div>
                    <div class="reply-content">
                        {{ $contact->reply }}
                    </div>
                </div>
            @else
                <div class="no-reply" data-aos="fade-up" data-aos-delay="200">
                    <i class="far fa-comment-dots"></i>
                    <p>Chưa có phản hồi từ ShoeSport</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

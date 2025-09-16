@extends('layouts.front')

@section('title', 'Lịch sử liên hệ')

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

    /* ===== Page Title ===== */
    .page-title {
        font-size: 2.25rem;
        font-weight: 700;
        background: var(--primary-gradient);
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
        margin-bottom: 2.5rem;
        position: relative;
        display: inline-block;
    }
    .page-title::after {
        content: '';
        position: absolute;
        bottom: -8px;
        left: 0;
        width: 50px;
        height: 3px;
        background: var(--primary-gradient);
        border-radius: 2px;
    }

    /* ===== Empty State ===== */
    .empty-state {
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(10px);
        border-radius: 16px;
        padding: 3rem;
        text-align: center;
        box-shadow: var(--shadow-xl);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
    .empty-state i {
        font-size: 3rem;
        color: #cbd5e1;
        margin-bottom: 1.5rem;
    }
    .empty-state p {
        font-size: 1.1rem;
        color: var(--text-light);
    }

    /* ===== Contact List ===== */
    .contact-list {
        border-radius: 16px;
        overflow: hidden;
        box-shadow: var(--shadow-xl);
    }
    .contact-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1.5rem;
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(10px);
        border-bottom: 1px solid rgba(203, 213, 225, 0.3);
        transition: var(--transition-all);
    }
    .contact-item:hover {
        background: rgba(255, 255, 255, 0.9);
        transform: translateY(-2px);
    }
    .contact-item:last-child {
        border-bottom: none;
    }
    .contact-content {
        flex: 1;
    }
    .contact-message {
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 0.5rem;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .contact-date {
        font-size: 0.85rem;
        color: var(--text-light);
        display: flex;
        align-items: center;
    }
    .contact-date i {
        margin-right: 0.5rem;
        font-size: 0.9rem;
    }
    .contact-badge {
        padding: 0.5rem 1rem;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.8rem;
        letter-spacing: 0.5px;
        text-transform: uppercase;
    }
    .badge-replied {
        background: rgba(16, 185, 129, 0.1);
        color: #065f46;
    }
    .badge-pending {
        background: rgba(226, 232, 240, 0.7);
        color: #475569;
    }

    /* ===== Pagination ===== */
    .pagination {
        margin-top: 2.5rem;
    }
    .page-item.active .page-link {
        background: var(--primary-gradient);
        border-color: transparent;
    }
    .page-link {
        color: #6366f1;
        border: 1px solid rgba(203, 213, 225, 0.5);
        padding: 0.5rem 1rem;
        margin: 0 0.25rem;
        border-radius: 8px !important;
        transition: var(--transition-all);
    }
    .page-link:hover {
        background: rgba(99, 102, 241, 0.1);
        color: #4f46e5;
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
        .page-title {
            font-size: 2rem;
        }
        .contact-item {
            padding: 1.25rem;
            flex-direction: column;
            align-items: flex-start;
        }
        .contact-badge {
            margin-top: 0.75rem;
            align-self: flex-end;
        }
    }
    @media (max-width: 576px) {
        .page-title {
            font-size: 1.75rem;
        }
        .empty-state {
            padding: 2rem 1.5rem;
        }
        .contact-item {
            padding: 1rem;
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

    <h2 class="page-title">Lịch sử liên hệ</h2>

    @if($contacts->isEmpty())
        <div class="empty-state" data-aos="fade-up">
            <i class="far fa-envelope-open"></i>
            <p>Bạn chưa gửi liên hệ nào</p>
        </div>
    @else
        <div class="contact-list" data-aos="fade-up">
            @foreach($contacts as $contact)
                <a href="{{ route('contacts.show', $contact) }}" class="contact-item">
                    <div class="contact-content">
                        <div class="contact-message">{{ Str::limit($contact->message, 80) }}</div>
                        <div class="contact-date">
                            <i class="far fa-clock"></i>
                            {{ $contact->created_at->format('d/m/Y H:i') }}
                        </div>
                    </div>
                    @if($contact->reply)
                        <span class="contact-badge badge-replied">Đã phản hồi</span>
                    @else
                        <span class="contact-badge badge-pending">Chưa phản hồi</span>
                    @endif
                </a>
            @endforeach 
        </div>

        <div class="pagination-wrapper" data-aos="fade-up" data-aos-delay="100">
            {{ $contacts->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>
@endsection

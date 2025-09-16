@extends('layouts.front')

@section('title', 'Liên hệ')

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
        font-size: 2.75rem;
        font-weight: 800;
        background: var(--primary-gradient);
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
        margin-bottom: 3rem;
        position: relative;
        display: inline-block;
    }
    .page-title::after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 0;
        width: 60px;
        height: 4px;
        background: var(--primary-gradient);
        border-radius: 2px;
    }

    /* ===== Flash Messages ===== */
    .alert-success {
        border-radius: 12px;
        padding: 1.25rem 1.75rem;
        box-shadow: var(--shadow-xl);
        font-weight: 500;
        background: rgba(16, 185, 129, 0.1);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(16, 185, 129, 0.2);
        color: #065f46;
        transition: var(--transition-all);
        position: relative;
        overflow: hidden;
    }
    .alert-success::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 5px;
        height: 100%;
        background: #10b981;
    }

    /* ===== Contact Form ===== */
    .contact-form-section {
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(15px);
        border-radius: 20px;
        padding: 2.5rem;
        box-shadow: var(--shadow-xl);
        transition: var(--transition-all);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
    .contact-form-section:hover {
        transform: translateY(-8px);
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
    }
    .contact-form-section .form-label {
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 0.75rem;
        font-size: 0.95rem;
        letter-spacing: 0.5px;
    }
    .contact-form-section .form-control {
        border-radius: 12px;
        border: 1px solid rgba(203, 213, 225, 0.5);
        padding: 0.85rem 1.25rem;
        font-size: 0.95rem;
        transition: var(--transition-all);
        background: rgba(255, 255, 255, 0.8);
    }
    .contact-form-section .form-control:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.15);
        background: white;
    }
    .contact-form-section .text-danger {
        font-size: 0.85rem;
        margin-top: 0.5rem;
        font-weight: 500;
    }
    .contact-form-section .btn-primary {
        border-radius: 12px;
        padding: 0.85rem 2rem;
        font-size: 1rem;
        font-weight: 600;
        letter-spacing: 0.5px;
        transition: var(--transition-all);
        background: var(--primary-gradient);
        border: none;
        position: relative;
        overflow: hidden;
        z-index: 1;
    }
    .contact-form-section .btn-primary::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 0;
        height: 100%;
        background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
        transition: var(--transition-all);
        z-index: -1;
    }
    .contact-form-section .btn-primary:hover::before {
        width: 100%;
    }
    .contact-form-section .btn-primary:hover {
        transform: translateY(-3px) scale(1.02);
        box-shadow: 0 10px 20px rgba(99, 102, 241, 0.3);
    }

    /* ===== Contact Info ===== */
    .contact-info-section {
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(15px);
        border-radius: 20px;
        padding: 2.5rem;
        box-shadow: var(--shadow-xl);
        transition: var(--transition-all);
        border: 1px solid rgba(255, 255, 255, 0.2);
        height: 100%;
    }
    .contact-info-section:hover {
        transform: translateY(-8px);
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
    }
    .contact-info-section h5 {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 1.5rem;
        position: relative;
        display: inline-block;
    }
    .contact-info-section h5::after {
        content: '';
        position: absolute;
        bottom: -8px;
        left: 0;
        width: 40px;
        height: 3px;
        background: var(--primary-gradient);
        border-radius: 2px;
    }
    .contact-info-section p {
        font-size: 1.05rem;
        color: var(--text-light);
        margin-bottom: 1.25rem;
        line-height: 1.7;
        position: relative;
        padding-left: 2rem;
    }
    .contact-info-section p::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0.5rem;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: var(--primary-gradient);
    }
    .contact-info-section p a {
        color: #6366f1;
        text-decoration: none;
        transition: var(--transition-all);
        font-weight: 500;
    }
    .contact-info-section p a:hover {
        color: #4f46e5;
        text-decoration: underline;
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
        width: 300px;
        height: 300px;
        top: -100px;
        right: -100px;
    }
    .contact-bg-elements .circle-2 {
        width: 200px;
        height: 200px;
        bottom: -50px;
        left: -50px;
    }

    /* ===== Responsive Adjustments ===== */
    @media (max-width: 992px) {
        .page-title {
            font-size: 2.5rem;
        }
        .contact-form-section, .contact-info-section {
            padding: 2rem;
        }
    }
    @media (max-width: 768px) {
        .page-title {
            font-size: 2.25rem;
            margin-bottom: 2rem;
        }
        .contact-form-section, .contact-info-section {
            padding: 1.75rem;
        }
        .contact-info-section {
            margin-top: 2rem;
        }
    }
    @media (max-width: 576px) {
        .page-title {
            font-size: 2rem;
        }
        .contact-form-section, .contact-info-section {
            padding: 1.5rem;
            border-radius: 16px;
        }
        .contact-form-section .form-control {
            padding: 0.75rem 1rem;
        }
        .contact-form-section .btn-primary {
            padding: 0.75rem 1.5rem;
            width: 100%;
        }
    }
</style>
@endpush

@section('content')
<div class="container py-5 position-relative" data-aos="fade-up">
    <!-- Background elements -->
    <div class="contact-bg-elements">
        <div class="circle circle-1"></div>
        <div class="circle circle-2"></div>
    </div>

    <h2 class="page-title">Liên hệ với chúng tôi</h2>

    @if(session('success'))
        <div class="alert alert-success mb-4" data-aos="fade-up" data-aos-delay="100">
            {{ session('success') }}
        </div>
    @endif

    <div class="row">
        <div class="col-lg-8">
            <div class="contact-form-section" data-aos="fade-up" data-aos-delay="200">
                <form action="{{ route('contact.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label class="form-label">Tên của bạn *</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                        @error('name') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Email *</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                        @error('email') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Số điện thoại</label>
                        <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
                        @error('phone') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Nội dung *</label>
                        <textarea name="message" rows="6" class="form-control" required>{{ old('message') }}</textarea>
                        @error('message') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>

                    <button type="submit" class="btn btn-primary mt-2">
                        <i class="fas fa-paper-plane me-2"></i> Gửi liên hệ
                    </button>
                    <a href="{{ route('contacts.index') }}" class="btn btn-outline-secondary ms-3">
        <i class="fas fa-history me-1"></i> Lịch sử liên hệ
    </a>
                </form>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="contact-info-section" data-aos="fade-up" data-aos-delay="300">
                <h5>Thông tin liên hệ</h5>
                <p>Email: <a href="mailto:ShoeSport@gmail.vn">ShoeSport@gmail.vn</a></p>
                <p>Điện thoại: <a href="tel:0996386683">0996-386-683</a></p>

                <h5 class="mt-4">Địa chỉ</h5>
                <p>số 256, đường Nguyễn Văn Cừ, phường An Hòa, quận Ninh Kiều, TP Cần Thơ</p>

                <h5 class="mt-4">Giờ làm việc</h5>
                <p>Thứ 2 - Thứ 6: 8:00 - 17:00</p>
                <p>Thứ 7: 8:00 - 12:00</p>
            </div>
        </div>
    </div>
</div>
@endsection

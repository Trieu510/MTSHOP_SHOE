@extends('layouts.front')

@section('title', 'Hồ sơ của bạn')

@push('styles')
<style>
    :root {
        --primary-color: #6366f1;
        --primary-dark: #4f46e5;
        --danger-color: #ef4444;
        --warning-color: #f59e0b;
        --success-color: #10b981;
        --text-dark: #1e293b;
        --text-medium: #475569;
        --text-light: #64748b;
        --bg-light: #f8fafc;
        --border-color: #e2e8f0;
        --glass-opacity: 0.2;
        --glass-blur: 12px;
        --transition-all: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        --shadow-primary: 0 0 0 4px rgba(99, 102, 241, 0.15);
    }

    /* ===== Base Styles ===== */
    .profile-container {
        max-width: 1200px;
        margin: 2rem auto;
        padding: 0 1rem;
        position: relative;
    }

    /* ===== Background Elements ===== */
    .profile-bg-elements {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        overflow: hidden;
        z-index: -1;
        pointer-events: none;
    }
    .profile-bg-elements .shape {
        position: absolute;
        border-radius: 50%;
        background: linear-gradient(135deg, rgba(99, 102, 241, 0.1) 0%, rgba(79, 70, 229, 0.1) 100%);
        filter: blur(20px);
        opacity: 0.6;
    }
    .profile-bg-elements .shape-1 {
        width: 300px;
        height: 300px;
        top: -50px;
        right: -50px;
    }
    .profile-bg-elements .shape-2 {
        width: 200px;
        height: 200px;
        bottom: -30px;
        left: -30px;
    }
    .profile-bg-elements .shape-3 {
        width: 150px;
        height: 150px;
        top: 30%;
        left: 20%;
    }

    /* ===== Success Message ===== */
    .alert-success {
        background: rgba(16, 185, 129, 0.1);
        backdrop-filter: blur(var(--glass-blur));
        -webkit-backdrop-filter: blur(var(--glass-blur));
        border-radius: 12px;
        padding: 1rem 1.5rem;
        box-shadow: var(--shadow-md);
        color: var(--success-color);
        border-left: 4px solid var(--success-color);
        margin-bottom: 2rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        transition: var(--transition-all);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
    .alert-success:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
    }

    /* ===== Grid Layout ===== */
    .profile-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 1.5rem;
    }
    @media (min-width: 1024px) {
        .profile-grid {
            grid-template-columns: 280px 1fr;
        }
    }

    /* ===== Sidebar ===== */
    .profile-sidebar {
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(var(--glass-blur));
        -webkit-backdrop-filter: blur(var(--glass-blur));
        border-radius: 16px;
        padding: 2rem 1.5rem;
        box-shadow: var(--shadow-xl);
        border: 1px solid rgba(255, 255, 255, 0.3);
        transition: var(--transition-all);
    }
    .profile-sidebar:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-xl);
        border-color: rgba(255, 255, 255, 0.5);
    }

    /* Avatar */
    .profile-avatar-container {
        position: relative;
        width: fit-content;
        margin: 0 auto 1.5rem;
    }
    .profile-avatar {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid rgba(255, 255, 255, 0.7);
        box-shadow: var(--shadow-md);
        transition: var(--transition-all);
    }
    .profile-avatar-container:hover .profile-avatar {
        transform: scale(1.05);
        box-shadow: var(--shadow-lg);
    }
    .profile-avatar-edit {
        position: absolute;
        bottom: 10px;
        right: 10px;
        background: var(--primary-color);
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        box-shadow: var(--shadow-md);
        cursor: pointer;
        transition: var(--transition-all);
    }
    .profile-avatar-edit:hover {
        background: var(--primary-dark);
        transform: scale(1.1);
    }

    /* User Info */
    .profile-name {
        font-size: 1.4rem;
        font-weight: 600;
        color: var(--text-dark);
        text-align: center;
        margin-bottom: 0.25rem;
        line-height: 1.3;
    }
    .profile-email {
        color: var(--text-light);
        text-align: center;
        font-size: 0.95rem;
        margin-bottom: 1.5rem;
    }

    /* Navigation */
    .profile-nav {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }
    .profile-nav-link {
        padding: 0.85rem 1.25rem;
        border-radius: 12px;
        color: var(--text-medium);
        font-weight: 500;
        transition: var(--transition-all);
        display: flex;
        align-items: center;
        gap: 0.75rem;
        text-decoration: none;
    }
    .profile-nav-link i {
        width: 24px;
        text-align: center;
        font-size: 1.1rem;
        transition: var(--transition-all);
    }
    .profile-nav-link:hover {
        background: rgba(99, 102, 241, 0.05);
        color: var(--primary-color);
    }
    .profile-nav-link:hover i {
        transform: translateX(3px);
    }
    .profile-nav-link.active {
        background: rgba(99, 102, 241, 0.1);
        color: var(--primary-color);
        font-weight: 600;
    }
    .profile-nav-link.delete {
        color: var(--danger-color);
    }
    .profile-nav-link.delete:hover,
    .profile-nav-link.delete.active {
        background: rgba(239, 68, 68, 0.1);
        color: var(--danger-color);
    }

    /* ===== Content Sections ===== */
    .profile-content {
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(var(--glass-blur));
        -webkit-backdrop-filter: blur(var(--glass-blur));
        border-radius: 16px;
        padding: 2rem;
        box-shadow: var(--shadow-xl);
        border: 1px solid rgba(255, 255, 255, 0.3);
        transition: var(--transition-all);
        min-height: 100%;
    }
    .profile-content:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-xl);
        border-color: rgba(255, 255, 255, 0.5);
    }

    /* Section Title */
    .section-title {
        font-size: 1.5rem;
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 1.5rem;
        position: relative;
        padding-bottom: 0.75rem;
    }
    .section-title::after {
        content: '';
        position: absolute;
        left: 0;
        bottom: 0;
        width: 50px;
        height: 4px;
        border-radius: 2px;
        background: linear-gradient(90deg, var(--primary-color), var(--primary-dark));
    }
    .section-title.delete::after {
        background: var(--danger-color);
    }

    /* ===== Form Elements ===== */
    .form-group {
        margin-bottom: 1.5rem;
    }
    .form-label {
        display: block;
        font-weight: 500;
        color: var(--text-dark);
        margin-bottom: 0.5rem;
    }
    .form-control {
        width: 100%;
        padding: 0.85rem 1.25rem;
        border-radius: 12px;
        border: 1px solid var(--border-color);
        transition: var(--transition-all);
        background: rgba(255, 255, 255, 0.8);
        font-size: 1rem;
    }
    .form-control:focus {
        border-color: var(--primary-color);
        box-shadow: var(--shadow-primary);
        background: white;
        outline: none;
    }
    .error-message {
        color: var(--danger-color);
        font-size: 0.85rem;
        margin-top: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }
    .error-message i {
        font-size: 0.9rem;
    }

    /* ===== Buttons ===== */
    .btn {
        border-radius: 12px;
        padding: 0.85rem 1.75rem;
        font-weight: 600;
        transition: var(--transition-all);
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        font-size: 1rem;
        position: relative;
        overflow: hidden;
    }
    .btn i {
        transition: var(--transition-all);
    }
    .btn:hover i {
        transform: translateX(3px);
    }
    .btn-primary {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
        color: white;
        box-shadow: var(--shadow-md);
    }
    .btn-primary:hover {
        transform: translateY(-3px);
        box-shadow: var(--shadow-lg);
    }
    .btn-primary:active {
        transform: translateY(0);
    }
    .btn-warning {
        background: linear-gradient(135deg, var(--warning-color) 0%, #f97316 100%);
        color: white;
        box-shadow: var(--shadow-md);
    }
    .btn-warning:hover {
        transform: translateY(-3px);
        box-shadow: var(--shadow-lg);
    }
    .btn-danger {
        background: linear-gradient(135deg, var(--danger-color) 0%, #dc2626 100%);
        color: white;
        box-shadow: var(--shadow-md);
    }
    .btn-danger:hover {
        transform: translateY(-3px);
        box-shadow: var(--shadow-lg);
    }

    /* ===== Tab Content ===== */
    .tab-content {
        display: none;
    }
    .tab-content.active {
        display: block;
        animation: fadeIn 0.3s ease-in-out;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* ===== Warning Box ===== */
    .warning-box {
        background: rgba(239, 68, 68, 0.1);
        border-radius: 12px;
        padding: 1.25rem;
        margin-bottom: 1.5rem;
        border-left: 4px solid var(--danger-color);
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
    }
    .warning-box i {
        color: var(--danger-color);
        font-size: 1.25rem;
        margin-top: 2px;
    }
    .warning-box p {
        color: var(--danger-color);
        margin: 0;
        font-weight: 500;
    }

    /* ===== Responsive Adjustments ===== */
    @media (max-width: 1023px) {
        .profile-sidebar {
            margin-bottom: 1.5rem;
        }
    }
    @media (max-width: 768px) {
        .profile-container {
            padding: 0 0.75rem;
            margin: 1rem auto;
        }
        .profile-sidebar, .profile-content {
            padding: 1.5rem;
        }
        .profile-avatar {
            width: 100px;
            height: 100px;
        }
    }
    @media (max-width: 576px) {
        .profile-sidebar, .profile-content {
            padding: 1.25rem;
        }
        .section-title {
            font-size: 1.3rem;
        }
        .btn {
            padding: 0.75rem 1.5rem;
            width: 100%;
        }
    }
</style>
@endpush

@section('content')
<div class="profile-container">
    <!-- Background elements -->
    <div class="profile-bg-elements">
        <div class="shape shape-1"></div>
        <div class="shape shape-2"></div>
        <div class="shape shape-3"></div>
    </div>

    @if(session('success'))
        <div class="alert-success">
            <i class="fas fa-check-circle"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <div class="profile-grid">
        {{-- Sidebar --}}
        <div class="profile-sidebar">
            <div class="profile-avatar-container">
                <img src="{{ auth()->user()->avatar_url ?? 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->name).'&background=6366f1&color=fff' }}"
                     alt="Avatar" class="profile-avatar">
                <div class="profile-avatar-edit">
                    <i class="fas fa-camera"></i>
                </div>
            </div>

            <h3 class="profile-name">{{ auth()->user()->name }}</h3>
            <p class="profile-email">{{ auth()->user()->email }}</p>

            <nav class="profile-nav">
    <!-- 1. Thông tin tài khoản -->
    <a href="#basic" class="profile-nav-link active" data-tab="basic">
        <i class="fas fa-user"></i> Thông tin cơ bản
    </a>
    <!-- 2. Bảo mật -->
    <a href="#password" class="profile-nav-link" data-tab="password">
        <i class="fas fa-lock"></i> Đổi mật khẩu
    </a>

    <!-- 3. Hoạt động -->
    <a href="{{ route('orders.index') }}" class="profile-nav-link">
        <i class="fas fa-box"></i> Lịch sử đơn hàng
    </a>
    <a href="{{ route('wishlist.index') }}" class="profile-nav-link">
        <i class="fas fa-heart"></i> Danh sách yêu thích
    </a>

    <!-- 4. Thông báo -->
    <a href="{{ route('notifications.index') }}" class="profile-nav-link">
        <i class="fas fa-bell"></i> Thông báo
    </a>

    <!-- 5. Xóa tài khoản -->
    <a href="#delete" class="profile-nav-link delete" data-tab="delete">
        <i class="fas fa-trash-alt"></i> Xóa tài khoản
    </a>
</nav>

        </div>

        {{-- Main Content --}}
        <div class="space-y-6">
            {{-- Basic Info --}}
            <div id="basic" class="profile-content tab-content active">
                <h3 class="section-title">Thông tin cơ bản</h3>

                @if(auth()->user()->unreadNotifications->count())
    <div class="alert-success" style="background-color:#f0fdfa; color:#0f766e; border-left-color:#0f766e;">
        <i class="fas fa-bell"></i>
        <div>
            <strong>Bạn có {{ auth()->user()->unreadNotifications->count() }} thông báo mới!</strong><br>
            <a href="{{ route('notifications.index') }}" style="text-decoration: underline; color: #0f766e;">
                Xem tất cả thông báo
            </a>
        </div>
    </div>
@endif


                <form method="POST" action="{{ route('front.profile.update') }}" enctype="multipart/form-data">
                    @csrf @method('PATCH')

                    <div class="form-group">
                        <label class="form-label">Họ tên</label>
                        <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}"
                               class="form-control" placeholder="Nhập họ tên của bạn">
                        @error('name')
                            <p class="error-message">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}"
                               class="form-control" placeholder="Nhập email của bạn">
                        @error('email')
                            <p class="error-message">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                    @if($defaultAddress)
    <div class="form-group">
        <label class="form-label">Địa chỉ mặc định</label>
        <div class="form-control" style="background-color: #f1f5f9;">
            {{ $defaultAddress->detail }},
            {{ $defaultAddress->district }},
            {{ $defaultAddress->province }}
        </div>
    </div>
@else
    <div class="form-group">
        <label class="form-label">Địa chỉ mặc định</label>
        <div class="form-control" style="background-color: #fef2f2; color: #dc2626;">
            Bạn chưa có địa chỉ mặc định
        </div>
    </div>
@endif


                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Lưu thay đổi
                    </button>
                </form>
            </div>

            {{-- Password Change --}}
            <div id="password" class="profile-content tab-content">
                <h3 class="section-title">Đổi mật khẩu</h3>

                <form method="POST" action="{{ route('front.profile.password') }}">
                    @csrf

                    <div class="form-group">
                        <label class="form-label">Mật khẩu hiện tại</label>
                        <input type="password" name="current_password" class="form-control" placeholder="Nhập mật khẩu hiện tại">
                        @error('current_password')
                            <p class="error-message">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Mật khẩu mới</label>
                        <input type="password" name="password" class="form-control" placeholder="Nhập mật khẩu mới">
                        @error('password')
                            <p class="error-message">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Xác nhận mật khẩu</label>
                        <input type="password" name="password_confirmation" class="form-control" placeholder="Nhập lại mật khẩu mới">
                    </div>

                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-key"></i> Cập nhật mật khẩu
                    </button>
                </form>
            </div>

            {{-- Account Deletion --}}
            <div id="delete" class="profile-content tab-content">
                <h3 class="section-title delete">Xóa tài khoản</h3>

                <div class="warning-box">
                    <i class="fas fa-exclamation-triangle"></i>
                    <p>Hành động này không thể hoàn tác. Tất cả dữ liệu của bạn sẽ bị xóa vĩnh viễn.</p>
                </div>

                <form method="POST" action="{{ route('front.profile.destroy') }}" onsubmit="return confirm('Bạn có chắc chắn muốn xóa tài khoản? Hành động này không thể hoàn tác.');">
                    @csrf @method('DELETE')

                    <div class="form-group">
                        <label class="form-label">Nhập mật khẩu để xác nhận</label>
                        <input type="password" name="password" class="form-control" placeholder="Nhập mật khẩu của bạn">
                        @error('password')
                            <p class="error-message">
                                <i class="fas fa-exclamation-circle"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash-alt"></i> Xóa vĩnh viễn
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Tab switching functionality
        const tabLinks = document.querySelectorAll('[data-tab]');

        tabLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const tabId = this.getAttribute('data-tab');

                // Update active tab link
                tabLinks.forEach(tab => {
                    tab.classList.remove('active');
                });
                this.classList.add('active');

                // Show corresponding tab content
                document.querySelectorAll('.tab-content').forEach(content => {
                    content.classList.remove('active');
                });
                document.getElementById(tabId).classList.add('active');
            });
        });

        // Avatar edit functionality
        const avatarEdit = document.querySelector('.profile-avatar-edit');
        if (avatarEdit) {
            avatarEdit.addEventListener('click', function() {
                // In a real implementation, this would trigger a file input
                alert('Chức năng thay đổi ảnh đại diện sẽ được thêm sau');
            });
        }
    });
</script>
@endpush

{{-- resources/views/auth/register.blade.php --}}
@extends('layouts.front')

@section('title', 'Đăng ký')

@push('styles')
<style>
  .register-section {
    background: linear-gradient(135deg, #f5f7fa 0%, #e4e8ed 100%);
    min-height: 100vh;
    display: flex;
    align-items: center;
    padding: 2rem 0;
  }

  .register-card {
    border: none;
    border-radius: 1.5rem;
    overflow: hidden;
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
  }

  .register-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
  }

  .register-card .card-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: #fff;
    text-align: center;
    padding: 2.5rem 1.5rem;
    position: relative;
    overflow: hidden;
  }

  .register-card .card-header::before {
    content: '';
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 70%);
    transform: rotate(30deg);
  }

  .register-card .card-body {
    background: #fff;
    padding: 2.5rem;
  }

  .register-title {
    font-family: 'Playfair Display', serif;
    font-weight: 700;
    margin-bottom: 0.5rem;
    position: relative;
    display: inline-block;
  }

  .register-title::after {
    content: '';
    position: absolute;
    bottom: -10px;
    left: 50%;
    transform: translateX(-50%);
    width: 80px;
    height: 3px;
    background: rgba(255,255,255,0.5);
    border-radius: 3px;
  }

  .register-subtitle {
    font-weight: 300;
    opacity: 0.9;
    margin-bottom: 0;
  }

  .form-control-lg {
    border-radius: 0.75rem;
    padding: 1rem 1.25rem;
    border: 1px solid #e2e8f0;
    transition: all 0.3s ease;
    box-shadow: none;
  }

  .form-control-lg:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.15);
  }

  .form-label {
    font-weight: 600;
    color: #4a5568;
    margin-bottom: 0.5rem;
  }

  .btn-register {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    font-weight: 600;
    padding: 0.75rem 2rem;
    border-radius: 0.75rem;
    color: white;
    transition: all 0.3s ease;
    box-shadow: 0 4px 6px rgba(102, 126, 234, 0.2);
  }

  .btn-register:hover {
    transform: translateY(-2px);
    box-shadow: 0 7px 14px rgba(102, 126, 234, 0.25);
  }

  .login-link {
    color: #667eea;
    font-weight: 500;
    transition: all 0.2s ease;
    text-decoration: none;
  }

  .login-link:hover {
    color: #5a67d8;
    text-decoration: underline;
  }

  .form-check-input:checked {
    background-color: #667eea;
    border-color: #667eea;
  }

  .form-check-label {
    color: #4a5568;
  }

  .invalid-feedback {
    font-size: 0.875rem;
    margin-top: 0.25rem;
  }

  /* Responsive adjustments */
  @media (max-width: 768px) {
    .register-card .card-body {
      padding: 1.5rem;
    }

    .register-card .card-header {
      padding: 1.5rem;
    }
  }
</style>
@endpush

@section('content')
<div class="register-section">
  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-md-8 col-lg-6">
        {{-- Hiển thị session status --}}
        @if (session('status'))
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('status') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif

        <div class="card shadow-lg register-card">
          <div class="card-header">
            <h2 class="register-title mb-2"><i class="bi bi-person-plus-fill me-2"></i>Chào mừng đến với ShoeSport!</h2>
            <p class="register-subtitle">Tạo tài khoản để trải nghiệm mua sắm tuyệt vời</p>
          </div>
          <div class="card-body">
            <form method="POST" action="{{ route('register') }}">
              @csrf

              <div class="row">
                {{-- Họ và tên --}}
                <div class="col-md-6 mb-4">
                  <label for="name" class="form-label">Họ và tên</label>
                  <input id="name" type="text" name="name"
                         value="{{ old('name') }}"
                         class="form-control form-control-lg @error('name') is-invalid @enderror"
                         placeholder="Nhập họ tên đầy đủ"
                         required autofocus autocomplete="name">
                  @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                {{-- Email --}}
                <div class="col-md-6 mb-4">
                  <label for="email" class="form-label">Email</label>
                  <input id="email" type="email" name="email"
                         value="{{ old('email') }}"
                         class="form-control form-control-lg @error('email') is-invalid @enderror"
                         placeholder="Nhập địa chỉ email"
                         required autocomplete="email">
                  @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>

              <div class="row">
                {{-- Số điện thoại --}}
                <div class="col-md-6 mb-4">
                  <label for="phone" class="form-label">Số điện thoại</label>
                  <input id="phone" type="tel" name="phone"
                         value="{{ old('phone') }}"
                         class="form-control form-control-lg @error('phone') is-invalid @enderror"
                         placeholder="Nhập số điện thoại"
                         required autocomplete="tel">
                  @error('phone')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                {{-- Địa chỉ --}}
                <div class="col-md-6 mb-4">
                  <label for="address" class="form-label">Địa chỉ</label>
                  <input id="address" type="text" name="address"
                         value="{{ old('address') }}"
                         class="form-control form-control-lg @error('address') is-invalid @enderror"
                         placeholder="Nhập địa chỉ của bạn"
                         required autocomplete="street-address">
                  @error('address')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>

              <div class="row">
                {{-- Mật khẩu --}}
                <div class="col-md-6 mb-4">
                  <label for="password" class="form-label">Mật khẩu</label>
                  <input id="password" type="password" name="password"
                         class="form-control form-control-lg @error('password') is-invalid @enderror"
                         placeholder="Nhập mật khẩu"
                         required autocomplete="new-password">
                  @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                {{-- Xác nhận mật khẩu --}}
                <div class="col-md-6 mb-4">
                  <label for="password_confirmation" class="form-label">Xác nhận mật khẩu</label>
                  <input id="password_confirmation" type="password" name="password_confirmation"
                         class="form-control form-control-lg @error('password_confirmation') is-invalid @enderror"
                         placeholder="Nhập lại mật khẩu"
                         required autocomplete="new-password">
                  @error('password_confirmation')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>

              <div class="form-check mb-4">
                <input class="form-check-input" type="checkbox" id="terms" required>
                <label class="form-check-label" for="terms">
                  Tôi đồng ý với <a href="#" class="login-link">Điều khoản dịch vụ</a> và <a href="#" class="login-link">Chính sách bảo mật</a>
                </label>
              </div>

              <div class="d-grid mb-4">
                <button type="submit" class="btn btn-register btn-lg">
                  <i class="bi bi-check2-circle me-2"></i> Đăng ký
                </button>
              </div>

              <div class="text-center">
                <p class="mb-0">Đã có tài khoản?
                  <a href="{{ route('login') }}" class="login-link fw-bold">
                    <i class="bi bi-box-arrow-in-right me-1"></i>Đăng nhập ngay
                  </a>
                </p>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

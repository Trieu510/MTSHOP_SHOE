{{-- resources/views/auth/login.blade.php --}}
@extends('layouts.front')

@section('title', 'Đăng nhập')

@push('styles')
<style>
  .login-section {
    background: linear-gradient(135deg, #f5f7fa 0%, #e4e8ed 100%);
    min-height: 100vh;
    display: flex;
    align-items: center;
    padding: 2rem 0;
  }

  .login-card {
    border: none;
    border-radius: 1.5rem;
    overflow: hidden;
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
  }

  .login-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
  }

  .login-card .card-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: #fff;
    text-align: center;
    padding: 2.5rem 1.5rem;
    position: relative;
    overflow: hidden;
  }

  .login-card .card-header::before {
    content: '';
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 70%);
    transform: rotate(30deg);
  }

  .login-card .card-body {
    background: #fff;
    padding: 2.5rem;
  }

  .login-title {
    font-family: 'Playfair Display', serif;
    font-weight: 700;
    margin-bottom: 0.5rem;
    position: relative;
    display: inline-block;
  }

  .login-title::after {
    content: '';
    position: absolute;
    bottom: -10px;
    left: 50%;
    transform: translateX(-50%);
    width: 50px;
    height: 3px;
    background: rgba(255,255,255,0.5);
    border-radius: 3px;
  }

  .login-subtitle {
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

  .btn-login {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    font-weight: 600;
    padding: 0.75rem 2rem;
    border-radius: 0.75rem;
    color: white;
    transition: all 0.3s ease;
    box-shadow: 0 4px 6px rgba(102, 126, 234, 0.2);
  }

  .btn-login:hover {
    transform: translateY(-2px);
    box-shadow: 0 7px 14px rgba(102, 126, 234, 0.25);
  }

  .forgot-link, .register-link {
    color: #667eea;
    font-weight: 500;
    transition: all 0.2s ease;
    text-decoration: none;
  }

  .forgot-link:hover, .register-link:hover {
    color: #5a67d8;
    text-decoration: underline;
  }

  .divider {
    display: flex;
    align-items: center;
    margin: 1.5rem 0;
    color: #a0aec0;
  }

  .divider::before, .divider::after {
    content: '';
    flex: 1;
    border-bottom: 1px solid #e2e8f0;
  }

  .divider::before {
    margin-right: 1rem;
  }

  .divider::after {
    margin-left: 1rem;
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
    .login-card .card-body {
      padding: 1.5rem;
    }

    .login-card .card-header {
      padding: 1.5rem;
    }
  }
</style>
@endpush

@section('content')
<div class="login-section">
  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-md-6 col-lg-5">
        <div class="card shadow-lg login-card">
          <div class="card-header">
            <h1 class="login-title h3 mb-2"><i class="bi bi-shield-lock me-2"></i>Chào mừng trở lại!</h1>
            <p class="login-subtitle">Đăng nhập để khám phá thế giới thể thao</p>
          </div>
          <div class="card-body">
            @if (session('status'))
              <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('status') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
            @endif

            {{-- Google Login --}}
<div class="d-grid mb-3">
  <a href="{{ route('google.login') }}" class="btn btn-outline-danger btn-lg" style="display: flex; align-items: center; justify-content: center;">
    <img src="https://developers.google.com/identity/images/g-logo.png" alt="Google Logo" style="width: 20px; height: 20px; margin-right: 8px;">
    Đăng nhập bằng Google
  </a>
</div>

<div class="divider">hoặc</div>


            <form method="POST" action="{{ route('login') }}">
              @csrf

              {{-- Email --}}
              <div class="mb-4">
                <label for="email" class="form-label">Email</label>
                <input id="email" type="email" name="email"
                       value="{{ old('email') }}"
                       class="form-control form-control-lg @error('email') is-invalid @enderror"
                       placeholder="Nhập email của bạn"
                       required autofocus autocomplete="username">
                @error('email')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              {{-- Password --}}
              <div class="mb-4">
                <label for="password" class="form-label">Mật khẩu</label>
                <input id="password" type="password" name="password"
                       class="form-control form-control-lg @error('password') is-invalid @enderror"
                       placeholder="Nhập mật khẩu"
                       required autocomplete="current-password">
                @error('password')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              {{-- Remember Me --}}
              <div class="form-check mb-4">
                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                <label class="form-check-label" for="remember">
                  Ghi nhớ đăng nhập
                </label>
              </div>

              <div class="d-grid mb-4">
                <button type="submit" class="btn btn-login btn-lg">
                  <i class="bi bi-box-arrow-in-right me-2"></i> Đăng nhập
                </button>
              </div>

              <div class="text-center mb-3">
                @if (Route::has('password.request'))
                  <a href="{{ route('password.request') }}" class="forgot-link">
                    <i class="bi bi-key me-1"></i>Quên mật khẩu?
                  </a>
                @endif
              </div>

              <div class="divider">hoặc</div>

              <p class="text-center mb-0">
                Chưa có tài khoản?
                <a href="{{ route('register') }}" class="register-link fw-bold ms-1">
                  Đăng ký ngay
                </a>
              </p>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

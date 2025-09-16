{{-- resources/views/auth/forgot-password.blade.php --}}
@extends('layouts.front')

@section('title', 'Quên mật khẩu')

@push('styles')
<style>
  .forgot-section {
    background: linear-gradient(135deg, #f5f7fa 0%, #e4e8ed 100%);
    min-height: 100vh;
    display: flex;
    align-items: center;
    padding: 2rem 0;
  }

  .forgot-card {
    border: none;
    border-radius: 1.5rem;
    overflow: hidden;
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    background: white;
  }

  .forgot-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
  }

  .forgot-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    text-align: center;
    padding: 2.5rem 1.5rem;
    position: relative;
    overflow: hidden;
  }

  .forgot-header::before {
    content: '';
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 70%);
    transform: rotate(30deg);
  }

  .forgot-title {
    font-family: 'Playfair Display', serif;
    font-weight: 700;
    margin-bottom: 0.5rem;
    position: relative;
    display: inline-block;
  }

  .forgot-title::after {
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

  .forgot-subtitle {
    font-weight: 300;
    opacity: 0.9;
    margin-bottom: 0;
  }

  .forgot-body {
    padding: 2.5rem;
  }

  .forgot-form .form-control {
    border-radius: 0.75rem;
    padding: 1rem 1.25rem;
    border: 1px solid #e2e8f0;
    transition: all 0.3s ease;
    box-shadow: none;
  }

  .forgot-form .form-control:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.15);
  }

  .form-label {
    font-weight: 600;
    color: #4a5568;
    margin-bottom: 0.5rem;
  }

  .btn-reset {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    font-weight: 600;
    padding: 0.75rem 2rem;
    border-radius: 0.75rem;
    color: white;
    transition: all 0.3s ease;
    box-shadow: 0 4px 6px rgba(102, 126, 234, 0.2);
  }

  .btn-reset:hover {
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

  .invalid-feedback {
    font-size: 0.875rem;
    margin-top: 0.25rem;
  }

  /* Responsive adjustments */
  @media (max-width: 768px) {
    .forgot-body {
      padding: 1.5rem;
    }

    .forgot-header {
      padding: 1.5rem;
    }
  }
</style>
@endpush

@section('content')
<div class="forgot-section">
  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-md-8 col-lg-6">
        <div class="card shadow-lg forgot-card">
          <div class="forgot-header">
            <h2 class="forgot-title"><i class="bi bi-key-fill me-2"></i>Quên mật khẩu</h2>
            <p class="forgot-subtitle">Nhập email để nhận liên kết đặt lại mật khẩu</p>
          </div>

          <div class="forgot-body">
            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('password.email') }}" class="forgot-form">
              @csrf

              <!-- Email Address -->
              <div class="mb-4">
                <label for="email" class="form-label">Email</label>
                <input id="email" type="email" name="email"
                       value="{{ old('email') }}"
                       class="form-control @error('email') is-invalid @enderror"
                       placeholder="Nhập email của bạn"
                       required autofocus autocomplete="email">
                @error('email')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <div class="d-flex justify-content-between align-items-center">
                <a href="{{ route('login') }}" class="login-link">
                  <i class="bi bi-arrow-left me-1"></i>Quay lại đăng nhập
                </a>
                <button type="submit" class="btn btn-reset">
                  <i class="bi bi-send-fill me-1"></i>Gửi liên kết
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

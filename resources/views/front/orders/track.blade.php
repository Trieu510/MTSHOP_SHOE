@extends('layouts.front')

@section('title', 'Tra cứu đơn hàng')

@section('content')
<section class="order-tracking-section">
  <div class="particles-js" id="particles-js"></div>
  <div class="container position-relative">
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <div class="order-tracking-header text-center mb-5">
          <div class="tracking-icon animate__animated animate__zoomIn">
            <i class="fas fa-search-location"></i>
          </div>
          <h1 class="display-4 fw-bold text-gradient mb-3">Tra Cứu Đơn Hàng</h1>
          <p class="lead text-muted">Nhập mã đơn hàng để kiểm tra trạng thái đơn hàng của bạn</p>
          <div class="header-divider"></div>
        </div>

        <div class="tracking-form-wrapper position-relative">
          @if(session('error'))
          <div class="alert alert-danger alert-dismissible fade show alert-elevated" role="alert">
            <div class="d-flex align-items-center">
              <i class="fas fa-exclamation-triangle me-3 fs-4"></i>
              <div>
                <h6 class="alert-heading mb-1">Không tìm thấy đơn hàng</h6>
                <p class="mb-0">{{ session('error') }}</p>
              </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
          @endif

          <div class="tracking-form-card animate__animated animate__fadeInUp">
            <div class="card-body p-5">
              <form method="POST" action="{{ route('orders.track') }}" class="needs-validation" novalidate>
                @csrf
                <div class="form-floating mb-4">
                  <input type="text" class="form-control form-control-lg" id="order_code" name="order_code" placeholder=" " required>
                  <label for="order_code">
                    <i class="fas fa-receipt me-2"></i>Mã đơn hàng
                  </label>
                  <div class="invalid-feedback">
                    Vui lòng nhập mã đơn hàng
                  </div>
                  <small class="form-text text-muted mt-2 d-block">
                    <i class="fas fa-info-circle me-1"></i> Mã đơn hàng gồm 8-12 ký tự, được gửi qua email khi đặt hàng thành công
                  </small>
                </div>

                <div class="d-grid mt-4">
                  <button type="submit" class="btn btn-primary-gradient btn-lg py-3 btn-track">
                    <span class="btn-track-text">Tra Cứu Ngay</span>
                    <span class="btn-track-icon">
                      <i class="fas fa-search"></i>
                    </span>
                    <span class="btn-track-loader">
                      <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    </span>
                  </button>
                </div>
              </form>
            </div>
            <div class="card-footer bg-transparent text-center py-3">
              <p class="mb-0 text-muted">
                <i class="fas fa-question-circle me-1"></i> Cần hỗ trợ?
                <a href="#" class="text-primary">Xem hướng dẫn tra cứu</a> hoặc liên hệ hotline
              </p>
            </div>
          </div>
        </div>

        <div class="tracking-features mt-5 pt-5">
          <div class="row g-4">
            <div class="col-md-4">
              <div class="feature-card">
                <div class="feature-icon bg-primary-light">
                  <i class="fas fa-shipping-fast text-primary"></i>
                </div>
                <h5 class="mt-4 mb-3">Theo dõi vận chuyển</h5>
                <p class="text-muted">Cập nhật trạng thái vận chuyển đơn hàng theo thời gian thực</p>
              </div>
            </div>
            <div class="col-md-4">
              <div class="feature-card">
                <div class="feature-icon bg-success-light">
                  <i class="fas fa-history text-success"></i>
                </div>
                <h5 class="mt-4 mb-3">Lịch sử đơn hàng</h5>
                <p class="text-muted">Xem lại toàn bộ lịch sử đơn hàng đã đặt trong tài khoản</p>
              </div>
            </div>
            <div class="col-md-4">
              <div class="feature-card">
                <div class="feature-icon bg-warning-light">
                  <i class="fas fa-headset text-warning"></i>
                </div>
                <h5 class="mt-4 mb-3">Hỗ trợ 24/7</h5>
                <p class="text-muted">Đội ngũ hỗ trợ luôn sẵn sàng giải đáp mọi thắc mắc của bạn</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection

@section('styles')
<style>
  .order-tracking-section {
    padding: 6rem 0;
    position: relative;
    overflow: hidden;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
  }

  #particles-js {
    position: absolute;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    z-index: 0;
  }

  .order-tracking-header {
    position: relative;
    padding-bottom: 1.5rem;
  }

  .tracking-icon {
    width: 100px;
    height: 100px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2.5rem;
    margin: 0 auto 2rem;
    box-shadow: 0 15px 30px rgba(102, 126, 234, 0.3);
    transition: all 0.3s ease;
  }

  .tracking-icon:hover {
    transform: scale(1.05) rotate(10deg);
  }

  .header-divider {
    width: 150px;
    height: 4px;
    background: linear-gradient(to right, #667eea, #8f94fb);
    margin: 1.5rem auto 0;
    border-radius: 2px;
    opacity: 0.7;
  }

  .text-gradient {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    display: inline-block;
  }

  .tracking-form-wrapper {
    position: relative;
    z-index: 1;
  }

  .alert-elevated {
    border: none;
    border-radius: 12px;
    box-shadow: 0 10px 30px rgba(220, 53, 69, 0.2);
    backdrop-filter: blur(5px);
    background-color: rgba(255, 255, 255, 0.9);
    border-left: 4px solid #dc3545;
    padding: 1.25rem 1.5rem;
    margin-bottom: 2rem;
  }

  .tracking-form-card {
    border: none;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 20px 50px rgba(0, 0, 0, 0.1);
    background-color: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    transform: translateY(0);
  }

  .tracking-form-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 25px 60px rgba(0, 0, 0, 0.15);
  }

  .form-floating label {
    color: #6c757d;
    font-weight: 500;
  }

  .form-control-lg {
    height: 60px;
    font-size: 1.1rem;
    border-radius: 12px !important;
    padding: 1rem 1.25rem;
    border: 2px solid #e9ecef;
    transition: all 0.3s;
  }

  .form-control-lg:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.25rem rgba(102, 126, 234, 0.25);
  }

  .btn-primary-gradient {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    color: white;
    border-radius: 12px;
    font-weight: 600;
    letter-spacing: 0.5px;
    padding: 1rem;
    position: relative;
    overflow: hidden;
    transition: all 0.4s;
  }

  .btn-track-text, .btn-track-icon, .btn-track-loader {
    transition: all 0.3s;
  }

  .btn-track-icon, .btn-track-loader {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    opacity: 0;
  }

  .btn-primary-gradient:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
  }

  .btn-primary-gradient:active {
    transform: translateY(0);
  }

  .btn-primary-gradient.loading .btn-track-text {
    opacity: 0;
    transform: translateY(20px);
  }

  .btn-primary-gradient.loading .btn-track-loader {
    opacity: 1;
  }

  .btn-primary-gradient.success .btn-track-loader {
    opacity: 0;
  }

  .btn-primary-gradient.success .btn-track-icon {
    opacity: 1;
  }

  .tracking-features {
    position: relative;
    z-index: 1;
  }

  .feature-card {
    background: rgba(255, 255, 255, 0.9);
    border-radius: 16px;
    padding: 2rem;
    height: 100%;
    transition: all 0.3s ease;
    border: 1px solid rgba(0, 0, 0, 0.05);
  }

  .feature-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.08);
  }

  .feature-icon {
    width: 70px;
    height: 70px;
    border-radius: 18px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.75rem;
  }

  .bg-primary-light {
    background-color: rgba(102, 126, 234, 0.1);
  }

  .bg-success-light {
    background-color: rgba(40, 167, 69, 0.1);
  }

  .bg-warning-light {
    background-color: rgba(255, 193, 7, 0.1);
  }

  @media (max-width: 991.98px) {
    .order-tracking-section {
      padding: 4rem 0;
    }

    .tracking-icon {
      width: 80px;
      height: 80px;
      font-size: 2rem;
    }
  }

  @media (max-width: 767.98px) {
    .tracking-form-card {
      border-radius: 16px;
    }

    .feature-card {
      padding: 1.5rem;
    }

    .feature-icon {
      width: 60px;
      height: 60px;
      font-size: 1.5rem;
    }
  }
</style>
@endsection

@section('scripts')
<!-- Font Awesome -->
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

<!-- Animate.css -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

<!-- Particles.js -->
<script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>

<script>
  $(document).ready(function() {
    // Initialize particles.js
    particlesJS("particles-js", {
      "particles": {
        "number": {
          "value": 60,
          "density": {
            "enable": true,
            "value_area": 800
          }
        },
        "color": {
          "value": "#667eea"
        },
        "shape": {
          "type": "circle",
          "stroke": {
            "width": 0,
            "color": "#000000"
          }
        },
        "opacity": {
          "value": 0.3,
          "random": true,
          "anim": {
            "enable": true,
            "speed": 1,
            "opacity_min": 0.1,
            "sync": false
          }
        },
        "size": {
          "value": 3,
          "random": true,
          "anim": {
            "enable": true,
            "speed": 2,
            "size_min": 0.1,
            "sync": false
          }
        },
        "line_linked": {
          "enable": true,
          "distance": 150,
          "color": "#667eea",
          "opacity": 0.2,
          "width": 1
        },
        "move": {
          "enable": true,
          "speed": 1,
          "direction": "none",
          "random": true,
          "straight": false,
          "out_mode": "out",
          "bounce": false,
          "attract": {
            "enable": true,
            "rotateX": 600,
            "rotateY": 1200
          }
        }
      },
      "interactivity": {
        "detect_on": "canvas",
        "events": {
          "onhover": {
            "enable": true,
            "mode": "grab"
          },
          "onclick": {
            "enable": true,
            "mode": "push"
          },
          "resize": true
        },
        "modes": {
          "grab": {
            "distance": 140,
            "line_linked": {
              "opacity": 0.5
            }
          },
          "push": {
            "particles_nb": 4
          }
        }
      },
      "retina_detect": true
    });

    // Form validation
    const form = document.querySelector('.needs-validation');
    form.addEventListener('submit', function(event) {
      if (!form.checkValidity()) {
        event.preventDefault();
        event.stopPropagation();
      } else {
        const btn = document.querySelector('.btn-track');
        btn.classList.add('loading');

        // Simulate loading (remove this in production)
        setTimeout(() => {
          btn.classList.remove('loading');
          btn.classList.add('success');
        }, 1500);
      }
      form.classList.add('was-validated');
    }, false);

    // Focus on input field
    $('#order_code').focus();
  });
</script>
@endsection

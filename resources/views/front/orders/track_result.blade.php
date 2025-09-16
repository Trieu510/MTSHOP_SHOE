@extends('layouts.front')

@section('title', 'Kết quả tra cứu đơn hàng')

@section('content')
<section class="order-result-section py-5">
  <div class="container">
    <div class="text-center mb-5">
      <h2 class="display-5 fw-bold text-primary mb-3">
        <i class="fas fa-search-location me-2"></i>Kết quả tra cứu đơn hàng
      </h2>
      <div class="divider mx-auto"></div>
    </div>

    <div class="order-card card border-0 shadow-lg overflow-hidden mb-4 animate__animated animate__fadeIn">
      <div class="card-header bg-primary-gradient text-white py-3">
        <div class="d-flex justify-content-between align-items-center">
          <h4 class="mb-0 fw-bold">
            <i class="fas fa-receipt me-2"></i>Thông tin đơn hàng
          </h4>
          <span class="order-status badge bg-white text-primary fs-6 py-2 px-3 rounded-pill">
            {{ ucfirst($order->status) }}
          </span>
        </div>
      </div>

      <div class="card-body">
        <div class="order-details">
          <div class="detail-item">
            <span class="detail-label"><i class="fas fa-barcode me-2"></i>Mã đơn hàng:</span>
            <span class="detail-value">{{ $order->id }}</span>
          </div>
          <div class="detail-item">
            <span class="detail-label"><i class="fas fa-user me-2"></i>Tên người nhận:</span>
            <span class="detail-value">{{ $order->name }}</span>
          </div>
          <div class="detail-item">
            <span class="detail-label"><i class="fas fa-phone me-2"></i>SĐT:</span>
            <span class="detail-value">{{ $order->phone }}</span>
          </div>
          <div class="detail-item">
            <span class="detail-label"><i class="fas fa-map-marker-alt me-2"></i>Địa chỉ:</span>
            <span class="detail-value">{{ $order->address }}</span>
          </div>
          <div class="detail-item">
            <span class="detail-label"><i class="fas fa-calendar-alt me-2"></i>Ngày đặt:</span>
            <span class="detail-value">{{ $order->created_at->format('d/m/Y H:i') }}</span>
          </div>
          <div class="detail-item">
            <span class="detail-label"><i class="fas fa-money-bill-wave me-2"></i>Tổng tiền:</span>
            <span class="detail-value text-danger fw-bold">{{ number_format($order->total_amount, 0, ',', '.') }}đ</span>
          </div>
        </div>

        <div class="order-products mt-4 pt-4 border-top">
          <h5 class="section-title mb-3">
            <i class="fas fa-box-open me-2"></i>Sản phẩm trong đơn
          </h5>
          <div class="products-list">
            @foreach($order->items as $item)
            <div class="product-item">
              <div class="product-info">
                <span class="product-name">{{ $item->product->name }}</span>
                <span class="product-meta">SL: {{ $item->quantity }} | Giá: {{ number_format($item->price, 0, ',', '.') }}đ</span>
              </div>
            </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>

    <div class="text-center mt-4">
      <a href="{{ route('orders.track') }}" class="btn btn-primary-gradient">
        <i class="fas fa-search me-2"></i>Tra cứu đơn khác
      </a>
    </div>
  </div>
</section>
@endsection

@section('styles')
<style>
  .order-result-section {
    background-color: #f8fafc;
  }

  .divider {
    width: 80px;
    height: 3px;
    background: linear-gradient(to right, #4e54c8, #8f94fb);
    margin: 15px auto;
  }

  .order-card {
    border-radius: 12px;
    overflow: hidden;
    transition: all 0.3s ease;
  }

  .order-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
  }

  .bg-primary-gradient {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  }

  .btn-primary-gradient {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    color: white;
    padding: 10px 25px;
    border-radius: 8px;
    transition: all 0.3s;
  }

  .btn-primary-gradient:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
    color: white;
  }

  .order-status {
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
  }

  .order-details {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 15px;
  }

  .detail-item {
    margin-bottom: 10px;
  }

  .detail-label {
    font-weight: 600;
    color: #555;
    display: block;
    margin-bottom: 3px;
  }

  .detail-value {
    color: #333;
    display: block;
  }

  .section-title {
    color: #4e54c8;
    font-weight: 600;
    position: relative;
    padding-bottom: 10px;
  }

  .section-title::after {
    content: '';
    position: absolute;
    left: 0;
    bottom: 0;
    width: 50px;
    height: 2px;
    background: linear-gradient(to right, #4e54c8, #8f94fb);
  }

  .products-list {
    border-radius: 8px;
    overflow: hidden;
  }

  .product-item {
    padding: 12px 15px;
    background-color: #fff;
    border-bottom: 1px solid #eee;
    transition: all 0.2s;
  }

  .product-item:last-child {
    border-bottom: none;
  }

  .product-item:hover {
    background-color: #f9f9ff;
  }

  .product-name {
    font-weight: 500;
    display: block;
    margin-bottom: 5px;
  }

  .product-meta {
    font-size: 0.9rem;
    color: #666;
  }

  @media (max-width: 767.98px) {
    .order-details {
      grid-template-columns: 1fr;
    }

    .order-card {
      border-radius: 8px;
    }
  }
</style>
@endsection

@section('scripts')
<!-- Font Awesome -->
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

<!-- Animate.css -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

<script>
  $(document).ready(function() {
    // Add hover effects
    $('.order-card').hover(
      function() {
        $(this).addClass('shadow-lg');
      },
      function() {
        $(this).removeClass('shadow-lg');
      }
    );
  });
</script>
@endsection

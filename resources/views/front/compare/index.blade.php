@extends('layouts.front')

@section('title', 'So sánh sản phẩm')

@section('content')
<div class="container py-5">
  <div class="compare-header text-center mb-5">
    <h2 class="display-5 fw-bold text-primary">🔍 So Sánh Sản Phẩm</h2>
    <p class="text-muted">Đối chiếu chi tiết để lựa chọn tốt nhất</p>
  </div>

  @if(session('compare') && count($products))
    @php
      // Phân tích sự khác biệt
      $values = [
        'price' => $products->pluck('price')->unique(),
        'brand' => $products->pluck('brand')->unique(),
        'material' => $products->pluck('material')->unique(),
        'care_instructions' => $products->pluck('care_instructions')->unique(),
        'gender' => $products->pluck('gender')->unique(),
        'average_rating' => $products->pluck('average_rating')->unique(),
        'sizes' => $products->map(fn($p) => $p->variants->pluck('size')->implode(','))->unique(),
        'stock' => $products->map(fn($p) => $p->variants->min('stock'))->unique(),
      ];
    @endphp

    <div class="compare-container mb-5">
      <div class="table-responsive rounded-4 shadow">
        <table class="table table-borderless compare-table mb-0">
          <thead>
            <tr class="product-row">
              <th class="compare-label bg-light">Thông tin</th>
              @foreach ($products as $product)
                <th class="product-card">
                  <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body p-3">
                      <div class="product-image-container mb-3">
                        <img src="{{ $product->primary_image }}" alt="{{ $product->name }}"
                             class="img-fluid rounded-3" style="max-height: 180px; object-fit: contain;">
                      </div>
                      <h5 class="product-title mb-3">{{ $product->name }}</h5>
                      <form action="{{ route('compare.remove', $product->id) }}" method="POST" class="mb-2">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3">
                          <i class="fas fa-trash-alt me-1"></i> Xoá
                        </button>
                      </form>
                    </div>
                  </div>
                </th>
              @endforeach
            </tr>
          </thead>
          <tbody>
            <!-- Giá -->
            <tr class="detail-row">
              <td class="compare-label bg-light fw-semibold">Giá</td>
              @foreach ($products as $product)
                <td class="{{ $values['price']->count() > 1 ? 'highlight-difference' : '' }}">
                  <span class="price-value">{{ number_format($product->price, 0, ',', '.') }}₫</span>
                </td>
              @endforeach
            </tr>

            <!-- Giới tính -->
            <tr class="detail-row">
              <td class="compare-label bg-light fw-semibold">Giới tính</td>
              @foreach ($products as $product)
                <td class="{{ $values['gender']->count() > 1 ? 'highlight-difference' : '' }}">
                  {{ ucfirst($product->gender ?? 'Không có') }}
                </td>
              @endforeach
            </tr>

            <!-- Thương hiệu -->
            <tr class="detail-row">
              <td class="compare-label bg-light fw-semibold">Thương hiệu</td>
              @foreach ($products as $product)
                <td class="{{ $values['brand']->count() > 1 ? 'highlight-difference' : '' }}">
                  {{ $product->brand ?? 'Không có' }}
                </td>
              @endforeach
            </tr>

            <!-- Chất liệu -->
            <tr class="detail-row">
              <td class="compare-label bg-light fw-semibold">Chất liệu</td>
              @foreach ($products as $product)
                <td class="{{ $values['material']->count() > 1 ? 'highlight-difference' : '' }}">
                  {{ $product->material ?? 'Không có' }}
                </td>
              @endforeach
            </tr>

            <!-- Bảo quản -->
            <tr class="detail-row">
              <td class="compare-label bg-light fw-semibold">Bảo quản</td>
              @foreach ($products as $product)
                <td class="{{ $values['care_instructions']->count() > 1 ? 'highlight-difference' : '' }}">
                  {{ $product->care_instructions ?? 'Không có' }}
                </td>
              @endforeach
            </tr>

            <!-- Đánh giá -->
            <tr class="detail-row">
              <td class="compare-label bg-light fw-semibold">Đánh giá</td>
              @foreach ($products as $product)
                <td class="{{ $values['average_rating']->count() > 1 ? 'highlight-difference' : '' }}">
                  <div class="rating-stars">
                    @for ($i = 1; $i <= 5; $i++)
                      @if ($i <= floor($product->average_rating))
                        <i class="fas fa-star text-warning"></i>
                      @elseif ($i == ceil($product->average_rating) && ($product->average_rating - floor($product->average_rating) >= 0.5))
    <i class="fas fa-star-half-alt text-warning"></i>
                      @else
                        <i class="far fa-star text-warning"></i>
                      @endif
                    @endfor
                    <span class="ms-2">{{ number_format($product->average_rating, 1) }}/5</span>
                  </div>
                </td>
              @endforeach
            </tr>

            <!-- Kích cỡ -->
            <tr class="detail-row">
              <td class="compare-label bg-light fw-semibold">Kích cỡ (Size)</td>
              @foreach ($products as $product)
                @php $sizes = $product->variants->pluck('size')->implode(', '); @endphp
                <td class="{{ $values['sizes']->count() > 1 ? 'highlight-difference' : '' }}">
                  @if($sizes)
                    <div class="d-flex flex-wrap gap-1 justify-content-center">
                      @foreach(explode(',', $sizes) as $size)
                        <span class="badge bg-secondary">{{ trim($size) }}</span>
                      @endforeach
                    </div>
                  @else
                    Không có
                  @endif
                </td>
              @endforeach
            </tr>

            <!-- Tồn kho -->
            <tr class="detail-row">
              <td class="compare-label bg-light fw-semibold">Tồn kho (min)</td>
              @foreach ($products as $product)
                @php $minStock = $product->variants->min('stock'); @endphp
                <td class="{{ $values['stock']->count() > 1 ? 'highlight-difference' : '' }}">
                  @if($minStock > 10)
                    <span class="text-success fw-bold">{{ $minStock }} <i class="fas fa-check-circle"></i></span>
                  @elseif($minStock > 0)
                    <span class="text-warning fw-bold">{{ $minStock }} <i class="fas fa-exclamation-circle"></i></span>
                  @else
                    <span class="text-danger fw-bold">Hết hàng <i class="fas fa-times-circle"></i></span>
                  @endif
                </td>
              @endforeach
            </tr>

            <!-- Thao tác -->
            <tr class="action-row">
              <td class="compare-label bg-light fw-semibold">Thao tác</td>
              @foreach ($products as $product)
                <td>
                  <div class="d-grid gap-2">
                    <a href="{{ route('products.show', $product->slug) }}"
                       class="btn btn-primary btn-sm rounded-pill">
                      <i class="fas fa-eye me-1"></i> Xem chi tiết
                    </a>

                    <form action="{{ route('cart.store') }}" method="POST">
                      @csrf
                      <input type="hidden" name="variant_id" value="{{ $product->variants->first()?->id }}">
                      <input type="hidden" name="quantity" value="1">
                      <button class="btn btn-success btn-sm rounded-pill w-100"
                              {{ $product->variants->isEmpty() ? 'disabled' : '' }}>
                        <i class="fas fa-cart-plus me-1"></i> Thêm giỏ
                      </button>
                    </form>
                  </div>
                </td>
              @endforeach
            </tr>
          </tbody>
        </table>
      </div>

      <div class="text-center mt-4">
        <a href="{{ route('products.index') }}" class="btn btn-outline-secondary rounded-pill px-4 me-2">
          <i class="fas fa-arrow-left me-2"></i> Tiếp tục mua sắm
        </a>
        <form action="{{ route('compare.clear') }}" method="POST" class="d-inline">
          @csrf
          
          <button type="submit" class="btn btn-outline-danger rounded-pill px-4"
                  onclick="return confirm('Bạn có chắc muốn xóa tất cả sản phẩm so sánh?')">
            <i class="fas fa-trash-alt me-2"></i> Xóa tất cả
          </button>
        </form>
      </div>
    </div>
  @else
    <div class="empty-compare text-center py-5">
      <div class="empty-icon mb-4">
        <i class="fas fa-balance-scale fa-4x text-muted opacity-25"></i>
      </div>
      <h4 class="fw-semibold mb-3">Danh sách so sánh trống</h4>
      <p class="text-muted mb-4">Bạn cần ít nhất 2 sản phẩm để bắt đầu so sánh</p>
      <a href="{{ route('products.index') }}" class="btn btn-primary rounded-pill px-4">
        <i class="fas fa-shopping-bag me-2"></i> Khám phá sản phẩm
      </a>
    </div>
  @endif
</div>

<style>
  .compare-table {
    background-color: #fff;
    border-collapse: separate;
    border-spacing: 0;
  }

  .compare-table th, .compare-table td {
    vertical-align: middle;
    padding: 1rem;
    border-bottom: 1px solid #f1f1f1;
  }

  .compare-label {
    min-width: 180px;
    font-weight: 500;
    color: #495057;
    text-align: left !important;
    padding-left: 1.5rem !important;
  }

  .product-card {
    min-width: 280px;
    border-left: 1px solid #f1f1f1;
  }

  .product-title {
    font-size: 1.1rem;
    font-weight: 600;
    color: #333;
    min-height: 3rem;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
  }

  .highlight-difference {
    background-color: #fff8e1 !important;
    font-weight: 600;
    color: #ff6f00;
    position: relative;
  }

  .highlight-difference:after {
    content: "⚠";
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    color: #ff6f00;
  }

  .price-value {
    font-weight: 700;
    color: #d32f2f;
  }

  .rating-stars {
    font-size: 0.9rem;
    white-space: nowrap;
  }

  .empty-compare {
    max-width: 600px;
    margin: 0 auto;
    padding: 2rem;
    background: #f8f9fa;
    border-radius: 12px;
  }
</style>
@endsection

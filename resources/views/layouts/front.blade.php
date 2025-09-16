<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title','ShoeSport')</title>

  <!-- Google Font: Inter + Playfair Display -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet" />
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
  <!-- AOS CSS -->
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
  <!-- Toastr CSS -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

  <style>
    :root {
      --primary-color: #2563eb;
      --primary-hover: #1d4ed8;
      --secondary-color: #f8fafc;
      --accent-color: #f59e0b;
      --accent-hover: #e67e22;
      --text-color: #1e293b;
      --text-light: #64748b;
      --bg-color: #ffffff;
      --dark-color: #0f172a;
      --light-gray: #f1f5f9;
      --shadow-sm: 0 1px 3px rgba(0,0,0,0.08);
      --shadow-md: 0 4px 6px rgba(0,0,0,0.1);
      --shadow-lg: 0 10px 15px rgba(0,0,0,0.12);
      --shadow-xl: 0 20px 25px rgba(0,0,0,0.15);
      --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      --transition-slow: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
      --border-radius: 12px;
      --border-radius-lg: 20px;
    }

    /* ===== Base Styles ===== */
    body {
      font-family: 'Inter', sans-serif;
      display: flex;
      flex-direction: column;
      min-height: 100vh;
      background-color: var(--bg-color);
      color: var(--text-color);
      line-height: 1.7;
      font-weight: 400;
      scroll-behavior: smooth;
    }

    a {
      text-decoration: none;
      color: var(--primary-color);
      transition: var(--transition);
    }

    a:hover {
      color: var(--primary-hover);
      text-decoration: none;
    }

    .display-font {
      font-family: 'Playfair Display', serif;
      letter-spacing: -0.5px;
    }

    /* ===== Typography Enhancements ===== */
    h1, h2, h3, h4, h5, h6 {
      font-weight: 700;
      line-height: 1.3;
      margin-bottom: 1.2rem;
    }

    h1 {
      font-size: 2.5rem;
      letter-spacing: -1px;
    }

    h2 {
      font-size: 2rem;
      letter-spacing: -0.75px;
    }

    h3 {
      font-size: 1.75rem;
    }

    .text-lead {
      font-size: 1.2rem;
      color: var(--text-light);
      font-weight: 400;
    }

    /* ===== Navbar Enhancements ===== */
    .navbar {
      background: rgba(255, 255, 255, 0.98);
      box-shadow: var(--shadow-sm);
      padding: 1rem 0;
      backdrop-filter: blur(10px);
      -webkit-backdrop-filter: blur(10px);
      border-bottom: 1px solid rgba(0,0,0,0.05);
      transition: var(--transition-slow);
    }

    .navbar.scrolled {
      box-shadow: var(--shadow-md);
      padding: 0.5rem 0;
    }

    .navbar .navbar-brand {
      font-weight: 800;
      color: var(--dark-color) !important;
      font-size: 1.8rem;
      letter-spacing: -0.8px;
      transition: var(--transition);
      position: relative;
      display: inline-flex;
      align-items: center;
    }

    .navbar .navbar-brand:hover {
      transform: translateY(-2px);
    }

    .navbar .navbar-brand::after {
      content: '';
      position: absolute;
      bottom: -5px;
      left: 0;
      width: 100%;
      height: 2px;
      background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
      transform: scaleX(0);
      transform-origin: right;
      transition: transform 0.3s ease;
    }

    .navbar .navbar-brand:hover::after {
      transform: scaleX(1);
      transform-origin: left;
    }

    .navbar .nav-link {
      color: var(--text-color) !important;
      font-weight: 600;
      padding: 0.6rem 1.2rem;
      border-radius: var(--border-radius);
      position: relative;
      margin: 0 0.2rem;
      transition: var(--transition);
    }

    .navbar .nav-link::before {
      content: '';
      position: absolute;
      bottom: 0;
      left: 50%;
      transform: translateX(-50%);
      width: 0;
      height: 2px;
      background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
      transition: width 0.3s ease;
    }

    .navbar .nav-link:hover {
      color: var(--primary-color) !important;
      background: rgba(37, 99, 235, 0.05);
    }

    .navbar .nav-link:hover::before {
      width: 60%;
    }

    .navbar .nav-link.active {
      color: var(--primary-color) !important;
      font-weight: 700;
    }

    .navbar .nav-link.active::before {
      width: 60%;
      background: var(--primary-color);
    }

    /* Enhanced Search Bar */
    .search-bar {
      max-width: 360px;
      border-radius: 50px;
      padding: 0.7rem 2.5rem 0.7rem 1.2rem;
      background: var(--light-gray);
      border: 1px solid rgba(0,0,0,0.05);
      box-shadow: var(--shadow-sm);
      font-weight: 400;
      transition: var(--transition);
      background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%2394a3b8' viewBox='0 0 16 16'%3E%3Cpath d='M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z'/%3E%3C/svg%3E");
      background-repeat: no-repeat;
      background-position: right 1rem center;
      background-size: 16px 16px;
    }

    .search-bar:focus {
      box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.15);
      border-color: var(--primary-color);
      outline: none;
      background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%232563eb' viewBox='0 0 16 16'%3E%3Cpath d='M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z'/%3E%3C/svg%3E");
    }

    .search-bar::placeholder {
      color: #94a3b8;
      font-weight: 400;
    }

    /* ===== Enhanced Product Cards ===== */
    .product-card {
      border: none;
      border-radius: var(--border-radius-lg);
      overflow: hidden;
      background: var(--bg-color);
      transition: var(--transition);
      box-shadow: var(--shadow-sm);
      position: relative;
      border: 1px solid rgba(0,0,0,0.05);
      margin-bottom: 1.5rem;
    }

    .product-card:hover {
      transform: translateY(-8px);
      box-shadow: var(--shadow-lg);
      border-color: rgba(37, 99, 235, 0.2);
    }

    .card-img-top {
      object-fit: cover;
      height: 280px;
      width: 100%;
      transition: transform 0.5s ease;
    }

    .product-card:hover .card-img-top {
      transform: scale(1.05);
    }

    .card-overlay {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: linear-gradient(to bottom, rgba(0,0,0,0.1), rgba(0,0,0,0.3));
      opacity: 0;
      transition: var(--transition);
    }

    .product-card:hover .card-overlay {
      opacity: 1;
    }

    .card-badge {
      position: absolute;
      top: 15px;
      right: 15px;
      z-index: 2;
      background: linear-gradient(135deg, var(--accent-color), var(--accent-hover));
      color: white;
      padding: 0.25rem 0.75rem;
      border-radius: 50px;
      font-size: 0.75rem;
      font-weight: 700;
      box-shadow: var(--shadow-sm);
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }

    .card-body {
      padding: 1.5rem;
    }

    .card-title {
      font-weight: 700;
      margin-bottom: 0.75rem;
      font-size: 1.1rem;
    }

    .card-text {
      color: var(--text-light);
      margin-bottom: 1rem;
    }

    .product-price {
      font-weight: 800;
      color: var(--primary-color);
      font-size: 1.25rem;
    }

    .product-old-price {
      text-decoration: line-through;
      color: var(--text-light);
      font-size: 0.9rem;
      margin-left: 0.5rem;
    }

    /* ===== Enhanced Buttons ===== */
    .btn {
      font-weight: 600;
      letter-spacing: 0.5px;
      transition: var(--transition);
      position: relative;
      overflow: hidden;
    }

    .btn-primary {
      background: linear-gradient(135deg, var(--primary-color), var(--primary-hover));
      border: none;
      border-radius: var(--border-radius);
      padding: 0.8rem 2rem;
      box-shadow: var(--shadow-sm);
    }

    .btn-primary:hover {
      transform: translateY(-3px);
      box-shadow: var(--shadow-md);
      background: linear-gradient(135deg, var(--primary-hover), var(--primary-color));
    }

    .btn-primary::after {
      content: '';
      position: absolute;
      top: 50%;
      left: 50%;
      width: 5px;
      height: 5px;
      background: rgba(255, 255, 255, 0.5);
      opacity: 0;
      border-radius: 100%;
      transform: scale(1, 1) translate(-50%);
      transform-origin: 50% 50%;
    }

    .btn-primary:focus:not(:active)::after {
      animation: ripple 0.6s ease-out;
    }

    .btn-outline-primary {
      border: 2px solid var(--primary-color);
      color: var(--primary-color);
      border-radius: var(--border-radius);
      padding: 0.7rem 1.8rem;
      background: transparent;
    }

    .btn-outline-primary:hover {
      background: linear-gradient(135deg, var(--primary-color), var(--primary-hover));
      color: #fff;
      transform: translateY(-2px);
      box-shadow: var(--shadow-sm);
      border-color: transparent;
    }

    .btn-accent {
      background: linear-gradient(135deg, var(--accent-color), var(--accent-hover));
      color: white;
      border: none;
      border-radius: var(--border-radius);
      padding: 0.8rem 2rem;
      box-shadow: var(--shadow-sm);
    }

    .btn-accent:hover {
      background: linear-gradient(135deg, var(--accent-hover), var(--accent-color));
      color: white;
      transform: translateY(-3px);
      box-shadow: var(--shadow-md);
    }

    .btn-icon {
      display: inline-flex;
      align-items: center;
      justify-content: center;
    }

    .btn-icon i {
      margin-right: 0.5rem;
    }

    /* ===== Enhanced Footer ===== */
    footer {
      background: linear-gradient(135deg, var(--dark-color), #1e293b);
      padding: 4rem 0 2rem;
      font-size: 0.95rem;
      color: rgba(255,255,255,0.7);
      margin-top: 4rem;
      position: relative;
    }

    footer::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 4px;
      background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
    }

    footer h6 {
      color: white;
      font-weight: 700;
      margin-bottom: 1.5rem;
      font-size: 1.1rem;
      position: relative;
      display: inline-block;
    }

    footer h6::after {
      content: '';
      position: absolute;
      bottom: -8px;
      left: 0;
      width: 40px;
      height: 2px;
      background: var(--accent-color);
    }

    .footer-list {
      list-style: none;
      padding-left: 0;
    }

    .footer-list li {
      margin-bottom: 0.8rem;
      display: flex;
      align-items: center;
    }

    .footer-list a {
      color: rgba(255,255,255,0.7);
      transition: var(--transition);
    }

    .footer-list a:hover {
      color: white;
      transform: translateX(5px);
    }

    .footer-list i {
      width: 24px;
      text-align: center;
      margin-right: 0.5rem;
      color: var(--accent-color);
    }

    .footer-section {
      margin-bottom: 2rem;
    }

    .footer-social a {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      width: 36px;
      height: 36px;
      background: rgba(255,255,255,0.1);
      border-radius: 50%;
      color: white;
      margin-right: 0.5rem;
      transition: var(--transition);
    }

    .footer-social a:hover {
      background: var(--primary-color);
      transform: translateY(-3px);
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    /* ===== Utility Classes ===== */
    .rounded-xl {
      border-radius: var(--border-radius-lg) !important;
    }

    .text-light {
      color: var(--text-light);
    }

    .bg-light-custom {
      background: var(--secondary-color);
    }

    .text-accent {
      color: var(--accent-color);
    }

    .bg-gradient-primary {
      background: linear-gradient(135deg, var(--primary-color), #3b82f6);
    }

    .bg-gradient-accent {
      background: linear-gradient(135deg, var(--accent-color), var(--accent-hover));
    }

    /* ===== Animations ===== */
    @keyframes ripple {
      0% {
        transform: scale(0, 0);
        opacity: 1;
      }
      20% {
        transform: scale(25, 25);
        opacity: 1;
      }
      100% {
        opacity: 0;
        transform: scale(40, 40);
      }
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(10px); }
      to { opacity: 1; transform: translateY(0); }
    }

    /* ===== Section Styling ===== */
    .section {
      padding: 5rem 0;
    }

    .section-title {
      position: relative;
      margin-bottom: 3rem;
      text-align: center;
    }

    .section-title::after {
      content: '';
      position: absolute;
      bottom: -15px;
      left: 50%;
      transform: translateX(-50%);
      width: 80px;
      height: 4px;
      background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
      border-radius: 2px;
    }

    /* ===== Hero Section ===== */
    .hero-section {
      background: linear-gradient(135deg, rgba(37, 99, 235, 0.05), rgba(245, 158, 11, 0.05));
      padding: 6rem 0;
      position: relative;
      overflow: hidden;
    }

    .hero-section::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%232563eb' fill-opacity='0.05' fill-rule='evenodd'/%3E%3C/svg%3E");
      opacity: 0.5;
    }

    .hero-content {
      position: relative;
      z-index: 2;
    }

    .hero-title {
      font-size: 3rem;
      font-weight: 800;
      margin-bottom: 1.5rem;
      line-height: 1.2;
    }

    .hero-subtitle {
      font-size: 1.25rem;
      color: var(--text-light);
      margin-bottom: 2rem;
      max-width: 600px;
    }

    /* ===== Responsive Adjustments ===== */
    @media (max-width: 992px) {
      .hero-title {
        font-size: 2.5rem;
      }

      .hero-subtitle {
        font-size: 1.1rem;
      }
    }

    @media (max-width: 768px) {
      .navbar .navbar-brand {
        font-size: 1.5rem;
      }

      .search-bar {
        max-width: 100%;
        margin-bottom: 1rem;
      }

      .product-card {
        margin-bottom: 1.5rem;
      }

      footer {
        padding: 2rem 0 1rem;
      }

      .hero-title {
        font-size: 2rem;
      }

      .section {
        padding: 3rem 0;
      }
    }

    @media (max-width: 576px) {
      .hero-title {
        font-size: 1.8rem;
      }

      .hero-subtitle {
        font-size: 1rem;
      }

    }
  </style>

  @stack('styles')
</head>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Thành công',
            text: '{{ session('success') }}',
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 1800,
            timerProgressBar: true
        });
    @endif

    @if(session('warning'))
        Swal.fire({
            icon: 'warning',
            title: 'Thông báo',
            text: '{{ session('warning') }}',
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 1800,
            timerProgressBar: true
        });
    @endif
</script>

<body>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-light sticky-top" id="mainNavbar">
    <div class="container">
      <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
        <i class="bi bi-lightning-charge-fill me-2 text-accent"></i>
        <span class="display-font">ShoeSport</span>
      </a>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarNav">
        <!-- Main Menu -->
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item"><a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Trang chủ</a></li>
          <li class="nav-item"><a class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}" href="{{ route('products.index') }}">Sản phẩm</a></li>
          <li class="nav-item"><a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">Giới thiệu</a></li>
          <li class="nav-item"><a class="nav-link {{ request()->routeIs('contact.*') ? 'active' : '' }}" href="{{ route('contact.create') }}">Liên hệ</a></li>
          <li class="nav-item"><a class="nav-link {{ request()->routeIs('posts.*') ? 'active' : '' }}" href="{{ route('posts.index') }}">Blog</a></li>
        </ul>

        <!-- Search Bar -->
        <form class="d-none d-md-flex me-3 position-relative" action="{{ route('products.index') }}" method="GET" autocomplete="off">
            <input id="search" class="form-control search-bar" type="search" name="q" placeholder="Tìm sản phẩm..." value="{{ request('q') }}">
            <ul id="suggestions" class="list-group position-absolute w-100 shadow" style="top: 100%; margin-top: 8px; z-index: 999;"></ul>
        </form>

        <!-- Action Icons -->
        <ul class="navbar-nav mb-2 mb-lg-0">
          @auth
            <!-- Orders -->
            <li class="nav-item me-2">
              <a class="nav-link position-relative p-2 rounded-circle d-flex align-items-center justify-content-center"
                 href="{{ route('orders.index') }}"
                 style="width: 40px; height: 40px;"
                 data-bs-toggle="tooltip" data-bs-placement="bottom" title="Đơn hàng">
                <i class="bi bi-list-check fs-5"></i>
              </a>
            </li>

            <!-- Wishlist -->
            <li class="nav-item me-2">
              <a class="nav-link position-relative p-2 rounded-circle d-flex align-items-center justify-content-center"
                 href="{{ route('wishlist.index') }}"
                 style="width: 40px; height: 40px;"
                 data-bs-toggle="tooltip" data-bs-placement="bottom" title="Yêu thích">
                <i class="bi bi-heart fs-5"></i>
                @php $wishCount = auth()->user()->wishlists()->count() @endphp
                @if($wishCount)
                  <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.6rem;">
                    {{ $wishCount }}
                  </span>
                @endif
              </a>
            </li>
          @endauth

          <!-- Cart -->
          <li class="nav-item me-2">
            <a class="nav-link position-relative p-2 rounded-circle d-flex align-items-center justify-content-center"
               href="{{ route('cart.index') }}"
               style="width: 40px; height: 40px;"
               data-bs-toggle="tooltip" data-bs-placement="bottom" title="Giỏ hàng">
              <i class="bi bi-cart3 fs-5"></i>
              @if(session('cart') && count(session('cart')))
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.6rem;">
                  {{ count(session('cart')) }}
                </span>
              @endif
            </a>
          </li>
          <!-- Compare -->
<li class="nav-item me-2">
  <a class="nav-link position-relative p-2 rounded-circle d-flex align-items-center justify-content-center"
     href="{{ route('compare.index') }}"
     style="width: 40px; height: 40px;"
     data-bs-toggle="tooltip" data-bs-placement="bottom" title="So sánh sản phẩm">
    <i class="bi bi-bar-chart-line fs-5"></i>
    @if(session('compare') && count(session('compare')))
      <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.6rem;">
        {{ count(session('compare')) }}
      </span>
    @endif
  </a>
</li>


          <!-- Auth Links -->
          @guest
            <li class="nav-item ms-2">
              <a class="btn btn-outline-primary rounded-pill px-3" href="{{ route('login') }}">Đăng nhập</a>
            </li>
            <li class="nav-item ms-2 d-none d-lg-block">
              <a class="btn btn-primary rounded-pill px-3" href="{{ route('register') }}">Đăng ký</a>
            </li>
          @else
            <li class="nav-item dropdown ms-2">
              <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown">
                <div class="me-2 d-none d-md-block text-end">
                  <div class="fw-medium">{{ auth()->user()->name }}</div>
                  <div class="small text-muted" style="font-size: 0.7rem;">Tài khoản</div>
                </div>
                <div class="rounded-circle bg-gradient-primary d-flex align-items-center justify-content-center"
                     style="width: 40px; height: 40px; color: white;">
                  <i class="bi bi-person-fill"></i>
                </div>
              </a>
              <ul class="dropdown-menu dropdown-menu-end">
                <li><h6 class="dropdown-header">Xin chào, {{ auth()->user()->name }}</h6></li>
                <li>
                  <a class="dropdown-item d-flex align-items-center" href="{{ route('front.profile.edit') }}">
                    <i class="bi bi-person-circle me-2"></i> Hồ sơ của tôi
                  </a>
                </li>
                <li><a class="dropdown-item d-flex align-items-center" href="{{ route('orders.index') }}"><i class="bi bi-list-check me-2"></i> Đơn hàng của tôi</a></li>
                <li><a class="dropdown-item d-flex align-items-center" href="{{ route('wishlist.index') }}"><i class="bi bi-heart me-2"></i> Danh sách yêu thích</a></li>
                <li><a class="dropdown-item d-flex align-items-center" href="{{ route('contacts.index') }}"><i class="bi bi-envelope-fill me-2"></i> Liên hệ của tôi</a></li>
                <li><hr class="dropdown-divider"></li>
                <li>
                  <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="dropdown-item d-flex align-items-center">
                      <i class="bi bi-box-arrow-right me-2"></i> Đăng xuất
                    </button>
                  </form>
                </li>
              </ul>
            </li>
          @endguest
        </ul>
      </div>
    </div>
  </nav>

  <!-- Main Content -->
  <main class="flex-grow-1">
    @yield('content')
  </main>

  <!-- Footer -->
  <footer>
    <div class="container">
      <div class="row">
        <div class="col-lg-4 col-md-6 footer-section">
          <h6><i class="bi bi-headset me-2"></i> Tổng đài hỗ trợ</h6>
          <ul class="footer-list">
            <li><i class="bi bi-telephone me-2"></i> Gọi mua: <a href="tel:1900232460">1900 232 460</a></li>
            <li><i class="bi bi-chat-dots me-2"></i> Khiếu nại: <a href="tel:18001062">1800 1062</a></li>
            <li><i class="bi bi-shield-check me-2"></i> Bảo hành: <a href="tel:1900232464">1900 232 464</a></li>
          </ul>
        </div>

        <div class="col-lg-4 col-md-6 footer-section">
          <h6><i class="bi bi-building me-2"></i> Về công ty</h6>
          <ul class="footer-list">
            <li><a href="{{ route('about') }}"><i class="bi bi-info-circle me-2"></i> Giới thiệu công ty</a></li>
            <li><a href="{{ route('careers') }}"><i class="bi bi-person-plus me-2"></i> Tuyển dụng</a></li>
            <li><a href="{{ route('contact.create') }}"><i class="bi bi-envelope me-2"></i> Góp ý & khiếu nại</a></li>
            <li><a href="https://www.google.com/maps/search/?api=1&query=256+Nguyễn+Văn+Cừ,+Quận+Ninh+Kiều,+Cần+Thơ,+Việt+Nam" target="_blank" rel="noopener"><i class="bi bi-geo-alt me-2"></i> Tìm cửa hàng</a></li>
          </ul>
        </div>

        <div class="col-lg-4 col-md-6 footer-section">
          <h6><i class="bi bi-info-circle me-2"></i> Thông tin khác</h6>
          <ul class="footer-list">
            <li><a href="{{ route('orders.index') }}"><i class="bi bi-receipt me-2"></i> Lịch sử mua hàng</a></li>
            <li><a href="{{ route('orders.track') }}"><i class="fas fa-search"></i> Tra cứu đơn hàng</a></li>
            <li><a href="{{ route('policy.warranty') }}"><i class="bi bi-shield-lock me-2"></i> Chính sách bảo hành</a></li>
            <li><a href="#"><i class="bi bi-chevron-right me-2"></i> Xem thêm</a></li>
          </ul>

          <h6 class="mt-4"><i class="bi bi-envelope me-2"></i> Đăng ký nhận tin</h6>
<form action="{{ route('newsletter.subscribe') }}" method="POST" class="input-group mb-3">
  @csrf
  <input type="email" name="email" class="form-control" placeholder="Email của bạn"
         style="background: rgba(255,255,255,0.1); border-color: rgba(255,255,255,0.2); color: white;">
  <button class="btn btn-accent" type="submit">Gửi</button>
</form>

@if ($errors->has('email'))
  <div class="text-danger small mt-1">{{ $errors->first('email') }}</div>
@endif

@if (session('success'))
  <script>
    Swal.fire({
      icon: 'success',
      title: 'Đã đăng ký',
      text: '{{ session('success') }}',
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 2000
    });
  </script>
@endif


        </div>
      </div>

      <hr class="my-4" style="border-color: rgba(255,255,255,0.1);">

      <div class="row align-items-center">
        <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
          <div class="footer-social">
            <a href="#"><i class="bi bi-facebook"></i></a>
            <a href="#"><i class="bi bi-instagram"></i></a>
            <a href="#"><i class="bi bi-youtube"></i></a>
            <a href="#"><i class="bi bi-tiktok"></i></a>
          </div>
        </div>

        <div class="col-md-6 text-center text-md-end d-flex justify-content-md-end justify-content-center flex-wrap gap-3">
  <i class="fab fa-cc-visa fa-2x text-white" title="Visa"></i>
  <i class="fab fa-cc-mastercard fa-2x text-white" title="MasterCard"></i>
  <i class="fas fa-money-bill-wave fa-2x text-white" title="Thanh toán khi nhận (COD)"></i>
  <i class="fas fa-university fa-2x text-white" title="Chuyển khoản ngân hàng"></i>
</div>



        <div class="col-12 text-center mt-3">
          © {{ date('Y') }} <strong>ShoeSport</strong>. All rights reserved.
        </div>
      </div>
    </div>
  </footer>

  <!-- Back to Top Button -->
  <a href="#" class="btn btn-primary btn-floating position-fixed bottom-3 end-3 rounded-circle d-flex align-items-center justify-content-center"
     style="width: 50px; height: 50px; z-index: 99; display: none;" id="backToTop">
    <i class="bi bi-arrow-up"></i>
  </a>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
  <script>AOS.init({ duration: 800, once: true });</script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
  <script>
    @if(session('success'))
      toastr.success("{{ session('success') }}", '', {
        positionClass: "toast-bottom-right",
        progressBar: true,
        timeOut: 3000
      });
    @endif
    @if(session('error'))
      toastr.error("{{ session('error') }}", '', {
        positionClass: "toast-bottom-right",
        progressBar: true,
        timeOut: 3000
      });
    @endif

    // Navbar scroll effect
    window.addEventListener('scroll', function() {
      const navbar = document.getElementById('mainNavbar');
      if (window.scrollY > 50) {
        navbar.classList.add('scrolled');
      } else {
        navbar.classList.remove('scrolled');
      }
    });

    // Back to top button
    const backToTopButton = document.getElementById('backToTop');
    window.addEventListener('scroll', function() {
      if (window.scrollY > 300) {
        backToTopButton.style.display = 'flex';
      } else {
        backToTopButton.style.display = 'none';
      }
    });

    backToTopButton.addEventListener('click', function(e) {
      e.preventDefault();
      window.scrollTo({top: 0, behavior: 'smooth'});
    });

    // Initialize tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl);
    });
  </script>

  <script>
document.addEventListener('DOMContentLoaded', function () {
  const searchInput = document.getElementById('search');
  const suggestionList = document.getElementById('suggestions');

  if (!searchInput || !suggestionList) return;

  searchInput.addEventListener('input', function () {
    const query = this.value.trim();
    if (query.length < 2) {
      suggestionList.innerHTML = '';
      return;
    }

    fetch(`/products-autocomplete?query=${encodeURIComponent(query)}`)
      .then(res => res.json())
      .then(products => {
        suggestionList.innerHTML = '';

        if (!products.length) return;

        products.forEach(product => {
          const li = document.createElement('li');
          li.classList.add('list-group-item', 'd-flex', 'align-items-center');
          li.style.cursor = 'pointer';

          li.innerHTML = `
            <img src="${product.image}" alt="${product.name}" class="me-2" style="width: 40px; height: 40px; object-fit: cover; border-radius: 6px;">
            <div>
              <div class="fw-semibold">${product.name}</div>
              <div class="text-muted small">${product.price}</div>
            </div>
          `;

          li.addEventListener('click', function () {
            window.location.href = `/products/${product.slug}`;
          });

          suggestionList.appendChild(li);
        });
      });
  });

  document.addEventListener('click', function (e) {
    if (!searchInput.contains(e.target) && !suggestionList.contains(e.target)) {
      suggestionList.innerHTML = '';
    }
  });
});
</script>


  @stack('scripts')
</body>
</html>

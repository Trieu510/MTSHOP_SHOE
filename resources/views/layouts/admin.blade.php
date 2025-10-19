<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #6366f1;
            --primary-hover: #4f46e5;
            --sidebar-bg: #1e1e2d;
            --sidebar-text: #a1a5b7;
            --sidebar-active: #2d2d42;
            --content-bg: #f8f9fa;
            --card-bg: #ffffff;
            --text-dark: #3f4254;
            --text-light: #b5b5c3;
            --border-radius: 0.475rem;
            --box-shadow: 0 0 20px rgba(0,0,0,0.05);
        }

        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background-color: var(--content-bg);
            color: var(--text-dark);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* Sidebar styling */
        .sidebar {
            width: 265px;
            background: var(--sidebar-bg);
            color: var(--sidebar-text);
            min-height: 100vh;
            transition: all 0.3s ease;
            border-right: 1px solid rgba(255,255,255,0.05);
            box-shadow: var(--box-shadow);
            z-index: 1050;
        }

        .sidebar a {
            color: var(--sidebar-text);
            text-decoration: none;
            transition: all 0.2s;
            font-weight: 500;
        }

        .sidebar a:hover {
            color: #fff;
            background-color: var(--sidebar-active);
            border-radius: var(--border-radius);
        }

        .sidebar .nav-link.active {
            background-color: var(--primary-color);
            color: #fff;
            border-radius: var(--border-radius);
        }

        .sidebar .nav-link {
            padding: 0.75rem 1.5rem;
            margin: 0.15rem 1rem;
            display: flex;
            align-items: center;
        }

        .sidebar .nav-link i {
            font-size: 1.1rem;
            margin-right: 0.75rem;
            width: 24px;
            text-align: center;
        }

        .sidebar-header {
            padding: 1.5rem 1.5rem 1rem;
            border-bottom: 1px solid rgba(255,255,255,0.05);
        }

        .sidebar-header h4 {
            color: #fff;
            font-weight: 700;
            font-size: 1.3rem;
        }

        /* Content area */
        .content {
            flex: 1;
            padding: 2rem 2.5rem;
            margin-left: 265px;
            transition: all 0.3s ease;
        }

        /* Navbar styling */
        .navbar {
            background-color: var(--card-bg);
            box-shadow: var(--box-shadow);
            border-radius: var(--border-radius);
            padding: 1rem 1.5rem;
        }

        .navbar .nav-link {
            color: var(--text-dark);
            font-weight: 500;
        }

        .navbar .nav-link:hover {
            color: var(--primary-color);
        }

        .dropdown-menu {
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            border: none;
            padding: 0.5rem 0;
            transition: all 0.2s ease;
        }

        .dropdown-item {
            padding: 0.5rem 1.5rem;
            font-weight: 500;
            transition: all 0.2s;
        }

        .dropdown-item:hover {
            background-color: var(--primary-color);
            color: white;
        }

        /* Footer */
        footer {
            margin-top: auto;
            padding: 1.5rem;
            text-align: center;
            color: var(--text-light);
            font-size: 0.875rem;
        }

        /* Offcanvas sidebar for mobile */
        .offcanvas-start {
            width: 265px;
            background: var(--sidebar-bg);
            color: var(--sidebar-text);
        }

        .offcanvas-header {
            border-bottom: 1px solid rgba(255,255,255,0.05);
        }

        .offcanvas-title {
            color: #fff;
            font-weight: 700;
        }

        /* Sidebar overlay for mobile */
        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0,0,0,0.5);
            z-index: 1040;
            display: none;
            transition: all 0.3s ease;
        }

        /* Responsive adjustments */
        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(-265px);
                position: fixed;
                height: 100vh;
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .content {
                margin-left: 0;
            }
        }

        /* Toggle button */
        .sidebar-toggle {
            background-color: var(--primary-color);
            color: white;
            border: none;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: all 0.3s;
        }

        .sidebar-toggle:hover {
            background-color: var(--primary-hover);
        }

        /* Loading indicator */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(255,255,255,0.8);
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            display: none;
        }

        .spinner {
            width: 3rem;
            height: 3rem;
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: var(--primary-color);
            border-radius: 3px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--primary-hover);
        }

        /* Tooltip styling */
        [data-bs-toggle="tooltip"] {
            cursor: pointer;
        }

        .sidebar-menu-scroll {
            max-height: calc(100vh - 80px);
            overflow-y: auto;
            padding-right: 6px;
        }

        /* Menu group styling */
        .menu-group {
            margin-bottom: 0.5rem;
        }

        .menu-group-title {
            color: var(--sidebar-text);
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: all 0.2s;
        }

        .menu-group-title:hover {
            color: #fff;
            background-color: rgba(255,255,255,0.05);
        }

        .menu-group-title i {
            transition: transform 0.2s;
        }

        .menu-group-title.collapsed i {
            transform: rotate(-90deg);
        }

        .menu-group-items {
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .menu-group-items.collapsed {
            max-height: 0 !important;
        }
    </style>
</head>
<body>
    <!-- Loading overlay -->
    <div class="loading-overlay">
        <div class="spinner-border text-primary spinner" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <!-- Sidebar overlay for mobile -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Main sidebar -->
    <div class="sidebar position-fixed" id="sidebar">
        <div class="sidebar-header">
            <h4 class="mb-0">ShoeSport Admin</h4>
        </div>

        <div class="p-3 sidebar-menu-scroll" id="sidebarMenu">
            <!-- Dashboard -->
            <ul class="nav nav-pills flex-column">
                <li class="nav-item mb-2">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" data-bs-toggle="tooltip" data-bs-placement="right" title="Dashboard">
                        <i class="bi bi-speedometer2"></i> Dashboard
                    </a>
                </li>
            </ul>

            <!-- Nhóm 1: Quản lý sản phẩm -->
            <div class="menu-group">
                <div class="menu-group-title" data-bs-toggle="collapse" href="#productManagement" role="button">
                    <span>QUẢN LÝ SẢN PHẨM</span>
                    <i class="bi bi-chevron-down"></i>
                </div>
                <div class="menu-group-items collapse show" id="productManagement">
                    <ul class="nav nav-pills flex-column">
                        <li class="nav-item mb-2">
                            <a href="{{ route('admin.categories.index') }}" class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}" data-bs-toggle="tooltip" data-bs-placement="right" title="Quản lý danh mục">
                                <i class="bi bi-tags-fill"></i> Danh mục
                            </a>
                        </li>
                        <li class="nav-item mb-2">
                            <a href="{{ route('admin.products.index') }}" class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}" data-bs-toggle="tooltip" data-bs-placement="right" title="Quản lý sản phẩm">
                                <i class="bi bi-box-seam"></i> Sản phẩm
                            </a>
                        </li>
                        <li class="nav-item mb-2">
                            <a href="{{ route('admin.inventory.index') }}" class="nav-link {{ request()->routeIs('admin.inventory.index') ? 'active' : '' }}" data-bs-toggle="tooltip" title="Quản lý tồn kho">
                                <i class="bi bi-boxes"></i> Tồn kho
                            </a>
                        </li>
                        <li class="nav-item mb-2">
                            <a href="{{ route('admin.inventory.logs') }}" class="nav-link {{ request()->routeIs('admin.inventory.logs') ? 'active' : '' }}" data-bs-toggle="tooltip" title="Lịch sử nhập kho">
                                <i class="bi bi-clock-history"></i> Lịch sử nhập kho
                            </a>
                        </li>
                        <li class="nav-item mb-2">
                            <a href="{{ route('admin.flash-sales.index') }}" class="nav-link {{ request()->routeIs('admin.flash-sales.*') ? 'active' : '' }}" data-bs-toggle="tooltip" data-bs-placement="right" title="Quản lý Flash Sale">
                                <i class="bi bi-lightning-fill"></i> Flash Sale
                            </a>
                        </li>
                        <li class="nav-item mb-2">
                            <a href="{{ route('admin.coupons.index') }}" class="nav-link {{ request()->routeIs('admin.coupons.*') ? 'active' : '' }}" data-bs-toggle="tooltip" data-bs-placement="right" title="Quản lý mã giảm giá">
                                <i class="bi bi-gift-fill"></i> Mã giảm giá
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Nhóm 2: Đơn hàng -->
            <div class="menu-group">
                <div class="menu-group-title" data-bs-toggle="collapse" href="#orderManagement" role="button">
                    <span>ĐƠN HÀNG</span>
                    <i class="bi bi-chevron-down"></i>
                </div>
                <div class="menu-group-items collapse show" id="orderManagement">
                    <ul class="nav nav-pills flex-column">
                        <li class="nav-item mb-2">
                            <a href="{{ route('admin.orders.index') }}" class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}" data-bs-toggle="tooltip" data-bs-placement="right" title="Quản lý đơn hàng">
                                <i class="bi bi-cart-check-fill"></i> Đơn hàng
                            </a>
                        </li>
                        <li class="nav-item mb-2">
                            <a href="{{ route('admin.returns.index') }}" class="nav-link {{ request()->routeIs('admin.returns.*') ? 'active' : '' }}" data-bs-toggle="tooltip" data-bs-placement="right" title="Quản lý trả hàng">
                                <i class="bi bi-arrow-return-left"></i> Trả hàng
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Nhóm 3: Khách hàng & Đánh giá -->
            <div class="menu-group">
                <div class="menu-group-title" data-bs-toggle="collapse" href="#customerManagement" role="button">
                    <span>KHÁCH HÀNG & ĐÁNH GIÁ</span>
                    <i class="bi bi-chevron-down"></i>
                </div>
                <div class="menu-group-items collapse show" id="customerManagement">
                    <ul class="nav nav-pills flex-column">
                        <li class="nav-item mb-2">
                            <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" data-bs-toggle="tooltip" data-bs-placement="right" title="Quản lý khách hàng">
                                <i class="bi bi-people-fill"></i> Khách hàng
                            </a>
                        </li>
                        <li class="nav-item mb-2">
                            <a href="{{ route('admin.reviews.index') }}" class="nav-link {{ request()->routeIs('admin.reviews.*') ? 'active' : '' }}" data-bs-toggle="tooltip" data-bs-placement="right" title="Quản lý đánh giá">
                                <i class="bi bi-star-fill"></i> Đánh giá
                            </a>
                        </li>
                        <li class="nav-item mb-2">
                            <a href="{{ route('admin.contacts.index') }}" class="nav-link {{ request()->routeIs('admin.contacts.*') ? 'active' : '' }}" data-bs-toggle="tooltip" data-bs-placement="right" title="Quản lý liên hệ">
                                <i class="bi bi-envelope-fill"></i> Liên hệ
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Nhóm 4: Marketing & Nội dung -->
            <div class="menu-group">
                <div class="menu-group-title" data-bs-toggle="collapse" href="#marketingManagement" role="button">
                    <span>MARKETING & NỘI DUNG</span>
                    <i class="bi bi-chevron-down"></i>
                </div>
                <div class="menu-group-items collapse show" id="marketingManagement">
                    <ul class="nav nav-pills flex-column">
                        <li class="nav-item mb-2">
                            <a href="{{ route('admin.banners.index') }}" class="nav-link {{ request()->routeIs('admin.banners.*') ? 'active' : '' }}" data-bs-toggle="tooltip" data-bs-placement="right" title="Quản lý banner">
                                <i class="bi bi-card-image"></i> Banner
                            </a>
                        </li>
                        <li class="nav-item mb-2">
                            <a href="{{ route('admin.posts.index') }}" class="nav-link {{ request()->routeIs('admin.posts.*') ? 'active' : '' }}" data-bs-toggle="tooltip" data-bs-placement="right" title="Quản lý bài viết">
                                <i class="bi bi-journal-text"></i> Bài viết
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Nhóm 5: Cấu hình & Báo cáo -->
            <div class="menu-group">
                <div class="menu-group-title" data-bs-toggle="collapse" href="#configManagement" role="button">
                    <span>CẤU HÌNH & BÁO CÁO</span>
                    <i class="bi bi-chevron-down"></i>
                </div>
                <div class="menu-group-items collapse show" id="configManagement">
                    <ul class="nav nav-pills flex-column">
                        <li class="nav-item mb-2">
                            <a href="{{ route('admin.shipping_fees.index') }}" class="nav-link {{ request()->routeIs('admin.shipping_fees.*') ? 'active' : '' }}" data-bs-toggle="tooltip" data-bs-placement="right" title="Quản lý phí vận chuyển">
                                <i class="bi bi-truck"></i> Phí vận chuyển
                            </a>
                        </li>
                        <li class="nav-item mb-2">
                            <a href="{{ route('admin.reports.sales') }}" class="nav-link {{ request()->routeIs('admin.reports.sales') ? 'active' : '' }}" data-bs-toggle="tooltip" data-bs-placement="right" title="Báo cáo doanh thu">
                                <i class="bi bi-graph-up-arrow"></i> Doanh thu
                            </a>
                        </li>
                        <li class="nav-item mb-2">
                            <a href="{{ route('admin.reports.orders') }}" class="nav-link {{ request()->routeIs('admin.reports.orders') ? 'active' : '' }}" data-bs-toggle="tooltip" data-bs-placement="right" title="Báo cáo đơn hàng">
                                <i class="bi bi-file-earmark-text-fill"></i> Đơn hàng
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <nav class="navbar navbar-expand navbar-light bg-white mb-4">
            <div class="container-fluid">
                <button class="sidebar-toggle me-3" type="button" id="sidebarToggle">
                    <i class="bi bi-list"></i>
                </button>
                <div class="collapse navbar-collapse">
                    <ul class="navbar-nav ms-auto">
                        @php
                            $unreadNotifications = auth()->user()->unreadNotifications ?? collect();
                        @endphp
                        <!-- 🔹 Icon Chat riêng cho Admin -->
<li class="nav-item me-3">
    <a href="{{ route('admin.chat.index') }}" class="nav-link position-relative" title="Tin nhắn hỗ trợ">
        <i class="bi bi-chat-dots fs-5"></i>
        <span id="admin-chat-badge"
              class="position-absolute top-0 start-100 translate-middle bg-danger rounded-circle"
              style="width: 10px; height: 10px; display: none;">
        </span>
    </a>
</li>

                        <li class="nav-item dropdown me-3">
                            <a class="nav-link position-relative" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-bell fs-5"></i>
                                @if($unreadNotifications->count())
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                        {{ $unreadNotifications->count() }}
                                    </span>
                                @endif
                            </a>

                            <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                                @forelse ($unreadNotifications as $notification)
                                    @php $type = class_basename($notification->type); @endphp

                                    @if ($type === 'NewOrderNotification' || $type === 'OrderStatusUpdated')
                                        <li>
                                            <a class="dropdown-item notification-link" href="{{ route('admin.orders.show', $notification->data['order_id']) }}"
                                               onclick="markNotificationRead('{{ $notification->id }}')">
                                                🛒 {{ $notification->data['title'] ?? 'Thông báo mới' }}<br>
                                                <small>Mã đơn hàng: #{{ $notification->data['order_id'] ?? '---' }}</small>
                                            </a>
                                        </li>
                                    @elseif ($type === 'NewReturnRequestNotification')
                                        <li>
                                            <a class="dropdown-item notification-link"
                                               href="{{ route('admin.returns.edit', $notification->data['return_request_id']) }}"
                                               onclick="markNotificationRead('{{ $notification->id }}')">
                                                🔁 {{ $notification->data['title'] ?? 'Yêu cầu hoàn trả' }}<br>
                                                <small>Mã đơn hàng: #{{ $notification->data['order_id'] ?? '---' }}</small>
                                            </a>
                                        </li>
                                    @endif
                                @empty
                                    <li><span class="dropdown-item text-muted">Không có thông báo mới</span></li>
                                @endforelse
                            </ul>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown">
                                <div class="symbol symbol-35px symbol-circle me-2">
                                    <span class="symbol-label bg-light-primary text-primary fw-bold fs-6">
                                        {{ substr(auth()->user()->name, 0, 1) }}
                                    </span>
                                </div>
                                <span class="fw-semibold">{{ auth()->user()->name }}</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <form method="POST" action="{{ route('logout') }}" id="logoutForm">
                                        @csrf
                                        <button type="submit" class="dropdown-item d-flex align-items-center">
                                            <i class="bi bi-box-arrow-right me-2"></i> Đăng xuất
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        @yield('content')

        <footer class="mt-5">
            © {{ date('Y') }} ShoeSport Admin. All rights reserved.
        </footer>
    </div>

    <!-- Offcanvas sidebar for mobile -->
    <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasSidebar">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title">ShoeSport Admin</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body p-0">
            <div class="p-3 sidebar-menu-scroll">
                <!-- Dashboard -->
                <ul class="nav nav-pills flex-column">
                    <li class="nav-item mb-2">
                        <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <i class="bi bi-speedometer2 me-2"></i> Dashboard
                        </a>
                    </li>
                </ul>

                <!-- Nhóm 1: Quản lý sản phẩm -->
                <div class="menu-group">
                    <div class="menu-group-title" data-bs-toggle="collapse" href="#offcanvasProductManagement" role="button">
                        <span>QUẢN LÝ SẢN PHẨM</span>
                        <i class="bi bi-chevron-down"></i>
                    </div>
                    <div class="menu-group-items collapse show" id="offcanvasProductManagement">
                        <ul class="nav nav-pills flex-column">
                            <li class="nav-item mb-2">
                                <a href="{{ route('admin.categories.index') }}" class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                                    <i class="bi bi-tags-fill me-2"></i> Danh mục
                                </a>
                            </li>
                            <li class="nav-item mb-2">
                                <a href="{{ route('admin.products.index') }}" class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                                    <i class="bi bi-box-seam me-2"></i> Sản phẩm
                                </a>
                            </li>
                            <li class="nav-item mb-2">
                                <a href="{{ route('admin.inventory.index') }}" class="nav-link {{ request()->routeIs('admin.inventory.index') ? 'active' : '' }}">
                                    <i class="bi bi-boxes me-2"></i> Tồn kho
                                </a>
                            </li>
                            <li class="nav-item mb-2">
                                <a href="{{ route('admin.inventory.logs') }}" class="nav-link {{ request()->routeIs('admin.inventory.logs') ? 'active' : '' }}">
                                    <i class="bi bi-clock-history me-2"></i> Lịch sử nhập kho
                                </a>
                            </li>
                            <li class="nav-item mb-2">
                                <a href="{{ route('admin.flash-sales.index') }}" class="nav-link {{ request()->routeIs('admin.flash-sales.*') ? 'active' : '' }}">
                                    <i class="bi bi-lightning-fill me-2"></i> Flash Sale
                                </a>
                            </li>
                            <li class="nav-item mb-2">
                                <a href="{{ route('admin.coupons.index') }}" class="nav-link {{ request()->routeIs('admin.coupons.*') ? 'active' : '' }}">
                                    <i class="bi bi-gift-fill me-2"></i> Mã giảm giá
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Nhóm 2: Đơn hàng -->
                <div class="menu-group">
                    <div class="menu-group-title" data-bs-toggle="collapse" href="#offcanvasOrderManagement" role="button">
                        <span>ĐƠN HÀNG</span>
                        <i class="bi bi-chevron-down"></i>
                    </div>
                    <div class="menu-group-items collapse show" id="offcanvasOrderManagement">
                        <ul class="nav nav-pills flex-column">
                            <li class="nav-item mb-2">
                                <a href="{{ route('admin.orders.index') }}" class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                                    <i class="bi bi-cart-check-fill me-2"></i> Đơn hàng
                                </a>
                            </li>
                            <li class="nav-item mb-2">
                                <a href="{{ route('admin.returns.index') }}" class="nav-link {{ request()->routeIs('admin.returns.*') ? 'active' : '' }}">
                                    <i class="bi bi-arrow-return-left me-2"></i> Trả hàng
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Nhóm 3: Khách hàng & Đánh giá -->
                <div class="menu-group">
                    <div class="menu-group-title" data-bs-toggle="collapse" href="#offcanvasCustomerManagement" role="button">
                        <span>KHÁCH HÀNG & ĐÁNH GIÁ</span>
                        <i class="bi bi-chevron-down"></i>
                    </div>
                    <div class="menu-group-items collapse show" id="offcanvasCustomerManagement">
                        <ul class="nav nav-pills flex-column">
                            <li class="nav-item mb-2">
                                <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                                    <i class="bi bi-people-fill me-2"></i> Khách hàng
                                </a>
                            </li>
                            <li class="nav-item mb-2">
                                <a href="{{ route('admin.reviews.index') }}" class="nav-link {{ request()->routeIs('admin.reviews.*') ? 'active' : '' }}">
                                    <i class="bi bi-star-fill me-2"></i> Đánh giá
                                </a>
                            </li>
                            <li class="nav-item mb-2">
                                <a href="{{ route('admin.contacts.index') }}" class="nav-link {{ request()->routeIs('admin.contacts.*') ? 'active' : '' }}">
                                    <i class="bi bi-envelope-fill me-2"></i> Liên hệ
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Nhóm 4: Marketing & Nội dung -->
                <div class="menu-group">
                    <div class="menu-group-title" data-bs-toggle="collapse" href="#offcanvasMarketingManagement" role="button">
                        <span>MARKETING & NỘI DUNG</span>
                        <i class="bi bi-chevron-down"></i>
                    </div>
                    <div class="menu-group-items collapse show" id="offcanvasMarketingManagement">
                        <ul class="nav nav-pills flex-column">
                            <li class="nav-item mb-2">
                                <a href="{{ route('admin.banners.index') }}" class="nav-link {{ request()->routeIs('admin.banners.*') ? 'active' : '' }}">
                                    <i class="bi bi-card-image me-2"></i> Banner
                                </a>
                            </li>
                            <li class="nav-item mb-2">
                                <a href="{{ route('admin.posts.index') }}" class="nav-link {{ request()->routeIs('admin.posts.*') ? 'active' : '' }}">
                                    <i class="bi bi-journal-text me-2"></i> Bài viết
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Nhóm 5: Cấu hình & Báo cáo -->
                <div class="menu-group">
                    <div class="menu-group-title" data-bs-toggle="collapse" href="#offcanvasConfigManagement" role="button">
                        <span>CẤU HÌNH & BÁO CÁO</span>
                        <i class="bi bi-chevron-down"></i>
                    </div>
                    <div class="menu-group-items collapse show" id="offcanvasConfigManagement">
                        <ul class="nav nav-pills flex-column">
                            <li class="nav-item mb-2">
                                <a href="{{ route('admin.shipping_fees.index') }}" class="nav-link {{ request()->routeIs('admin.shipping_fees.*') ? 'active' : '' }}">
                                    <i class="bi bi-truck me-2"></i> Phí vận chuyển
                                </a>
                            </li>
                            <li class="nav-item mb-2">
                                <a href="{{ route('admin.reports.sales') }}" class="nav-link {{ request()->routeIs('admin.reports.sales') ? 'active' : '' }}">
                                    <i class="bi bi-graph-up-arrow me-2"></i> Doanh thu
                                </a>
                            </li>
                            <li class="nav-item mb-2">
                                <a href="{{ route('admin.reports.orders') }}" class="nav-link {{ request()->routeIs('admin.reports.orders') ? 'active' : '' }}">
                                    <i class="bi bi-file-earmark-text-fill me-2"></i> Đơn hàng
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Toggle sidebar on mobile
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('active');
            document.getElementById('sidebarOverlay').style.display = sidebar.classList.contains('active') ? 'block' : 'none';
        });

        // Close sidebar when clicking overlay
        document.getElementById('sidebarOverlay').addEventListener('click', function() {
            document.getElementById('sidebar').classList.remove('active');
            this.style.display = 'none';
        });

        // Initialize tooltips
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Handle window resize
        function handleResize() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');

            if (window.innerWidth > 992) {
                sidebar.classList.remove('active');
                overlay.style.display = 'none';
            }
        }

        window.addEventListener('resize', handleResize);

        // Show loading indicator when navigating
        document.querySelectorAll('a').forEach(link => {
            if (link.href && !link.href.startsWith('javascript:') && !link.hasAttribute('data-bs-toggle')) {
                link.addEventListener('click', function() {
                    document.querySelector('.loading-overlay').style.display = 'flex';
                });
            }
        });

        // Handle logout form submission
        document.getElementById('logoutForm').addEventListener('submit', function() {
            document.querySelector('.loading-overlay').style.display = 'flex';
        });

        function markNotificationRead(id) {
            fetch("/admin/notifications/" + id + "/read", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Accept": "application/json",
                }
            });
        }

        // Lưu trạng thái mở/đóng của các nhóm menu
        document.querySelectorAll('.menu-group-title').forEach(title => {
            title.addEventListener('click', function() {
                const targetId = this.getAttribute('href');
                const target = document.querySelector(targetId);
                const isCollapsed = target.classList.contains('show');

                // Lưu trạng thái vào localStorage
                localStorage.setItem(targetId, isCollapsed ? 'collapsed' : 'expanded');
            });

            // Khôi phục trạng thái từ localStorage khi tải trang
            const targetId = title.getAttribute('href');
            const savedState = localStorage.getItem(targetId);
            if (savedState === 'collapsed') {
                const target = document.querySelector(targetId);
                const collapseInstance = bootstrap.Collapse.getInstance(target) || new bootstrap.Collapse(target, {toggle: false});
                collapseInstance.hide();
            }
        });
    </script>
<!-- 🔹 Kiểm tra tin nhắn chưa đọc và hiển thị chấm đỏ -->
<script>
document.addEventListener("DOMContentLoaded", function () {
    const badge = document.getElementById("admin-chat-badge");
    if (!badge) return;

    const isChatPage = window.location.pathname.includes("/admin/chats");

    function checkUnreadMessages() {
        fetch("{{ route('chat.unread') }}")
            .then(res => res.json())
            .then(data => {
                if (isChatPage) {
                    badge.style.display = "none";
                    return;
                }
                if (data.count > 0) {
                    badge.style.display = "inline-block";
                } else {
                    badge.style.display = "none";
                }
            })
            .catch(err => console.error("Lỗi khi kiểm tra tin nhắn:", err));
    }

    // Gọi khi load trang
    checkUnreadMessages();

    // Gọi lại mỗi 7 giây
    setInterval(checkUnreadMessages, 7000);
});
</script>

<!-- 🔹 Hiệu ứng rung cho chấm đỏ -->
<style>
@keyframes pulse {
    0% { transform: scale(1); opacity: 1; }
    50% { transform: scale(1.3); opacity: 0.7; }
    100% { transform: scale(1); opacity: 1; }
}
#admin-chat-badge {
    animation: pulse 1.6s infinite;
}
</style>

    @stack('scripts')
</body>
</html>

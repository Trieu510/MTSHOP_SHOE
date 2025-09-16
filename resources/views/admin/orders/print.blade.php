<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>In đơn hàng #{{ $order->id }}</title>
    <style>
        body {
            font-family: DejaVu Sans, Arial, sans-serif;
            font-size: 14px;
            line-height: 1.6;
            color: #000;
            background: #fff;
            padding: 20px;
        }

        h1, h2, h3, h4 {
            margin-bottom: 0;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h2 {
            text-transform: uppercase;
        }

        .section {
            margin-bottom: 20px;
        }

        .section-title {
            font-weight: bold;
            margin-bottom: 10px;
            border-bottom: 1px solid #000;
            padding-bottom: 5px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .table th, .table td {
            border: 1px solid #000;
            padding: 8px 12px;
            text-align: left;
            font-size: 13px;
        }

        .table th {
            background: #f0f0f0;
        }

        .text-right {
            text-align: right;
        }

        .total {
            font-weight: bold;
        }

        .footer {
            text-align: center;
            margin-top: 40px;
            font-size: 13px;
        }

        @media print {
            .no-print {
                display: none !important;
            }
        }

        .btn-print {
            margin-bottom: 20px;
            display: inline-block;
            padding: 8px 20px;
            font-size: 14px;
            background: #000;
            color: #fff;
            border: none;
            cursor: pointer;
        }

        .btn-print:hover {
            background: #333;
        }
    </style>
</head>
<body>
    <div class="no-print">
        <button onclick="window.print()" class="btn-print">🖨️ In đơn hàng</button>
    </div>

    <div class="header">
        <h2>HÓA ĐƠN BÁN HÀNG</h2>
        <p>Mã đơn hàng: #{{ $order->id }}</p>
        <p>Ngày đặt: {{ $order->created_at->format('d/m/Y H:i') }}</p>
    </div>

    <div class="section">
        <div class="section-title">Thông tin khách hàng</div>
        <p><strong>Họ tên:</strong> {{ $order->user?->name ?? $order->name }}</p>
        <p><strong>SĐT:</strong> {{ $order->phone }}</p>
        <p><strong>Địa chỉ:</strong> {{ $order->address }}</p>
        <p><strong>Phương thức thanh toán:</strong> {{ strtoupper($order->payment_method) }}</p>
        <p><strong>Trạng thái:</strong> {{ ucfirst($order->status) }}</p>
    </div>

    <div class="section">
        <div class="section-title">Chi tiết sản phẩm</div>
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Tên sản phẩm</th>
                    <th>Size</th>
                    <th>Đơn giá</th>
                    <th>Số lượng</th>
                    <th>Thành tiền</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->product_name }}</td>
                        <td>{{ $item->variant->size ?? '-' }}</td>
                        <td>{{ number_format($item->price, 0) }} ₫</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ number_format($item->subtotal, 0) }} ₫</td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="5" class="text-right total">Tạm tính:</td>
                    <td>{{ number_format($order->subtotal, 0) }} ₫</td>
                </tr>
                <tr>
                    <td colspan="5" class="text-right total">Phí vận chuyển:</td>
                    <td>{{ number_format($order->shipping_fee, 0) }} ₫</td>
                </tr>
                <tr>
                    <td colspan="5" class="text-right total">Tổng cộng:</td>
                    <td>{{ number_format($order->total_amount, 0) }} ₫</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="footer">
        <p>Xin cảm ơn quý khách đã mua hàng!</p>
    </div>
</body>
</html>

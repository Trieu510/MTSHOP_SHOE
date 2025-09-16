@component('mail::message')
# 👋 Xin chào {{ $user->name }},

<p style="font-size:15px; line-height:1.6; margin-bottom:16px;">
    Yêu cầu hoàn/trả hàng của bạn cho đơn hàng <strong>#{{ $orderId }}</strong> đã được cập nhật trạng thái:
</p>

<p style="font-size:18px; font-weight:bold; color:{{ $statusColor }}; margin: 8px 0;">
    {{ $statusIcon }} {{ $status }}
</p>

@component('mail::button', ['url' => $url])
🔍 Xem chi tiết yêu cầu
@endcomponent

---

<p style="font-size:14px; color:#555;">
    Nếu bạn có bất kỳ thắc mắc nào, xin vui lòng liên hệ bộ phận chăm sóc khách hàng của chúng tôi.
</p>

**📦 Trân trọng,**
Đội ngũ MTShop
@endcomponent

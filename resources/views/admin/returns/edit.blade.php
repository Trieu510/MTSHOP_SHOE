@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">Xử lý yêu cầu hoàn/trả hàng #{{ $return->id }}</h2>

    <div class="mb-3">
        <strong>Đơn hàng:</strong> #{{ $return->order->id ?? 'N/A' }}<br>
        <strong>Khách hàng:</strong> {{ $return->user->name ?? 'N/A' }}<br>
        <strong>Ngày yêu cầu:</strong> {{ $return->created_at->format('d/m/Y H:i') }}
    </div>

    <div class="mb-3">
        <strong>Lý do hoàn trả:</strong>
        <p>{{ $return->reason }}</p>
    </div>

    @if($return->images && $return->images->count())
        <div class="mb-3">
            <strong>Hình ảnh minh họa:</strong>
            <div class="row">
                @foreach($return->images as $img)
                    <div class="col-md-3 mb-2">
                        <img src="{{ asset('storage/' . $img->path) }}" class="img-fluid rounded border">
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <form action="{{ route('admin.returns.update', $return->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Trạng thái xử lý</label>
            <select name="status" class="form-select" required>
                <option value="pending" {{ $return->status == 'pending' ? 'selected' : '' }}>Chờ xử lý</option>
                <option value="approved" {{ $return->status == 'approved' ? 'selected' : '' }}>Chấp nhận</option>
                <option value="rejected" {{ $return->status == 'rejected' ? 'selected' : '' }}>Từ chối</option>
                <option value="exchanged" {{ $return->status == 'exchanged' ? 'selected' : '' }}>Đã đổi hàng</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Ghi chú của admin (nếu có)</label>
            <textarea name="admin_note" class="form-control" rows="4">{{ old('admin_note', $return->admin_note) }}</textarea>
        </div>

        <button type="submit" class="btn btn-success">Cập nhật</button>
        <a href="{{ route('admin.returns.index') }}" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
@endsection

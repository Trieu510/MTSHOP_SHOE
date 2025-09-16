@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">Danh sách yêu cầu hoàn/trả hàng</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>#</th>
                <th>Mã đơn hàng</th>
                <th>Khách hàng</th>
                <th>Lý do</th>
                <th>Trạng thái</th>
                <th>Ngày yêu cầu</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @forelse($returns as $return)
                <tr>
                    <td>{{ $return->id }}</td>
                    <td>#{{ $return->order->id ?? 'N/A' }}</td>
                    <td>{{ $return->user->name ?? 'N/A' }}</td>
                    <td>{{ \Illuminate\Support\Str::limit($return->reason, 50) }}</td>
                    <td>
                        <span class="badge bg-{{ $return->status === 'pending' ? 'warning' : ($return->status === 'approved' ? 'success' : ($return->status === 'rejected' ? 'danger' : 'info')) }}">
                            {{ $return->status_label }}
                        </span>
                    </td>
                    <td>{{ $return->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        <a href="{{ route('admin.returns.edit', $return->id) }}" class="btn btn-sm btn-primary">Xử lý</a>
                        <form action="{{ route('admin.returns.destroy', $return->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Bạn có chắc muốn xoá yêu cầu này?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Xoá</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7">Chưa có yêu cầu hoàn/trả hàng nào.</td></tr>
            @endforelse
        </tbody>
    </table>

    <div>
        {{ $returns->links() }}
    </div>
</div>
@endsection

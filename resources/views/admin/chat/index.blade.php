@extends('layouts.admin')

@section('title', 'Hộp thoại khách hàng')

@section('content')
<div class="container my-4">
    <h3 class="mb-4">💬 Danh sách khách hàng đã nhắn tin</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-striped table-hover mb-0">
                <thead class="table-dark">
                    <tr class="text-center">
                        <th>STT</th>
                        <th>Tên khách hàng</th>
                        <th>Email</th>
                        <th>Tin nhắn gần nhất</th>
                        <th>Thời gian</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($customers as $index => $customer)
                        @php
                            // Lấy tin nhắn mới nhất giữa admin và khách hàng
                            $lastMessage = $customer->messages()
                                ->latest()
                                ->first();
                        @endphp
                        <tr class="align-middle">
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ $customer->name }}</td>
                            <td>{{ $customer->email }}</td>
                            <td>
                                @if($lastMessage)
                                    <span class="text-muted">
                                        {{ Str::limit($lastMessage->content, 40) }}
                                    </span>
                                @else
                                    <em class="text-secondary">Chưa có tin nhắn</em>
                                @endif
                            </td>
                            <td>
                                @if($lastMessage)
                                    {{ $lastMessage->created_at->diffForHumans() }}
                                @else
                                    -
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('admin.chat.show', $customer->id) }}" class="btn btn-sm btn-primary">
                                    <i class="bi bi-chat-dots"></i> Xem hội thoại
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                😔 Chưa có khách hàng nào nhắn tin.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@extends('layouts.front')

@section('title', 'Trò chuyện với hỗ trợ')

@section('content')
<div class="container my-5">
    <h3 class="mb-4 text-center">💬 Trò chuyện với Hỗ trợ</h3>

    <div id="chat-box" class="chat-box border rounded p-3 mb-3"
         style="height: 400px; overflow-y: auto; background: #f9f9f9;">
        @foreach($messages as $msg)
            @if($msg->user_id == Auth::id())
                {{-- Tin nhắn của tôi --}}
                <div class="d-flex justify-content-end mb-2">
                    <div class="p-2 rounded bg-primary text-white" style="max-width:70%; text-align:right;">
                        {{ $msg->content }}
                        <div class="text-light small">{{ $msg->created_at->diffForHumans() }}</div>
                    </div>
                </div>
            @else
                {{-- Tin nhắn từ Admin --}}
                <div class="d-flex justify-content-start mb-2">
                    <div class="p-2 rounded bg-light" style="max-width:70%;">
                        {{ $msg->content }}
                        <div class="text-muted small">{{ $msg->created_at->diffForHumans() }}</div>
                    </div>
                </div>
            @endif
        @endforeach
    </div>

    <form id="chat-form" action="{{ route('chat.send') }}" method="POST">
        @csrf
        <div class="input-group">
            <input type="text" name="content" id="chat-input" class="form-control" placeholder="Nhập tin nhắn..." required>
            <button type="submit" class="btn btn-primary">Gửi</button>
        </div>
    </form>
</div>

{{-- ======================== JS ======================== --}}
<script>
document.addEventListener('DOMContentLoaded', () => {
    const userId = "{{ Auth::id() }}";
    const chatBox = document.getElementById('chat-box');
    const chatForm = document.getElementById('chat-form');
    const chatInput = document.getElementById('chat-input');

    // 🟢 Cuộn xuống cuối khi load trang
    chatBox.scrollTop = chatBox.scrollHeight;

    // 🟢 Gửi tin nhắn qua AJAX
    chatForm.addEventListener('submit', e => {
        e.preventDefault();
        const formData = new FormData(chatForm);

        fetch(chatForm.action, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                appendMessage('Tôi', data.message.content, true);
                chatInput.value = '';
            }
        });
    });

    // 🟢 Hàm hiển thị tin nhắn mới
    function appendMessage(sender, content, isMe = false) {
        const div = document.createElement('div');
        div.classList.add('d-flex', isMe ? 'justify-content-end' : 'justify-content-start', 'mb-2');
        div.innerHTML = `
            <div class="p-2 rounded ${isMe ? 'bg-primary text-white' : 'bg-light'}" style="max-width:70%;">
                <strong>${sender}:</strong> ${content}
            </div>`;
        chatBox.appendChild(div);
        chatBox.scrollTop = chatBox.scrollHeight;
    }

    // 🟢 Realtime qua Laravel Echo
    if (window.Echo) {
        window.Echo.private('chat.' + userId)
            .listen('.MessageSent', e => {
                if (e.message.user_id === 1 && e.message.receiver_id == userId) {
                    appendMessage('Hỗ trợ', e.message.content, false);
                }
            });
    }

    // 🟢 Polling dự phòng: kiểm tra tin nhắn mới mỗi 5 giây
    setInterval(() => {
        fetch("{{ route('chat.index') }}", { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
            .then(res => res.json())
            .then(data => {
                data.messages.forEach(msg => {
                    // Nếu tin nhắn chưa có trong chatBox
                    if (!document.getElementById('msg-' + msg.id)) {
                        appendMessage(msg.user_id === userId ? 'Tôi' : 'Hỗ trợ', msg.content, msg.user_id === userId);
                    }
                });
            });
    }, 5000);
});
</script>
@endsection

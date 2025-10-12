@extends('layouts.admin')

@section('title', 'Chat với ' . $customer->name)

@section('content')
<div class="container my-4">
    <h4 class="mb-3">
        💬 Chat với <strong>{{ $customer->name }}</strong>
        <a href="{{ route('admin.chat.index') }}" class="btn btn-sm btn-outline-secondary float-end">
            ← Quay lại danh sách
        </a>
    </h4>

    <div id="chat-box" class="border rounded p-3 mb-3 bg-light shadow-sm"
         style="height: 450px; overflow-y: auto; display: flex; flex-direction: column;">
        @foreach($messages as $msg)
            @php $isAdminMsg = $msg->user_id === Auth::id(); @endphp
            <div class="d-flex mb-3 {{ $isAdminMsg ? 'justify-content-end' : 'justify-content-start' }}">
                <div class="p-2 rounded shadow-sm"
                     style="max-width: 70%; background: {{ $isAdminMsg ? '#d1e7dd' : '#f8f9fa' }};
                            border: 1px solid {{ $isAdminMsg ? '#badbcc' : '#dee2e6' }}">
                    <div>
                        <strong class="{{ $isAdminMsg ? 'text-success' : 'text-primary' }}">
                            {{ $isAdminMsg ? 'Hỗ trợ' : $customer->name }}
                        </strong>
                    </div>
                    <div>{{ $msg->content }}</div>
                    <div class="text-muted small mt-1 text-end">
                        {{ $msg->created_at->format('H:i d/m/Y') }}
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <form id="chat-form" action="{{ route('admin.chat.send', $customer->id) }}" method="POST">
        @csrf
        <div class="input-group">
            <input type="text" name="content" id="chat-input"
                   class="form-control" placeholder="Nhập tin nhắn..." required>
            <button type="submit" class="btn btn-success px-4">Gửi</button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const chatBox = document.getElementById('chat-box');
    const chatForm = document.getElementById('chat-form');
    const chatInput = document.getElementById('chat-input');
    const customerId = {{ $customer->id }};
    const adminId = {{ Auth::id() }};

    chatBox.scrollTop = chatBox.scrollHeight;

    // Gửi tin nhắn bằng AJAX
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
                appendMessage('Hỗ trợ', data.message.content, true);
                chatInput.value = '';
            }
        });
    });

    function appendMessage(sender, content, isAdmin=false){
        const div = document.createElement('div');
        div.classList.add('d-flex', 'mb-3', isAdmin ? 'justify-content-end' : 'justify-content-start');
        div.innerHTML = `
            <div class="p-2 rounded shadow-sm"
                 style="max-width:70%; background:${isAdmin ? '#d1e7dd' : '#f8f9fa'}; border:1px solid ${isAdmin ? '#badbcc' : '#dee2e6'};">
                <div><strong class="${isAdmin ? 'text-success' : 'text-primary'}">${sender}</strong></div>
                <div>${content}</div>
            </div>`;
        chatBox.appendChild(div);
        chatBox.scrollTop = chatBox.scrollHeight;
    }

    // Realtime lắng nghe tin nhắn
    if(window.Echo){
        window.Echo.private('chat.' + adminId)
            .listen('.MessageSent', e => {
                if(e.message.user_id == customerId && e.message.receiver_id == adminId){
                    appendMessage('{{ $customer->name }}', e.message.content, false);
                }
            });
    }

    // 🔄 Polling: kiểm tra tin nhắn mới mỗi 5 giây (dành cho trường hợp bỏ lỡ event)
    setInterval(() => {
        fetch("{{ route('admin.chat.show', $customer->id) }}?ajax=1")
            .then(res => res.json())
            .then(data => {
                if(data.messages){
                    chatBox.innerHTML = ''; // Xóa cũ
                    data.messages.forEach(msg => {
                        appendMessage(
                            msg.user_id == adminId ? 'Hỗ trợ' : '{{ $customer->name }}',
                            msg.content,
                            msg.user_id == adminId
                        );
                    });
                }
            });
    }, 5000);

});
</script>
@endsection

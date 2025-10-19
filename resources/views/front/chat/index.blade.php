@extends('layouts.front')

@section('title', 'Trò chuyện với hỗ trợ')

@push('styles')
<style>
    .highlight-reply {
        animation: replyHighlight 2s ease-in-out;
        background-color: #fff3cd !important;
    }
    @keyframes replyHighlight {
        0% { background-color: #fff3cd; }
        100% { background-color: transparent; }
    }
</style>
@endpush

@section('content')
<div class="chat-page py-4" style="background: #f3f4f6;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-xl-6">
                <div class="chat-box-wrapper border rounded shadow-sm bg-white d-flex flex-column" style="height: 80vh;">

                    {{-- 🔝 Header --}}
                    <div class="chat-header p-3 border-bottom d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">💬 Hỗ trợ khách hàng</h5>
                    </div>

                    {{-- 💬 Nội dung tin nhắn --}}
                    <div id="chat-box" class="chat-box flex-grow-1 p-3 overflow-auto" style="background:#f9f9f9;">
                        @foreach($messages as $msg)
                            @php $isMe = $msg->user_id == Auth::id(); @endphp
                            <div id="msg-{{ $msg->id }}" class="chat-message mb-2 {{ $isMe ? 'text-end' : 'text-start' }}">
                                <div class="d-inline-block position-relative p-2 rounded {{ $isMe ? 'bg-primary text-white' : 'bg-light' }}" style="max-width:75%;">

                                    {{-- 📨 Nếu có trả lời --}}
                                    @if($msg->replyTo)
                                        <div class="p-2 mb-1 rounded bg-white border small text-muted reply-reference"
                                             data-target="msg-{{ $msg->reply_to_id }}" style="cursor:pointer;">
                                            <strong>{{ $msg->replyTo->user_id == Auth::id() ? 'Tôi' : 'Hỗ trợ' }}:</strong>
                                            @if($msg->replyTo->type === 'text')
                                                {{ Str::limit($msg->replyTo->content, 80) }}
                                            @elseif($msg->replyTo->type === 'image')
                                                📷 Ảnh
                                            @elseif($msg->replyTo->type === 'file')
                                                📎 {{ basename($msg->replyTo->file_path) }}
                                            @endif
                                        </div>
                                    @endif

                                    {{-- Nội dung chính --}}
                                    @if($msg->is_recalled)
                                        <em class="text-muted">Tin nhắn đã được thu hồi</em>
                                    @else
                                        @if($msg->type === 'text')
                                            {{ $msg->content }}
                                        @elseif($msg->type === 'image')
                                            <a href="{{ asset('storage/'.$msg->file_path) }}" target="_blank">
                                                <img src="{{ asset('storage/'.$msg->file_path) }}" class="img-fluid rounded" style="max-width:200px;">
                                            </a>
                                        @elseif($msg->type === 'file')
                                            📎 <a href="{{ asset('storage/'.$msg->file_path) }}" target="_blank" class="{{ $isMe ? 'text-white' : '' }}">
                                                {{ basename($msg->file_path) }}
                                            </a>
                                        @endif
                                    @endif

                                    <div class="text-muted small mt-1">{{ $msg->created_at->format('H:i d/m/Y') }}</div>

                                    {{-- ⚙️ Menu hành động --}}
                                    <div class="dropdown position-absolute top-0 {{ $isMe ? 'start-0' : 'end-0' }}">
                                        <button class="btn btn-sm btn-link p-0 {{ $isMe ? 'text-white' : '' }}"
                                                type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            ⋮
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <button class="dropdown-item reply-btn"
                                                        data-id="{{ $msg->id }}"
                                                        data-content="{{ e($msg->content) }}">
                                                    Trả lời
                                                </button>
                                            </li>
                                            @if($isMe && !$msg->is_recalled)
                                                <li><button class="dropdown-item recall-btn" data-id="{{ $msg->id }}">Thu hồi</button></li>
                                            @endif
                                            <li><button class="dropdown-item text-danger delete-self-btn" data-id="{{ $msg->id }}">Xóa phía tôi</button></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- 📎 Preview file/ảnh --}}
                    <div id="file-preview" class="border-top p-2 d-none" style="background:#f8f9fa;">
                        <div class="d-flex justify-content-between align-items-center">
                            <div id="file-preview-content" class="text-truncate small"></div>
                            <button type="button" id="cancel-file" class="btn btn-sm btn-outline-danger ms-2">X</button>
                        </div>
                    </div>

                    {{-- 📌 Preview trả lời --}}
                    <div id="reply-preview" class="alert alert-secondary py-2 px-3 d-none position-relative mb-0" style="font-size: 14px;">
                        <div id="reply-content"></div>
                        <button type="button" id="cancel-reply" class="btn-close position-absolute top-0 end-0 me-2 mt-2"></button>
                    </div>

                    {{-- ✍️ Form nhập tin nhắn --}}
                    <div class="chat-footer border-top p-2">
                        <form id="chat-form" action="{{ route('chat.send') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="reply_to_id" id="reply-to-id">
                            <div class="input-group">
                                <label for="file-input" class="btn btn-light mb-0">📎</label>
                                <input type="file" id="file-input" name="file" class="d-none" accept="image/*,.pdf,.doc,.docx,.zip">
                                <input type="text" name="content" id="chat-input" class="form-control" placeholder="Nhập tin nhắn...">
                                <button type="submit" class="btn btn-primary">Gửi</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

{{-- ======================== JS ======================== --}}
<script>
document.addEventListener('DOMContentLoaded', () => {
    const userId = "{{ Auth::id() }}";
    const chatBox = document.getElementById('chat-box');
    const chatForm = document.getElementById('chat-form');
    const fileInput = document.getElementById('file-input');
    const filePreview = document.getElementById('file-preview');
    const filePreviewContent = document.getElementById('file-preview-content');
    const cancelFileBtn = document.getElementById('cancel-file');
    const replyPreview = document.getElementById('reply-preview');
    const replyContent = document.getElementById('reply-content');
    const replyToIdInput = document.getElementById('reply-to-id');
    const cancelReplyBtn = document.getElementById('cancel-reply');

    chatBox.scrollTop = chatBox.scrollHeight;

    // 📎 Preview file/ảnh
    fileInput.addEventListener('change', () => {
        if (!fileInput.files.length) return;
        const file = fileInput.files[0];
        const ext = file.name.split('.').pop().toLowerCase();

        if (['jpg','jpeg','png','gif','webp'].includes(ext)) {
            const reader = new FileReader();
            reader.onload = e => {
                filePreviewContent.innerHTML = `
                    <div class="d-flex align-items-center">
                        <img src="${e.target.result}" alt="preview" style="width:60px; height:60px; object-fit:cover; border-radius:5px; margin-right:8px;">
                        <span class="small text-truncate">${file.name}</span>
                    </div>`;
            };
            reader.readAsDataURL(file);
        } else {
            filePreviewContent.textContent = file.name;
        }
        filePreview.classList.remove('d-none');
    });

    cancelFileBtn.onclick = () => {
        fileInput.value = '';
        filePreview.classList.add('d-none');
        filePreviewContent.innerHTML = '';
    };

    // 📌 Cuộn + highlight khi click khung trả lời
    chatBox.addEventListener('click', e => {
        const ref = e.target.closest('.reply-reference');
        if (!ref) return;
        const targetEl = document.getElementById(ref.dataset.target);
        if (targetEl) {
            targetEl.scrollIntoView({ behavior: 'smooth', block: 'center' });
            targetEl.classList.add('highlight-reply');
            setTimeout(() => targetEl.classList.remove('highlight-reply'), 2000);
        }
    });

    // 📝 Trả lời, xóa, thu hồi tin nhắn
    chatBox.addEventListener('click', e => {
        const replyBtn = e.target.closest('.reply-btn');
        const deleteBtn = e.target.closest('.delete-self-btn');
        const recallBtn = e.target.closest('.recall-btn');

        if (replyBtn) {
            replyToIdInput.value = replyBtn.dataset.id;
            replyContent.innerHTML = `<strong>Trả lời:</strong> ${replyBtn.dataset.content}`;
            replyPreview.classList.remove('d-none');
        }

        if (deleteBtn) {
            const id = deleteBtn.dataset.id;
            fetch(`/chat/messages/${id}/delete-self`, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
            }).then(r => r.json()).then(data => {
                if (data.success) document.getElementById('msg-' + id)?.remove();
            });
        }

        if (recallBtn) {
            const id = recallBtn.dataset.id;
            fetch(`/chat/messages/${id}/recall`, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
            }).then(r => r.json()).then(data => {
                if (data.success) {
                    const msgDiv = document.querySelector(`#msg-${id} .d-inline-block`);
                    if (msgDiv) msgDiv.innerHTML = `<em class="text-muted">Tin nhắn đã được thu hồi</em>`;
                }
            });
        }
    });

    // ❌ Hủy trả lời
    cancelReplyBtn.onclick = () => {
        replyToIdInput.value = '';
        replyPreview.classList.add('d-none');
    };

    // 📨 Gửi tin nhắn
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
                appendMessage(data.message, true);
                chatForm.reset();
                filePreview.classList.add('d-none');
                replyPreview.classList.add('d-none');
            }
        });
    });

    // 📝 Thêm tin nhắn mới + khởi tạo dropdown
    function appendMessage(msg, isMe = false) {
        if (document.getElementById('msg-' + msg.id)) return;

        let contentHtml = '';
        if (msg.type === 'text') contentHtml = msg.content;
        else if (msg.type === 'image') contentHtml = `<a href="${msg.file_url}" target="_blank"><img src="${msg.file_url}" class="img-fluid rounded" style="max-width:200px;"></a>`;
        else if (msg.type === 'file') contentHtml = `📎 <a href="${msg.file_url}" target="_blank">${msg.file_url.split('/').pop()}</a>`;

        const div = document.createElement('div');
        div.id = 'msg-' + msg.id;
        div.className = `chat-message mb-2 ${isMe ? 'text-end' : 'text-start'}`;
        div.innerHTML = `
            <div class="d-inline-block p-2 rounded ${isMe ? 'bg-primary text-white' : 'bg-light'} position-relative" style="max-width:75%;">
                ${contentHtml}
                <div class="text-muted small mt-1">${msg.time}</div>
                <div class="dropdown position-absolute top-0 ${isMe ? 'start-0' : 'end-0'}">
                    <button class="btn btn-sm btn-link p-0 ${isMe ? 'text-white' : ''}" type="button" data-bs-toggle="dropdown" aria-expanded="false">⋮</button>
                    <ul class="dropdown-menu">
                        <li><button class="dropdown-item reply-btn" data-id="${msg.id}" data-content="${msg.content || ''}">Trả lời</button></li>
                        ${isMe ? `<li><button class="dropdown-item recall-btn" data-id="${msg.id}">Thu hồi</button></li>` : ''}
                        <li><button class="dropdown-item text-danger delete-self-btn" data-id="${msg.id}">Xóa phía tôi</button></li>
                    </ul>
                </div>
            </div>`;
        chatBox.appendChild(div);

        // 👉 Khởi tạo dropdown Bootstrap cho tin nhắn mới
        const dropdownBtn = div.querySelector('[data-bs-toggle="dropdown"]');
        new bootstrap.Dropdown(dropdownBtn);

        chatBox.scrollTop = chatBox.scrollHeight;
    }

    // 🔁 Poll tin nhắn mới
    setInterval(() => {
        fetch("{{ route('chat.index') }}", { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
        .then(res => res.json())
        .then(data => {
            data.messages.forEach(msg => appendMessage(msg, msg.user_id == userId));
        });
    }, 5000);
});
</script>
@endsection

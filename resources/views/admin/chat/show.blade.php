@extends('layouts.admin')

@section('title', 'Chat với ' . $customer->name)

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
    .reply-reference {
        cursor: pointer;
    }
</style>
@endpush

@section('content')
<div class="container my-4">
    <h4 class="mb-3">
        💬 Chat với <strong>{{ $customer->name }}</strong>
        <a href="{{ route('admin.chat.index') }}" class="btn btn-sm btn-outline-secondary float-end">
            ← Quay lại danh sách
        </a>
    </h4>

    {{-- 💬 Hộp chat --}}
    <div id="chat-box" class="border rounded p-3 mb-3 bg-light shadow-sm"
         style="height: 450px; overflow-y: auto; display: flex; flex-direction: column;">
        @forelse($messages as $msg)
            @php $isAdmin = $msg->user_id === Auth::id(); @endphp
            <div id="msg-{{ $msg->id }}" class="chat-message d-flex mb-3 {{ $isAdmin ? 'justify-content-end' : 'justify-content-start' }}">
                <div class="p-2 rounded shadow-sm position-relative"
                     style="max-width: 70%; background: {{ $isAdmin ? '#d1e7dd' : '#f8f9fa' }};
                            border: 1px solid {{ $isAdmin ? '#badbcc' : '#dee2e6' }};">

                    {{-- 📨 Khung trả lời --}}
                    @if($msg->replyTo)
                        <div class="p-2 mb-1 rounded bg-white border small text-muted reply-reference"
                             data-target="msg-{{ $msg->reply_to_id }}">
                            <strong>{{ $msg->replyTo->user_id === Auth::id() ? 'Hỗ trợ' : $customer->name }}:</strong>
                            @if($msg->replyTo->type === 'text')
                                {{ Str::limit($msg->replyTo->content, 80) }}
                            @elseif($msg->replyTo->type === 'image')
                                📷 Ảnh
                            @elseif($msg->replyTo->type === 'file')
                                📎 {{ basename($msg->replyTo->file_path) }}
                            @endif
                        </div>
                    @endif

                    {{-- Tên người gửi --}}
                    <div>
                        <strong class="{{ $isAdmin ? 'text-success' : 'text-primary' }}">
                            {{ $isAdmin ? 'Hỗ trợ' : $customer->name }}
                        </strong>
                    </div>

                    {{-- Nội dung tin nhắn --}}
                    @if($msg->is_recalled)
                        <em class="text-muted">Tin nhắn đã được thu hồi</em>
                    @else
                        @if($msg->type === 'text')
                            {{ e($msg->content) }}
                        @elseif($msg->type === 'image')
                            <a href="{{ asset('storage/'.$msg->file_path) }}" target="_blank">
                                <img src="{{ asset('storage/'.$msg->file_path) }}" class="img-fluid rounded mt-1" style="max-width:200px;">
                            </a>
                        @elseif($msg->type === 'file')
                            📎 <a href="{{ asset('storage/'.$msg->file_path) }}" target="_blank">{{ basename($msg->file_path) }}</a>
                        @endif
                    @endif

                    <div class="text-muted small mt-1 text-end">
                        {{ $msg->created_at->format('H:i d/m/Y') }}
                    </div>

                    {{-- ⋮ Menu hành động --}}
                    <div class="dropdown position-absolute top-0 {{ $isAdmin ? 'start-0' : 'end-0' }}">
                        <button class="btn btn-sm btn-link p-0 text-dark" type="button" data-bs-toggle="dropdown">⋮</button>
                        <ul class="dropdown-menu">
                            <li>
                                <button class="dropdown-item reply-btn"
                                    data-id="{{ $msg->id }}"
                                    data-content="{{ e($msg->content) }}">Trả lời</button>
                            </li>
                            @if($isAdmin && !$msg->is_recalled)
                                <li><button class="dropdown-item recall-btn" data-id="{{ $msg->id }}">Thu hồi</button></li>
                            @endif
                            <li><button class="dropdown-item text-danger delete-self-btn" data-id="{{ $msg->id }}">Xóa phía tôi</button></li>
                        </ul>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-center text-muted">💭 Chưa có tin nhắn nào.</p>
        @endforelse
    </div>

    {{-- 📌 Preview trả lời --}}
    <div id="reply-preview" class="alert alert-secondary py-2 px-3 d-none position-relative" style="font-size: 14px;">
        <div id="reply-content"></div>
        <button type="button" id="cancel-reply" class="btn-close position-absolute top-0 end-0 me-2 mt-2"></button>
    </div>

    {{-- 📝 Form gửi --}}
    <form id="chat-form" action="{{ route('admin.chat.send', $customer->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="reply_to_id" id="reply-to-id">
        <div class="input-group mt-2">
            <label for="file-input" class="btn btn-light mb-0">📎</label>
            <input type="file" id="file-input" name="file" class="d-none" accept="image/*,.pdf,.doc,.docx,.zip">
            <input type="text" name="content" id="chat-input"
                   class="form-control" placeholder="Nhập tin nhắn..." autocomplete="off">
            <button type="submit" class="btn btn-success px-4">Gửi</button>
        </div>
    </form>

    {{-- 📎 Preview file --}}
    <div id="file-preview" class="mt-2 d-none">
        <div class="border rounded p-2 bg-white d-flex align-items-center justify-content-between">
            <div id="file-preview-content"></div>
            <button type="button" id="remove-file" class="btn btn-sm btn-outline-danger">✕</button>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const chatBox = document.getElementById('chat-box');
    const chatForm = document.getElementById('chat-form');
    const fileInput = document.getElementById('file-input');
    const filePreview = document.getElementById('file-preview');
    const filePreviewContent = document.getElementById('file-preview-content');
    const removeFileBtn = document.getElementById('remove-file');
    const replyPreview = document.getElementById('reply-preview');
    const replyContent = document.getElementById('reply-content');
    const replyToIdInput = document.getElementById('reply-to-id');
    const cancelReplyBtn = document.getElementById('cancel-reply');

    chatBox.scrollTop = chatBox.scrollHeight;

    // 📎 Preview file
    fileInput.addEventListener('change', e => {
        const file = e.target.files[0];
        if (!file) return;
        filePreviewContent.innerHTML = '';
        if (file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = ev => {
                const img = document.createElement('img');
                img.src = ev.target.result;
                img.className = 'img-fluid rounded';
                img.style.maxWidth = '150px';
                filePreviewContent.appendChild(img);
            };
            reader.readAsDataURL(file);
        } else {
            filePreviewContent.textContent = '📎 ' + file.name;
        }
        filePreview.classList.remove('d-none');
    });

    removeFileBtn.addEventListener('click', () => {
        fileInput.value = '';
        filePreview.classList.add('d-none');
        filePreviewContent.innerHTML = '';
    });

    // 📌 Cuộn + highlight khi click khung trả lời
    chatBox.addEventListener('click', e => {
        const ref = e.target.closest('.reply-reference');
        if (ref) {
            const targetId = ref.dataset.target;
            const targetEl = document.getElementById(targetId);
            if (targetEl) {
                targetEl.scrollIntoView({ behavior: 'smooth', block: 'center' });
                targetEl.classList.add('highlight-reply');
                setTimeout(() => targetEl.classList.remove('highlight-reply'), 2000);
            }
        }
    });

    // 📝 Chọn tin để trả lời
    chatBox.addEventListener('click', e => {
        if (e.target.classList.contains('reply-btn')) {
            replyToIdInput.value = e.target.dataset.id;
            replyContent.innerHTML = `<strong>Trả lời:</strong> ${e.target.dataset.content}`;
            replyPreview.classList.remove('d-none');
        }
    });
    cancelReplyBtn.addEventListener('click', () => {
        replyToIdInput.value = '';
        replyPreview.classList.add('d-none');
    });

    // 📨 Gửi tin nhắn + file (AJAX)
    chatForm.addEventListener('submit', async e => {
        e.preventDefault();
        const formData = new FormData(chatForm);
        const res = await fetch(chatForm.action, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: formData
        });
        const data = await res.json();

        if (data.success) {
            appendMessage(data.message, true);
            chatForm.reset();
            filePreview.classList.add('d-none');
            filePreviewContent.innerHTML = '';
            replyPreview.classList.add('d-none');
        } else if (data.message) {
            alert(data.message);
        }
    });

    // 🗑 Xóa phía admin (AJAX)
    chatBox.addEventListener('click', async e => {
        if (e.target.classList.contains('delete-self-btn')) {
            const id = e.target.dataset.id;
            const res = await fetch(`/chat/messages/${id}/delete-self`, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
            });
            const data = await res.json();
            if (data.success) {
                document.getElementById('msg-' + id)?.remove();
            }
        }
    });

    // 🔁 Thu hồi tin nhắn (AJAX)
    chatBox.addEventListener('click', async e => {
        if (e.target.classList.contains('recall-btn')) {
            const id = e.target.dataset.id;
            const res = await fetch(`/chat/messages/${id}/recall`, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
            });
            const data = await res.json();
            if (data.success) {
                const msgDiv = document.querySelector(`#msg-${id} .p-2`);
                if (msgDiv) msgDiv.innerHTML = `<em class="text-muted">Tin nhắn đã được thu hồi</em>`;
            } else if (data.message) {
                alert(data.message);
            }
        }
    });

    // ➕ Thêm tin nhắn vào UI
    function appendMessage(msg, isAdmin = false) {
        if (document.getElementById('msg-' + msg.id)) return;
        let contentHtml = '';
        if (msg.type === 'text') {
            contentHtml = msg.content;
        } else if (msg.type === 'image') {
            contentHtml = `<a href="${msg.file_url}" target="_blank"><img src="${msg.file_url}" class="img-fluid rounded mt-1" style="max-width:200px;"></a>`;
        } else if (msg.type === 'file') {
            contentHtml = `📎 <a href="${msg.file_url}" target="_blank">${msg.file_url.split('/').pop()}</a>`;
        }

        const div = document.createElement('div');
        div.id = 'msg-' + msg.id;
        div.className = `chat-message d-flex mb-3 ${isAdmin ? 'justify-content-end' : 'justify-content-start'}`;
        div.innerHTML = `
            <div class="p-2 rounded shadow-sm position-relative"
                 style="max-width: 70%; background: ${isAdmin ? '#d1e7dd' : '#f8f9fa'};
                        border: 1px solid ${isAdmin ? '#badbcc' : '#dee2e6'};">
                <div><strong class="${isAdmin ? 'text-success' : 'text-primary'}">${isAdmin ? 'Hỗ trợ' : '{{ $customer->name }}'}</strong></div>
                ${contentHtml}
                <div class="text-muted small mt-1 text-end">${msg.time}</div>
            </div>`;
        chatBox.appendChild(div);
        chatBox.scrollTop = chatBox.scrollHeight;
    }
});
</script>
@endsection

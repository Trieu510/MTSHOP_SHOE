@extends('layouts.front')

@section('title', 'Trò chuyện với hỗ trợ')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/animate.css@4.1.1/animation.min.css">

<style>
    :root {
        --primary: #ff6b35;
        --primary-gradient: linear-gradient(135deg, #ff8c00, #ff6b35);
        --dark: #1a1a1a;
        --light: #f8f9fa;
        --gold: #ffd700;
    }

    body {
        font-family: 'Inter', sans-serif;
    }

    .chat-page {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        min-height: 100vh;
    }

    .chat-box-wrapper {
        height: 82vh;
        border: 1px solid rgba(0,0,0,0.05);
        border-radius: 1.5rem;
        overflow: hidden;
        box-shadow: 0 20px 40px rgba(0,0,0,0.08);
    }

    .chat-header {
        background: linear-gradient(135deg, #1a1a1a, #2d2d2d);
        color: #fff;
        padding: 1rem 1.5rem;
    }

    .online-indicator {
        width: 12px;
        height: 12px;
        background: #28a745;
        border-radius: 50%;
        box-shadow: 0 0 0 0 rgba(40,167,69,1);
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% { box-shadow: 0 0 0 0 rgba(40,167,69,0.7); }
        70% { box-shadow: 0 0 0 10px rgba(40,167,69,0); }
        100% { box-shadow: 0 0 0 0 rgba(40,167,69,0); }
    }

    .chat-box {
        background: #f9f9f9;
        padding: 1rem;
    }

    .chat-message {
        margin-bottom: 1rem;
    }

    .message-bubble {
        max-width: 78%;
        padding: 0.75rem 1rem;
        border-radius: 1.2rem;
        position: relative;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        transition: all 0.2s ease;
    }

    .message-bubble.me {
        background: var(--primary-gradient);
        color: white;
        margin-left: auto;
    }

    .message-bubble.other {
        background: white;
        border: 1px solid #e9ecef;
        margin-right: auto;
    }

    .reply-reference {
        background: rgba(255,255,255,0.3);
        border-left: 3px solid var(--gold);
        padding: 0.5rem;
        border-radius: 0.5rem;
        font-size: 0.875rem;
        margin-bottom: 0.5rem;
        cursor: pointer;
    }

    .reply-reference:hover {
        background: rgba(255,255,255,0.5);
    }

    .message-text {
        word-break: break-word;
        line-height: 1.5;
    }

    .message-time {
        font-size: 0.75rem;
        opacity: 0.75;
        margin-top: 0.25rem;
    }

    .action-menu {
        top: 8px;
        width: 28px;
        height: 28px;
        opacity: 0.7;
        transition: opacity 0.2s;
    }

    .action-menu:hover {
        opacity: 1;
    }

    .action-menu.me { left: 8px; }
    .action-menu.other { right: 8px; }

    .highlight-reply {
        animation: replyHighlight 2.5s ease-in-out;
        background-color: #fff8e1 !important;
        border-left: 4px solid #ff8c00 !important;
        transform: scale(1.02);
    }

    @keyframes replyHighlight {
        0% { background-color: #fff8e1; transform: scale(1.02); }
        100% { background-color: transparent; transform: scale(1); }
    }

    #file-preview {
        background: #f1f3f5;
        padding: 0.75rem 1rem;
        border-top: 1px solid #dee2e6;
    }

    #reply-preview {
        background: #fff8e1;
        border-left: 4px solid #ff8c00;
        padding: 0.5rem 1rem;
        font-size: 0.9rem;
        position: relative;
    }

    .chat-footer {
        background: white;
        padding: 0.75rem 1rem;
        border-top: 1px solid #dee2e6;
    }

    .input-group {
        border: 1px solid #dee2e6;
        border-radius: 1rem;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }

    .form-control {
        border: none;
        box-shadow: none;
        font-size: 0.95rem;
        padding: 0.75rem 1rem;
    }

    .form-control:focus {
        border-color: #ff8c00 !important;
        box-shadow: 0 0 0 0.2rem rgba(255,140,0,0.25) !important;
    }

    .btn-send {
        background: #ff8c00;
        color: white;
        border: none;
        padding: 0.75rem 1.25rem;
        font-weight: 600;
    }

    .btn-send:hover {
        background: #e67e22;
    }

    /* Scrollbar */
    #chat-box::-webkit-scrollbar { width: 6px; }
    #chat-box::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 10px; }
    #chat-box::-webkit-scrollbar-thumb { background: #ced4da; border-radius: 10px; }
    #chat-box::-webkit-scrollbar-thumb:hover { background: #adb5bd; }
</style>
@endpush

@section('content')
<div class="chat-page py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-xl-6">
                <div class="chat-box-wrapper bg-white d-flex flex-column">

                    {{-- Header --}}
                    <div class="chat-header">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <div class="online-indicator me-3"></div>
                                <div>
                                    <h5 class="mb-0 fw-bold" style="font-family: 'Poppins', sans-serif;">Hỗ trợ khách hàng</h5>
                                    <small class="opacity-75">Đang trực tuyến • Phản hồi nhanh</small>
                                </div>
                            </div>
                            <div>
                                <span class="fw-bold text-warning" style="font-family: 'Poppins', sans-serif; font-size: 1.1rem;">SHOEZ</span>
                            </div>
                        </div>
                    </div>

                    {{-- Tin nhắn --}}
                    <div id="chat-box" class="flex-grow-1 overflow-auto p-3">
                        @foreach($messages as $msg)
                            @php $isMe = $msg->user_id == Auth::id(); @endphp
                            <div id="msg-{{ $msg->id }}" class="chat-message mb-3 {{ $isMe ? 'text-end' : 'text-start' }} animate__animated animate__fadeIn">
                                <div class="d-inline-block position-relative">
                                    <div class="message-bubble {{ $isMe ? 'me' : 'other' }}">

                                        {{-- Trả lời --}}
                                        @if($msg->replyTo)
                                            <div class="reply-reference" data-target="msg-{{ $msg->reply_to_id }}">
                                                <strong class="text-warning">{{ $msg->replyTo->user_id == Auth::id() ? 'Bạn' : 'SHOEZ' }}:</strong>
                                                @if($msg->replyTo->type === 'text')
                                                    {{ Str::limit($msg->replyTo->content, 70) }}
                                                @elseif($msg->replyTo->type === 'image')
                                                    Ảnh
                                                @elseif($msg->replyTo->type === 'file')
                                                    {{ basename($msg->replyTo->file_path) }}
                                                @endif
                                            </div>
                                        @endif

                                        {{-- Nội dung --}}
                                        @if($msg->is_recalled)
                                            <em class="opacity-75">Tin nhắn đã thu hồi</em>
                                        @else
                                            @if($msg->type === 'text')
                                                <div class="message-text">{!! nl2br(e($msg->content)) !!}</div>
                                            @elseif($msg->type === 'image')
                                                <a href="{{ asset('storage/'.$msg->file_path) }}" target="_blank">
                                                    <img src="{{ asset('storage/'.$msg->file_path) }}" class="img-fluid rounded shadow-sm" style="max-width:220px; transition:0.3s;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                                                </a>
                                            @elseif($msg->type === 'file')
                                                <div class="d-flex align-items-center gap-2">
                                                    <span>attachment</span>
                                                    <a href="{{ asset('storage/'.$msg->file_path) }}" target="_blank" class="{{ $isMe ? 'text-white' : 'text-primary' }} text-decoration-none fw-500">
                                                        {{ basename($msg->file_path) }}
                                                    </a>
                                                </div>
                                            @endif
                                        @endif

                                        <div class="message-time">{{ $msg->created_at->format('H:i, d/m/Y') }}</div>

                                        {{-- Menu hành động --}}
                                        <div class="dropdown position-absolute action-menu {{ $isMe ? 'me' : 'other' }}">
                                            <button class="btn btn-sm p-0" type="button" data-bs-toggle="dropdown">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                                    <path d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"/>
                                                </svg>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                                                <li><button class="dropdown-item reply-btn fw-500" data-id="{{ $msg->id }}" data-content="{{ e($msg->content) }}">Trả lời</button></li>
                                                @if($isMe && !$msg->is_recalled)
                                                    <li><button class="dropdown-item recall-btn text-warning fw-500" data-id="{{ $msg->id }}">Thu hồi</button></li>
                                                @endif
                                                <li><hr class="dropdown-divider"></li>
                                                <li><button class="dropdown-item text-danger delete-self-btn fw-500" data-id="{{ $msg->id }}">Xóa phía tôi</button></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Preview file --}}
                    <div id="file-preview" class="d-none">
                        <div class="d-flex align-items-center justify-content-between">
                            <div id="file-preview-content" class="d-flex align-items-center gap-3 text-muted small"></div>
                            <button type="button" id="cancel-file" class="btn btn-sm btn-close"></button>
                        </div>
                    </div>

                    {{-- Preview trả lời --}}
                    <div id="reply-preview" class="d-none position-relative">
                        <div id="reply-content" class="text-muted"></div>
                        <button type="button" id="cancel-reply" class="btn-close position-absolute top-50 end-0 translate-middle-y me-3"></button>
                    </div>

                    {{-- Input --}}
                    <div class="chat-footer">
                        <form id="chat-form" action="{{ route('chat.send') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="reply_to_id" id="reply-to-id">
                            <div class="input-group">
                                <label for="file-input" class="btn btn-light border-0 m-0 px-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#6c757d" viewBox="0 0 16 16">
                                        <path d="M4 1.5a2.5 2.5 0 0 1 2.5-2.5h3A2.5 2.5 0 0 1 12 1.5v11a2.5 2.5 0 0 1-2.5 2.5h-3A2.5 2.5 0 0 1 4 12.5v-11z"/>
                                    </svg>
                                </label>
                                <input type="file" id="file-input" name="file" class="d-none" accept="image/*,.pdf,.doc,.docx,.zip">
                                <input type="text" name="content" id="chat-input" class="form-control border-0" placeholder="Aa..." autocomplete="off">
                                <button type="submit" class="btn btn-send px-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="white" viewBox="0 0 16 16">
                                        <path d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5a.5.5 0 0 0 0 1h9.293l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z"/>
                                    </svg>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
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
    const chatInput = document.getElementById('chat-input');

    chatBox.scrollTop = chatBox.scrollHeight;

    // Enter gửi, Shift+Enter xuống dòng
    chatInput.addEventListener('keydown', e => {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            if (chatInput.value.trim() || fileInput.files.length) {
                chatForm.dispatchEvent(new Event('submit'));
            }
        }
    });

    // File preview
    fileInput.addEventListener('change', () => {
        if (!fileInput.files.length) return;
        const file = fileInput.files[0];
        const ext = file.name.split('.').pop().toLowerCase();

        if (['jpg','jpeg','png','gif','webp'].includes(ext)) {
            const reader = new FileReader();
            reader.onload = e => {
                filePreviewContent.innerHTML = `
                    <img src="${e.target.result}" class="rounded shadow-sm me-2" style="width:50px; height:50px; object-fit:cover;">
                    <span class="text-truncate" style="max-width:180px;">${file.name}</span>`;
            };
            reader.readAsDataURL(file);
        } else {
            filePreviewContent.innerHTML = `<span>attachment ${file.name}</span>`;
        }
        filePreview.classList.remove('d-none');
    });

    cancelFileBtn.onclick = () => {
        fileInput.value = '';
        filePreview.classList.add('d-none');
        filePreviewContent.innerHTML = '';
    };

    // Click reply reference
    chatBox.addEventListener('click', e => {
        const ref = e.target.closest('.reply-reference');
        if (!ref) return;
        const targetEl = document.getElementById(ref.dataset.target);
        if (targetEl) {
            targetEl.scrollIntoView({ behavior: 'smooth', block: 'center' });
            targetEl.classList.add('highlight-reply');
            setTimeout(() => targetEl.classList.remove('highlight-reply'), 2500);
        }
    });

    // Reply, delete, recall
    chatBox.addEventListener('click', e => {
        const replyBtn = e.target.closest('.reply-btn');
        const deleteBtn = e.target.closest('.delete-self-btn');
        const recallBtn = e.target.closest('.recall-btn');

        if (replyBtn) {
            replyToIdInput.value = replyBtn.dataset.id;
            replyContent.innerHTML = `<strong>Trả lời:</strong> ${replyBtn.dataset.content || 'Tin nhắn'}`;
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
                    const msgDiv = document.querySelector(`#msg-${id} .message-bubble`);
                    if (msgDiv) {
                        msgDiv.innerHTML = `
                            <em class="opacity-75">Tin nhắn đã thu hồi</em>
                            <div class="message-time">${new Date().toLocaleTimeString('vi-VN')}</div>
                            <div class="dropdown position-absolute action-menu ${userId == data.message.user_id ? 'me' : 'other'}">
                                <button class="btn btn-sm p-0" type="button" data-bs-toggle="dropdown">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                        <path d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"/>
                                    </svg>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                                    <li><button class="dropdown-item text-danger delete-self-btn fw-500" data-id="${id}">Xóa phía tôi</button></li>
                                </ul>
                            </div>`;
                    }
                }
            });
        }
    });

    cancelReplyBtn.onclick = () => {
        replyToIdInput.value = '';
        replyPreview.classList.add('d-none');
    };

    // Gửi tin nhắn
chatForm.addEventListener('submit', e => {
    e.preventDefault();
    if (!chatInput.value.trim() && !fileInput.files.length) return;

    const formData = new FormData(chatForm);

    fetch(chatForm.action, {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            // Reset form sau khi gửi
            chatForm.reset();
            filePreview.classList.add('d-none');
            replyPreview.classList.add('d-none');
            replyToIdInput.value = '';

            // 🟢 Tự động reload lại toàn trang sau 0.3 giây
            setTimeout(() => {
                location.reload();
            }, 300);
        } else {
            console.error('Không gửi được tin nhắn:', data.message);
        }
    })
    .catch(err => console.error('Lỗi gửi tin nhắn:', err));
});

    // Thêm tin nhắn mới
    function appendMessage(msg, isMe = false) {
        if (document.getElementById('msg-' + msg.id)) return;
        // 🟡 Nếu tin nhắn có phần trả lời (reply_to), hiển thị đoạn preview nhỏ bên trên
let replyHtml = '';
if (msg.reply_to) {
    replyHtml = `
        <div class="reply-reference" data-target="msg-${msg.reply_to.id}">
            <strong class="text-warning">${msg.reply_to.sender || 'SHOEZ'}:</strong>
            ${msg.reply_to.content ? msg.reply_to.content.substring(0, 60) : 'Tin nhắn'}
        </div>`;
}

        let contentHtml = '';
        if (msg.type === 'text') contentHtml = `<div class="message-text">${msg.content.replace(/\n/g, '<br>')}</div>`;
        else if (msg.type === 'image') contentHtml = `<a href="${msg.file_url}" target="_blank"><img src="${msg.file_url}" class="img-fluid rounded shadow-sm" style="max-width:220px;"></a>`;
        else if (msg.type === 'file') contentHtml = `attachment <a href="${msg.file_url}" target="_blank" class="${isMe ? 'text-white' : 'text-primary'}">${msg.file_url.split('/').pop()}</a>`;

        const div = document.createElement('div');
        div.id = 'msg-' + msg.id;
        div.className = `chat-message mb-3 ${isMe ? 'text-end' : 'text-start'} animate__animated animate__fadeIn`;
        div.innerHTML = `
            <div class="d-inline-block position-relative">
                <div class="message-bubble ${isMe ? 'me' : 'other'}">
                    ${contentHtml}
                    <div class="message-time">${msg.time}</div>
                    <div class="dropdown position-absolute action-menu ${isMe ? 'me' : 'other'}">
                        <button class="btn btn-sm p-0" type="button" data-bs-toggle="dropdown">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"/>
                            </svg>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                            <li><button class="dropdown-item reply-btn fw-500" data-id="${msg.id}" data-content="${msg.content || ''}">Trả lời</button></li>
                            ${isMe ? `<li><button class="dropdown-item recall-btn text-warning fw-500" data-id="${msg.id}">Thu hồi</button></li>` : ''}
                            <li><hr class="dropdown-divider"></li>
                            <li><button class="dropdown-item text-danger delete-self-btn fw-500" data-id="${msg.id}">Xóa phía tôi</button></li>
                        </ul>
                    </div>
                </div>
            </div>`;
        chatBox.appendChild(div);

        const dropdownBtn = div.querySelector('[data-bs-toggle="dropdown"]');
        new bootstrap.Dropdown(dropdownBtn);

        chatBox.scrollTop = chatBox.scrollHeight;
    }

    // Poll tin nhắn mới (giảm xuống 3s để mượt hơn)
    setInterval(() => {
    fetch("{{ route('chat.index') }}", { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
    .then(res => res.json())
    .then(data => {
        data.messages.forEach(msg => {
            const existing = document.getElementById('msg-' + msg.id);
            // Nếu tin nhắn bị thu hồi -> cập nhật ngay
            if (existing && msg.is_recalled) {
                const bubble = existing.querySelector('.message-bubble');
                bubble.innerHTML = `<em class="opacity-75">Tin nhắn đã thu hồi</em>`;
            } else {
                appendMessage(msg, msg.user_id == userId);
            }
        });
    });
}, 3000);
});
</script>
@endpush

@extends('layouts.admin')

@section('title', 'Chat với ' . $customer->name)

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/animate.css@4.1.1/animation.min.css">

<style>
    :root {
        --admin: #00d084;
        --admin-light: #d4f7e8;
        --customer: #f1f3f5;
        --border: #dee2e6;
        --text: #2d3748;
        --muted: #718096;
        --gold: #ffd700;
        --shadow: 0 10px 30px rgba(0,0,0,0.08);
        --primary: #6366f1;
        --bg: #f8f9fa;
    }

    body { font-family: 'Inter', sans-serif; background: var(--bg); }

    .chat-wrapper {
        max-width: 1000px;
        margin: 1.5rem auto;
        background: white;
        border-radius: 1.5rem;
        overflow: hidden;
        box-shadow: var(--shadow);
        height: calc(100vh - 120px);
        display: flex;
        flex-direction: column;
    }

    .chat-header {
        background: linear-gradient(135deg, var(--admin), #00b074);
        color: white;
        padding: 1rem 1.5rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    .customer-info {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .customer-avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid white;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }

    .customer-name {
        font-family: 'Poppins', sans-serif;
        font-weight: 700;
        font-size: 1.2rem;
        margin: 0;
    }

    .customer-status {
        font-size: 0.85rem;
        opacity: 0.9;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .online-dot {
        width: 10px;
        height: 10px;
        background: #28a745;
        border-radius: 50%;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% { box-shadow: 0 0 0 0 rgba(40,167,69,0.7); }
        70% { box-shadow: 0 0 0 10px rgba(40,167,69,0); }
        100% { box-shadow: 0 0 0 0 rgba(40,167,69,0); }
    }

    .back-btn {
        background: rgba(255,255,255,0.2);
        border: 1px solid rgba(255,255,255,0.3);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 50px;
        font-size: 0.9rem;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .back-btn:hover {
        background: rgba(255,255,255,0.3);
        transform: translateY(-1px);
        color: white;
    }

    #chat-box {
        flex: 1;
        padding: 1.5rem;
        overflow-y: auto;
        background: #f9f9f9;
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .chat-message {
        display: flex;
        max-width: 80%;
        animation: fadeInUp 0.4s ease;
    }

    .chat-message.admin { align-self: flex-end; }
    .chat-message.customer { align-self: flex-start; }

    .message-bubble {
        padding: 0.75rem 1rem;
        border-radius: 1.25rem;
        position: relative;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        word-wrap: break-word;
    }

    .message-bubble.admin {
        background: var(--admin-light);
        border-bottom-right-radius: 0.5rem;
        border: 1px solid #b8e6d1;
    }

    .message-bubble.customer {
        background: white;
        border-bottom-left-radius: 0.5rem;
        border: 1px solid var(--border);
    }

    .reply-reference {
        background: rgba(255,255,255,0.4);
        border-left: 3px solid var(--gold);
        padding: 0.5rem;
        border-radius: 0.75rem;
        font-size: 0.85rem;
        margin-bottom: 0.5rem;
        cursor: pointer;
        transition: background 0.2s;
    }

    .reply-reference:hover { background: rgba(255,255,255,0.6); }

    .message-sender {
        font-weight: 600;
        font-size: 0.85rem;
        margin-bottom: 0.25rem;
    }

    .admin .message-sender { color: var(--admin); }
    .customer .message-sender { color: #4a5568; }

    .message-time {
        font-size: 0.7rem;
        color: var(--muted);
        text-align: right;
        margin-top: 0.25rem;
    }

    .action-menu {
        position: absolute;
        top: 8px;
        width: 28px;
        height: 28px;
        opacity: 0;
        transition: opacity 0.2s;
    }

    .admin .action-menu { right: 8px; }
    .customer .action-menu { left: 8px; }

    .chat-message:hover .action-menu { opacity: 1; }

    .highlight-reply {
        animation: replyHighlight 2.5s ease-in-out;
        background-color: #fff8e1 !important;
        border-left: 4px solid #ff8c00 !important;
    }

    @keyframes replyHighlight {
        0% { background-color: #fff8e1; transform: scale(1.02); }
        100% { background-color: transparent; transform: scale(1); }
    }

    #reply-preview {
        background: #fff8e1;
        border-left: 4px solid #ff8c00;
        padding: 0.75rem 1rem;
        font-size: 0.9rem;
        border-radius: 0 1rem 1rem 0;
        margin: 0.5rem 1.5rem;
        max-width: 80%;
        align-self: flex-start;
        position: relative;
    }

    .chat-footer {
        padding: 1rem 1.5rem;
        background: white;
        border-top: 1px solid var(--border);
    }

    .input-group {
        border: 1.5px solid #ced4da;
        border-radius: 1.5rem;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        transition: all 0.2s;
    }

    .input-group:focus-within {
        border-color: var(--admin);
        box-shadow: 0 0 0 0.2rem rgba(0, 208, 132, 0.25);
    }

    .form-control {
        border: none;
        box-shadow: none;
        padding: 0.75rem 1rem;
        font-size: 0.95rem;
    }

    .btn-attach, .btn-send {
        background: transparent;
        border: none;
        padding: 0.75rem;
        font-size: 1.2rem;
        color: #6c757d;
        transition: color 0.2s;
    }

    .btn-attach:hover, .btn-send:hover { color: var(--admin); }

    .btn-send {
        background: var(--admin);
        color: white;
        border-radius: 50%;
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-left: 0.5rem;
        box-shadow: 0 4px 12px rgba(0, 208, 132, 0.3);
        transition: all 0.3s ease;
    }

    .btn-send:hover {
        background: #00b074;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0, 208, 132, 0.4);
    }

    #file-preview {
        background: #f8f9fa;
        border: 1px dashed #ced4da;
        border-radius: 1rem;
        padding: 0.75rem;
        margin: 0.5rem 1.5rem;
        max-width: 300px;
        align-self: flex-start;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
    }

    /* Scrollbar */
    #chat-box::-webkit-scrollbar { width: 6px; }
    #chat-box::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 10px; }
    #chat-box::-webkit-scrollbar-thumb { background: #ced4da; border-radius: 10px; }
    #chat-box::-webkit-scrollbar-thumb:hover { background: #adb5bd; }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .empty-chat {
        text-align: center;
        color: #adb5bd;
        padding: 3rem;
    }

    .empty-chat i {
        font-size: 3.5rem;
        margin-bottom: 1rem;
        opacity: 0.5;
    }
</style>
@endpush

@section('content')
<div class="chat-wrapper">
    <!-- Header -->
    <div class="chat-header">
        <div class="customer-info">
            <img src="{{ $customer->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($customer->name) . '&background=00d084&color=fff&size=50&bold=true' }}"
                 alt="{{ $customer->name }}" class="customer-avatar">
            <div>
                <h5 class="customer-name mb-0">{{ $customer->name }}</h5>
                <div class="customer-status">
                    <div class="online-dot"></div>
                    Đang hoạt động
                </div>
            </div>
        </div>
        <a href="{{ route('admin.chat.index') }}" class="back-btn">
            Quay lại
        </a>
    </div>

    <!-- Messages -->
    <div id="chat-box">
        @forelse($messages as $msg)
            @php $isAdmin = $msg->user_id === Auth::id(); @endphp
            <div id="msg-{{ $msg->id }}" class="chat-message {{ $isAdmin ? 'admin' : 'customer' }}">
                <div class="message-bubble">
                    @if($msg->replyTo)
                        <div class="reply-reference" data-target="msg-{{ $msg->reply_to_id }}">
                            <strong>{{ $msg->replyTo->user_id === Auth::id() ? 'Hỗ trợ' : $customer->name }}:</strong>
                            @if($msg->replyTo->type === 'text')
                                {{ Str::limit($msg->replyTo->content, 60) }}
                            @elseif($msg->replyTo->type === 'image') Ảnh
                            @elseif($msg->replyTo->type === 'file') {{ basename($msg->replyTo->file_path) }}
                            @endif
                        </div>
                    @endif

                    <div class="message-sender">
                        {{ $isAdmin ? 'Hỗ trợ' : $customer->name }}
                    </div>

                    @if($msg->is_recalled)
                        <em class="text-muted">Tin nhắn đã được thu hồi</em>
                    @else
                        @if($msg->type === 'text')
                            <div>{!! nl2br(e($msg->content)) !!}</div>
                        @elseif($msg->type === 'image')
                            <a href="{{ asset('storage/'.$msg->file_path) }}" target="_blank">
                                <img src="{{ asset('storage/'.$msg->file_path) }}" class="img-fluid rounded shadow-sm" style="max-width:250px; transition:0.3s;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                            </a>
                        @elseif($msg->type === 'file')
                            <div class="d-flex align-items-center gap-2 mt-1">
                                <i class="bi bi-paperclip"></i>
                                <a href="{{ asset('storage/'.$msg->file_path) }}" target="_blank" class="text-decoration-none fw-500">
                                    {{ basename($msg->file_path) }}
                                </a>
                            </div>
                        @endif
                    @endif

                    <div class="message-time">{{ $msg->created_at->format('H:i, d/m') }}</div>

                    <div class="dropdown action-menu">
                        <button class="btn btn-sm p-0" type="button" data-bs-toggle="dropdown">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"/>
                            </svg>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                            <li><button class="dropdown-item reply-btn fw-500" data-id="{{ $msg->id }}" data-content="{{ e($msg->content) }}">Trả lời</button></li>
                            @if($isAdmin && !$msg->is_recalled)
                                <li><button class="dropdown-item recall-btn text-warning fw-500" data-id="{{ $msg->id }}">Thu hồi</button></li>
                            @endif
                            <li><hr class="dropdown-divider"></li>
                            <li><button class="dropdown-item text-danger delete-self-btn fw-500" data-id="{{ $msg->id }}">Xóa phía tôi</button></li>
                        </ul>
                    </div>
                </div>
            </div>
        @empty
            <div class="empty-chat">
                <i class="bi bi-chat-square-text"></i>
                <p class="mt-3">Chưa có tin nhắn nào. Hãy bắt đầu cuộc trò chuyện!</p>
            </div>
        @endforelse
    </div>

    <!-- Reply Preview -->
    <div id="reply-preview" class="d-none">
        <div id="reply-content" class="text-muted"></div>
        <button type="button" id="cancel-reply" class="btn-close position-absolute top-50 end-0 translate-middle-y me-3"></button>
    </div>

    <!-- File Preview -->
    <div id="file-preview" class="d-none"></div>

    <!-- Input -->
    <div class="chat-footer">
        <form id="chat-form" action="{{ route('admin.chat.send', $customer->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="reply_to_id" id="reply-to-id">
            <div class="d-flex align-items-center gap-2">
                <label for="file-input" class="btn-attach">
                    <i class="bi bi-paperclip"></i>
                </label>
                <input type="file" id="file-input" name="file" class="d-none" accept="image/*,.pdf,.doc,.docx,.zip">
                <div class="input-group flex-grow-1">
                    <input type="text" name="content"  id="chat-input" class="form-control border-0 shadow-none" placeholder="Aa..." autocomplete="off">
                </div>
                <button type="submit" class="btn-send">
                    <i class="bi bi-send-fill"></i>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const chatBox = document.getElementById('chat-box');
    const chatForm = document.getElementById('chat-form');
    const fileInput = document.getElementById('file-input');
    const filePreview = document.getElementById('file-preview');
    const filePreviewContent = document.getElementById('file-preview-content') || filePreview;
    const removeFileBtn = document.getElementById('remove-file');
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
    fileInput.addEventListener('change', e => {
        const file = e.target.files[0];
        if (!file) return;
        filePreview.innerHTML = '';
        if (file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = ev => {
                const img = document.createElement('img');
                img.src = ev.target.result;
                img.className = 'img-fluid rounded shadow-sm';
                img.style.maxWidth = '200px';
                filePreview.appendChild(img);
            };
            reader.readAsDataURL(file);
        } else {
            filePreview.innerHTML = `<span><i class="bi bi-file-earmark"></i> ${file.name}</span>`;
        }
        filePreview.classList.remove('d-none');
    });

    // Click reply reference
    chatBox.addEventListener('click', e => {
        const ref = e.target.closest('.reply-reference');
        if (ref) {
            const targetEl = document.getElementById(ref.dataset.target);
            if (targetEl) {
                targetEl.scrollIntoView({ behavior: 'smooth', block: 'center' });
                targetEl.classList.add('highlight-reply');
                setTimeout(() => targetEl.classList.remove('highlight-reply'), 2500);
            }
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

    // ✅ Phân biệt route admin / frontend
    const isAdmin = window.location.pathname.includes('/admin/');
    const url = isAdmin
        ? `/admin/chats/messages/${id}/recall`
        : `/chat/messages/${id}/recall`;

    fetch(url, {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            const msgDiv = document.querySelector(`#msg-${id} .message-bubble`);
            if (msgDiv) {
                msgDiv.innerHTML = `
                    <em class="text-muted">Tin nhắn đã được thu hồi</em>
                    <div class="message-time">${new Date().toLocaleTimeString('vi-VN')}</div>
                `;
            }
        } else {
            alert(data.message || 'Không thể thu hồi tin nhắn.');
        }
    })
    .catch(err => console.error('Recall error:', err));
}

    });

    cancelReplyBtn.onclick = () => {
        replyToIdInput.value = '';
        replyPreview.classList.add('d-none');
    };

    // Gửi tin nhắn (có tự động reload)
chatForm.addEventListener('submit', async e => {
    e.preventDefault();

    if (!chatInput.value.trim() && !fileInput.files.length) return;

    const formData = new FormData(chatForm);

    try {
        const res = await fetch(chatForm.action, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: formData
        });

        const data = await res.json();

        if (data.success) {
    // 🧹 Dọn form sau khi gửi
    chatForm.reset();
    filePreview.classList.add('d-none');
    replyPreview.classList.add('d-none');
    replyToIdInput.value = '';

    // ✅ Hiển thị tin nhắn mới ngay mà không reload
    appendMessage(data.message, true);
    lastMessageId = data.message.id;
}
else {
            alert(data.message || 'Không thể gửi tin nhắn.');
        }

    } catch (err) {
        console.error('Lỗi khi gửi tin nhắn:', err);
    }
});

    // Thêm tin nhắn
    function appendMessage(msg, isAdmin = false) {
        if (document.getElementById('msg-' + msg.id)) return;

        let contentHtml = '';
        if (msg.type === 'text') contentHtml = `<div>${msg.content.replace(/\n/g, '<br>')}</div>`;
        else if (msg.type === 'image') contentHtml = `<a href="${msg.file_url}" target="_blank"><img src="${msg.file_url}" class="img-fluid rounded shadow-sm" style="max-width:250px;"></a>`;
        else if (msg.type === 'file') contentHtml = `<div class="d-flex align-items-center gap-2 mt-1"><i class="bi bi-paperclip"></i><a href="${msg.file_url}" target="_blank">${msg.file_url.split('/').pop()}</a></div>`;

        const div = document.createElement('div');
        div.id = 'msg-' + msg.id;
        div.className = `chat-message ${isAdmin ? 'admin' : 'customer'} animate__animated animate__fadeInUp`;
        div.innerHTML = `
            <div class="message-bubble">
                <div class="message-sender">${isAdmin ? 'Hỗ trợ' : '{{ $customer->name }}'}</div>
                ${contentHtml}
                <div class="message-time">${msg.time}</div>
                <div class="dropdown action-menu">
                    <button class="btn btn-sm p-0" type="button" data-bs-toggle="dropdown">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M9.5 13a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm0-5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"/>
                        </svg>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                        <li><button class="dropdown-item reply-btn fw-500" data-id="${msg.id}" data-content="${msg.content || ''}">Trả lời</button></li>
                        ${isAdmin ? `<li><button class="dropdown-item recall-btn text-warning fw-500" data-id="${msg.id}">Thu hồi</button></li>` : ''}
                        <li><hr class="dropdown-divider"></li>
                        <li><button class="dropdown-item text-danger delete-self-btn fw-500" data-id="${msg.id}">Xóa phía tôi</button></li>
                    </ul>
                </div>
            </div>`;
        chatBox.appendChild(div);
        chatBox.scrollTop = chatBox.scrollHeight;
    }
    // ============================
// 🔄 TỰ ĐỘNG NHẬN TIN NHẮN MỚI MỖI 3 GIÂY
// ============================
let lastMessageId = {{ $messages->last()->id ?? 0 }};

setInterval(() => {
    fetch(`{{ route('admin.chat.show', $customer->id) }}?ajax=1&last_id=${lastMessageId}`, {
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(res => res.json())
    .then(data => {
        if (!data || !data.messages) return;

        const newMessages = data.messages.filter(m => m.id > lastMessageId);
        if (newMessages.length > 0) {
            newMessages.forEach(msg => {
                appendMessage({
                    id: msg.id,
                    content: msg.content || '',
                    type: msg.type,
                    file_url: msg.file_path ? `/storage/${msg.file_path}` : null,
                    time: new Date(msg.created_at).toLocaleTimeString('vi-VN'),
                    sender_id: msg.user_id,
                    receiver_id: msg.receiver_id
                }, msg.user_id === {{ Auth::id() }});
                lastMessageId = msg.id;
            });
        }
    })
    .catch(err => console.error('❌ Lỗi tải tin mới:', err));
}, 3000);

});
</script>
@endpush

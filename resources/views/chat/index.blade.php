@extends('layout.app')
@section('title', 'Чат по проекту')
@push('styles')
    <style>
        .chat-container {
            display: flex;
            flex-direction: column;
            height: 70vh;
            background: #f8f9fa;
            border-radius: 1rem;
            overflow: hidden;
            box-shadow: var(--card-shadow);
        }
        .chat-messages {
            flex: 1;
            overflow-y: auto;
            padding: 1rem;
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }
        .message {
            display: flex;
            flex-direction: column;
            max-width: 75%;
            position: relative;
        }
        .message.own {
            align-self: flex-end;
        }
        .message.other {
            align-self: flex-start;
        }
        .message-bubble {
            padding: 0.5rem 1rem;
            border-radius: 1.25rem;
            word-wrap: break-word;
            position: relative;
        }
        .message.own .message-bubble {
            background-color: #0d6efd;
            color: white;
            border-bottom-right-radius: 0.25rem;
        }
        .message.other .message-bubble {
            background-color: #e9ecef;
            color: #212529;
            border-bottom-left-radius: 0.25rem;
        }
        .message-meta {
            font-size: 0.7rem;
            margin-top: 0.2rem;
            margin-left: 0.5rem;
            margin-right: 0.5rem;
            display: flex;
            justify-content: space-between;
            color: #6c757d;
        }
        .message.own .message-meta {
            justify-content: flex-end;
        }
        .message-author {
            font-weight: 600;
        }
        .message-actions {
            position: absolute;
            top: 0;
            right: 0;
            transform: translateX(120%);
            display: flex;
            gap: 0.25rem;
            opacity: 0;
            transition: opacity 0.2s;
        }
        .message:hover .message-actions {
            opacity: 1;
        }
        .message.own .message-actions {
            right: auto;
            left: 0;
            transform: translateX(-120%);
        }
        @media (max-width: 768px) {
            .message {
                max-width: 90%;
            }
            .message-actions {
                transform: none !important;
                position: static;
                opacity: 1;
                justify-content: flex-end;
                margin-bottom: 0.2rem;
            }
        }
        .chat-input {
            padding: 1rem;
            background: white;
            border-top: 1px solid #dee2e6;
        }
    </style>
@endpush
@section('content')
    <div class="card border-0">
        <div class="card-header bg-white border-bottom">
            <h5 class="mb-0">
                <i class="bi bi-chat-dots-fill text-primary"></i>
                Проект: {{ $studentProject->project->title }} — {{ $studentProject->student->name }}
            </h5>
        </div>
        <div class="chat-container">
            <div class="chat-messages" id="messages">
                @foreach($messages as $msg)
                    @php
                        $isOwn = ($msg->sender_id === auth()->id());
                        $canEditDelete = ($isOwn || auth()->user()->isAdmin());
                    @endphp
                    <div class="message {{ $isOwn ? 'own' : 'other' }}" data-message-id="{{ $msg->id }}">
                        <div class="message-bubble">
                            {{ htmlspecialchars($msg->text) }}
                        </div>
                        <div class="message-meta">
                            <span class="message-author">{{ $msg->sender->name }}</span>
                            <span>{{ $msg->created_at->format('d.m.Y H:i') }}</span>
                        </div>
                        @if($canEditDelete)
                            <div class="message-actions">
                                <button class="btn btn-sm btn-link text-decoration-none p-0 edit-message" title="Редактировать">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <button class="btn btn-sm btn-link text-decoration-none p-0 delete-message" title="Удалить">
                                    <i class="bi bi-trash3"></i>
                                </button>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
            <div class="chat-input">
                <form action="{{ route('chat.send', $studentProject) }}" method="POST" id="chatForm">
                    @csrf
                    <div class="input-group">
                        <input type="text" name="text" class="form-control" placeholder="Ваше сообщение..." required autocomplete="off">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-send"></i> Отправить
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Модальное окно редактирования сообщения -->
    <div class="modal fade" id="editMessageModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Редактировать сообщение</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <textarea id="editMessageText" class="form-control" rows="3"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                    <button type="button" id="saveEditBtn" class="btn btn-primary">Сохранить</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        const messagesContainer = document.getElementById('messages');
        let currentEditMessageId = null;

        function scrollToBottom() {
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        }
        scrollToBottom();

        function refreshMessages() {
            fetch(window.location.href)
                .then(res => res.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const newMessagesHtml = doc.getElementById('messages').innerHTML;
                    if (messagesContainer.innerHTML !== newMessagesHtml) {
                        messagesContainer.innerHTML = newMessagesHtml;
                        attachMessageEvents();
                        scrollToBottom();
                    }
                });
        }

        function attachMessageEvents() {
            document.querySelectorAll('.edit-message').forEach(btn => {
                btn.removeEventListener('click', handleEditClick);
                btn.addEventListener('click', handleEditClick);
            });
            document.querySelectorAll('.delete-message').forEach(btn => {
                btn.removeEventListener('click', handleDeleteClick);
                btn.addEventListener('click', handleDeleteClick);
            });
        }

        function handleEditClick(e) {
            const messageDiv = e.target.closest('.message');
            currentEditMessageId = messageDiv.dataset.messageId;
            const bubble = messageDiv.querySelector('.message-bubble');
            const text = bubble.innerText.trim();
            document.getElementById('editMessageText').value = text;
            new bootstrap.Modal(document.getElementById('editMessageModal')).show();
        }

        function handleDeleteClick(e) {
            if (!confirm('Удалить это сообщение?')) return;
            const messageDiv = e.target.closest('.message');
            const msgId = messageDiv.dataset.messageId;
            fetch(`/chat/message/${msgId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            }).then(res => {
                if (res.ok) {
                    refreshMessages();
                } else {
                    alert('Ошибка при удалении');
                }
            });
        }

        document.getElementById('saveEditBtn').addEventListener('click', function() {
            const newText = document.getElementById('editMessageText').value.trim();
            if (!newText) return;
            fetch(`/chat/message/${currentEditMessageId}`, {
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ text: newText })
            }).then(res => {
                if (res.ok) {
                    bootstrap.Modal.getInstance(document.getElementById('editMessageModal')).hide();
                    refreshMessages();
                } else {
                    alert('Ошибка при редактировании');
                }
            });
        });

        setInterval(() => {
            refreshMessages();
        }, 3000);

        document.getElementById('chatForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const form = e.target;
            const formData = new FormData(form);
            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            }).then(response => {
                if (response.ok) {
                    form.reset();
                    refreshMessages();
                }
            });
            return false;
        });

        attachMessageEvents();
    </script>
@endsection

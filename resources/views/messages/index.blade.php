<!-- Chat Box for Room Management System -->
<div class="flex h-screen bg-gray-100">
    <!-- Sidebar - Danh sách tin nhắn -->
    <div class="w-1/3 bg-white border-r border-gray-200 flex flex-col">
        <!-- Header -->
        <div class="p-4 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-800 mb-3">
                <i class="fas fa-comments mr-2 text-blue-600"></i>
                Tin nhắn
            </h2>

            <!-- Search Box -->
            <form method="GET" action="{{ route('messages.index') }}" class="relative">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Tìm kiếm người dùng..."
                    class="w-full px-4 py-2 pl-10 pr-4 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
            </form>
        </div>

        <!-- Messages List -->
        <div class="flex-1 overflow-y-auto">
            @forelse($messages as $message)
                <div class="message-item p-4 border-b border-gray-100 hover:bg-gray-50 cursor-pointer transition-colors duration-200"
                    data-user-id="{{ $message->sender_id == Auth::id() ? $message->receiver_id : $message->sender_id }}"
                    data-user-name="{{ $message->sender_id == Auth::id() ? $message->receiver->name : $message->sender->name }}">

                    <div class="flex items-center space-x-3">
                        <!-- Avatar -->
                        <div class="relative">
                            <div
                                class="w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white font-semibold">
                                {{ strtoupper(substr($message->sender_id == Auth::id() ? $message->receiver->name : $message->sender->name, 0, 1)) }}
                            </div>
                            @if (!$message->is_read && $message->receiver_id == Auth::id())
                                <div class="absolute -top-1 -right-1 w-4 h-4 bg-red-500 rounded-full"></div>
                            @endif
                        </div>

                        <!-- Message Info -->
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between">
                                <h3 class="font-medium text-gray-900 truncate">
                                    {{ $message->sender_id == Auth::id() ? $message->receiver->name : $message->sender->name }}
                                </h3>
                                <span class="text-xs text-gray-500">
                                    {{ $message->created_at->diffForHumans() }}
                                </span>
                            </div>

                            <p class="text-sm text-gray-600 truncate mt-1">
                                @if ($message->sender_id == Auth::id())
                                    <span class="text-blue-600">Bạn:</span>
                                @endif
                                {{ $message->content }}
                            </p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-8 text-center text-gray-500">
                    <i class="fas fa-inbox text-4xl mb-4"></i>
                    <p>Chưa có tin nhắn nào</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if ($messages->hasPages())
            <div class="p-4 border-t border-gray-200">
                {{ $messages->links() }}
            </div>
        @endif
    </div>

    <!-- Chat Area -->
    <div class="flex-1 flex flex-col">
        <!-- Chat Header -->
        <div class="chat-header p-4 border-b border-gray-200 bg-white hidden">
            <div class="flex items-center space-x-3">
                <div
                    class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white font-semibold">
                    <span id="chat-user-avatar"></span>
                </div>
                <div>
                    <h3 class="font-medium text-gray-900" id="chat-user-name"></h3>
                    <p class="text-sm text-gray-500">Đang hoạt động</p>
                </div>
            </div>
        </div>

        <!-- Messages Area -->
        <div class="flex-1 overflow-y-auto p-4 space-y-4" id="messages-container">
            <!-- Welcome Message -->
            <div class="flex items-center justify-center h-full text-gray-500">
                <div class="text-center">
                    <i class="fas fa-comments text-6xl mb-4"></i>
                    <h3 class="text-xl font-medium mb-2">Chào mừng đến với Chat</h3>
                    <p>Chọn một cuộc trò chuyện để bắt đầu nhắn tin</p>
                </div>
            </div>
        </div>

        <!-- Message Input -->
        <div class="message-input p-4 border-t border-gray-200 bg-white hidden">
            <form id="message-form" class="flex items-center space-x-3">
                @csrf
                <input type="hidden" id="receiver-id" name="receiver_id">

                <div class="flex-1 relative">
                    <input type="text" id="message-input" name="content" placeholder="Nhập tin nhắn..."
                        class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-full focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none"
                        maxlength="1000" required>
                    <button type="button" class="absolute right-2 top-2 p-2 text-gray-400 hover:text-gray-600">
                        <i class="fas fa-smile"></i>
                    </button>
                </div>

                <button type="submit"
                    class="px-6 py-3 bg-blue-600 text-white rounded-full hover:bg-blue-700 transition-colors duration-200 flex items-center space-x-2">
                    <i class="fas fa-paper-plane"></i>
                    <span>Gửi</span>
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Custom Styles -->
<style>
    .message-item:hover {
        background-color: #f8fafc;
    }

    .message-item.active {
        background-color: #e3f2fd;
        border-left: 4px solid #2196f3;
    }

    .message-bubble {
        max-width: 70%;
        word-wrap: break-word;
    }

    .message-sent {
        background-color: #2196f3;
        color: white;
        margin-left: auto;
        border-radius: 18px 18px 4px 18px;
    }

    .message-received {
        background-color: #f1f3f4;
        color: #333;
        margin-right: auto;
        border-radius: 18px 18px 18px 4px;
    }

    #messages-container::-webkit-scrollbar {
        width: 4px;
    }

    #messages-container::-webkit-scrollbar-track {
        background: #f1f1f1;
    }

    #messages-container::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 2px;
    }

    #messages-container::-webkit-scrollbar-thumb:hover {
        background: #a8a8a8;
    }
</style>

<!-- JavaScript -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const messageItems = document.querySelectorAll('.message-item');
        const chatHeader = document.querySelector('.chat-header');
        const messageInput = document.querySelector('.message-input');
        const messagesContainer = document.getElementById('messages-container');
        const messageForm = document.getElementById('message-form');
        const receiverIdInput = document.getElementById('receiver-id');
        const messageInputField = document.getElementById('message-input');
        const chatUserName = document.getElementById('chat-user-name');
        const chatUserAvatar = document.getElementById('chat-user-avatar');

        // Handle message item click
        messageItems.forEach(item => {
            item.addEventListener('click', function() {
                // Remove active class from all items
                messageItems.forEach(i => i.classList.remove('active'));

                // Add active class to clicked item
                this.classList.add('active');

                // Get user data
                const userId = this.dataset.userId;
                const userName = this.dataset.userName;

                // Update chat header
                chatUserName.textContent = userName;
                chatUserAvatar.textContent = userName.charAt(0).toUpperCase();

                // Set receiver id
                receiverIdInput.value = userId;

                // Show chat header and input
                chatHeader.classList.remove('hidden');
                messageInput.classList.remove('hidden');

                // Clear welcome message and load chat messages
                loadChatMessages(userId);
            });
        });

        // Handle form submission
        messageForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const content = messageInputField.value.trim();

            if (!content) return;

            // Add message to UI immediately
            addMessageToUI(content, true);

            // Clear input
            messageInputField.value = '';

            // Send message via AJAX
            fetch('{{ route('messages.store') }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                            .getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        // Message sent successfully
                        console.log('Message sent successfully');
                    } else {
                        // Handle error
                        console.error('Error sending message');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        });

        function loadChatMessages(userId) {
            // Clear current messages
            messagesContainer.innerHTML =
                '<div class="flex justify-center"><div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div></div>';

            // Fetch messages via AJAX
            fetch(`/messages/${userId}`, {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.text())
                .then(html => {
                    messagesContainer.innerHTML = html;
                    messagesContainer.scrollTop = messagesContainer.scrollHeight;

                    // Mark messages as read
                    fetch(`/messages/${userId}/read`, {
                        method: 'PUT',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content'),
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });
                })
                .catch(error => {
                    messagesContainer.innerHTML = `
            <div class="text-center text-gray-500 py-8">
                <p>Không thể tải tin nhắn</p>
            </div>
        `;
                    console.error('Error:', error);
                });
        }

        function addMessageToUI(content, isSent) {
            const messageDiv = document.createElement('div');
            messageDiv.className = `flex ${isSent ? 'justify-end' : 'justify-start'} mb-4`;

            messageDiv.innerHTML = `
            <div class="message-bubble px-4 py-2 ${isSent ? 'message-sent' : 'message-received'}">
                <p class="text-sm">${content}</p>
                <span class="text-xs opacity-75 mt-1 block">${new Date().toLocaleTimeString('vi-VN', {hour: '2-digit', minute: '2-digit'})}</span>
            </div>
        `;

            if (messagesContainer.querySelector('.text-center')) {
                messagesContainer.innerHTML = '';
            }

            messagesContainer.appendChild(messageDiv);
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        }

        // Auto-resize textarea and handle enter key
        messageInputField.addEventListener('keypress', function(e) {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                messageForm.dispatchEvent(new Event('submit'));
            }
        });
    });
</script>

@push('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

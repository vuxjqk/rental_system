<div class="message-list space-y-4">
    @if ($messages->isEmpty())
        <div class="text-center text-gray-500 py-8">
            <i class="fas fa-comments text-4xl mb-4"></i>
            <p>Chưa có tin nhắn nào với {{ $receiver->name }}</p>
        </div>
    @else
        @foreach ($messages as $message)
            <div class="flex {{ $message->sender_id == $currentUser->id ? 'justify-end' : 'justify-start' }} mb-4">
                <div
                    class="message-bubble px-4 py-2 {{ $message->sender_id == $currentUser->id ? 'message-sent' : 'message-received' }}">
                    <p class="text-sm">{{ $message->content }}</p>
                    <span class="text-xs opacity-75 mt-1 block">{{ $message->created_at->format('H:i d/m/Y') }}</span>
                    @if ($message->receiver_id == $currentUser->id && !$message->is_read)
                        <span class="text-xs text-red-500">Chưa đọc</span>
                    @endif
                </div>
            </div>
        @endforeach
    @endif
</div>

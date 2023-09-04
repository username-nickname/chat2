<x-layout.main title="Messages">
    <div class="chat-container">
        <div class="container">
            <div class="chat__header">
                <a href="{{ route('conversations.index') }}"><i class="fa fa-solid fa-arrow-left fa-lg" style="color: white"></i></a>
                <span class="chat__user-name">{{ $otherUserName }}</span>
            </div>
        </div>
        <div class="chat">
            @if(!$messages->isEmpty())
                @foreach($messages as $message)
                    <div class="message">
                        <div class="message-sender">{{ $message->sender->name }}</div>
                        <div class="message-text">{{ Crypt::decryptString($message->body) }}</div>
                    </div>
                @endforeach
            @else
                <h3 class="text-center empty">Chat is empty</h3>
            @endif
        </div>

            <x-form action="{{ route('conversations.store', [$conversationId]) }}">
                <div class="input-box">
                    <textarea name="body" placeholder="Type your message..."></textarea>
                    <button class="btn btn-primary">Send</button>
                </div>
            </x-form>

    </div>
{{--    <script>--}}
{{--        const pusher = new Pusher('{{ config('broadcasting.connections.pusher.key') }}', {--}}
{{--            cluster: '{{ config('broadcasting.connections.pusher.options.cluster') }}',--}}
{{--            useTLS: true,--}}
{{--        });--}}

{{--        const channel = pusher.subscribe('conversation.{{ $conversationId }}');--}}
{{--        channel.bind('new-message', function(data) {--}}
{{--            var message = data;--}}
{{--            var messagesContainer = $('.chat');--}}
{{--            messagesContainer.append('<div class="message">' + '<div class="message-sender">' + message.sender_name + '</div>' + '<div class="message-text"> ' + message.body + '</div>' + '</div>');--}}
{{--            messagesContainer.scrollTop(messagesContainer[0].scrollHeight);--}}
{{--        });--}}

{{--        $(document).ready(function() {--}}
{{--            var messagesContainer = $('.chat');--}}
{{--            messagesContainer.scrollTop(messagesContainer[0].scrollHeight);--}}
{{--        });--}}

{{--    </script>--}}
    <script>
        const pusher = new Pusher('{{ config('broadcasting.connections.pusher.key') }}', {
            cluster: '{{ config('broadcasting.connections.pusher.options.cluster') }}',
            useTLS: true,
        });

        const channel = pusher.subscribe('conversation.{{ $conversationId }}');
        channel.bind('new-message', function(data) {
            var message = data;
            var messagesContainer = $('.chat');
            messagesContainer.append('<div class="message">' + '<div class="message-sender">' + message.sender_name + '</div>' + '<div class="message-text"> ' + message.body + '</div>' + '</div>');
            messagesContainer.scrollTop(messagesContainer[0].scrollHeight);
        });

        $(document).ready(function() {
            var messagesContainer = $('.chat');
            messagesContainer.scrollTop(messagesContainer[0].scrollHeight);

            $('form').submit(function(event) {
                event.preventDefault();

                var formData = $(this).serialize();

                $.ajax({
                    url: '{{ route('conversations.store', [$conversationId]) }}',
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        $('textarea[name="body"]').val('');
                        $('.empty').html('');
                    }
                });
            });
        });
    </script>

</x-layout.main>

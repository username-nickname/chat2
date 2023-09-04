<x-layout.main title="Messages">
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="chat-box">
                    <h2 class="mb-4">Chat</h2>

                    <!-- Search form -->
                    <x-form action="" method="GET" class="search-form" id="search-form">
                        <input type="text" name="search" class="form-control search-input" id="search-input" placeholder="Search users...">
                        <button type="submit" class="btn btn-primary search-btn">Search</button>
                    </x-form>

                    <!-- List of users -->
                    <div id="users">

                    </div>
                    <h4>Recent Conversations</h4>
                    @if ($conversations->isEmpty())
                        <p>No conversations found.</p>
                    @else
                        <ul class="user-list">
                            @foreach($conversations as $conversation)
                                <li class="user-list-item">
                                    <div class="user-avatar"></div>
{{--                                    {{ route('conversations.show', $conversation->id) }}--}}
                                    <a href="{{ route('conversations.show', $conversation->id) }}" class="user-name">
                                        @if ($conversation->user1_id == auth()->user()->id)
                                            {{ $secondUsers->find($conversation->user2_id)->name }}
                                        @else
                                            {{ $secondUsers->find($conversation->user1_id)->name }}
                                        @endif
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#search-form').submit(function(e) {
                e.preventDefault();
                var query = $('#search-input').val();
                $.ajax({
                    type: 'GET',
                    url: '{{ route('search.users') }}',
                    data: { query: query },
                    success: function(data) {
                        var userList = $('#users');
                        userList.empty(); // Очищаем текущий список пользователей
                        if (Array.isArray(data) && data.length > 0) {
                            data.forEach(function(user) {
                                var listItem = $('<li>').addClass('user-list-item');
                                var avatar = $('<div>').addClass('user-avatar');
                                var userName = $('<a>')
                                    .addClass('user-name')
                                    .attr('href', `{{ url('conversations/show-or-create') }}/${user.id}`)
                                    .text(user.name);
                                listItem.append(avatar);
                                listItem.append(userName);
                                userList.append(listItem);
                            });
                        } else {
                            userList.append('<p>No users found.</p>'); // Выводим сообщение, если список пользователей пуст
                        }
                    }
                });
            });
        });
    </script>
</x-layout.main>

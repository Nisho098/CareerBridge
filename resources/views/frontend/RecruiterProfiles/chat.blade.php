<!DOCTYPE html>
<html lang="en">
<head>
<meta name="csrf-token" content="{{ csrf_token() }}">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WhatsApp-Style Chat</title>
    <link rel="stylesheet" href="{{ asset('css/chat.css') }}">
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.15.3/dist/echo.iife.js"></script>
</head>
<body>
    <div class="chat-app">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-header">
                <h2>Career Bridge</h2>
            </div>
            <div class="contact-list">
                @foreach($users as $user)
                    <div class="contact" onclick="openChat('{{ $user->id }}', '{{ $user->name }}')">
                    <img src="{{ asset('profile.png') }}" alt="Profile">

                        <div>
                            <h3>{{ $user->name }}</h3>
                            <p>Last message...</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Chat Window -->
        <div class="chat-container">
            <div class="chat-header">
                <img src="profile.png" alt="Profile" class="profile-pic">
                <h2 id="chat-name">Select a chat</h2>
            </div>
            <div id="chat-box" class="chat-box"></div>
            <div class="chat-input">
                <input type="text" id="username" placeholder="Your Name" value="{{ Auth::user()->name }}" readonly>
                <input type="text" id="message" placeholder="Type a message...">
                <button onclick="sendMessage()">➤</button>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/chat.js') }}"></script>
</body>
</html>
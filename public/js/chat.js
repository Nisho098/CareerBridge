let currentChat = "";
let currentRecipientId = "";

// Initialize Pusher
const pusher = new Pusher("your-pusher-key", {
    cluster: "your-pusher-cluster",
    encrypted: true
});

// Initialize Laravel Echo
const echo = new Echo({
    broadcaster: "pusher",
    key: "your-pusher-key",
    cluster: "your-pusher-cluster",
    forceTLS: true
});

// Function to open a chat
function openChat(name, recipientId) {
    // Leave previous chat if already subscribed
    if (currentRecipientId) {
        echo.leave(`chat.${currentRecipientId}`);
    }

    // Set new chat details
    currentChat = name;
    currentRecipientId = recipientId;
    document.getElementById("chat-name").innerText = name;
    document.getElementById("chat-box").innerHTML = ""; // Clear messages

    // Subscribe to the new chat channel
    listenToChat(recipientId);
}

// Function to send a message
function sendMessage() {
    const message = document.getElementById("message").value.trim();
    const username = document.getElementById("username").value.trim();

    if (!message || !username || !currentRecipientId) {
        alert("Please select a chat, enter your name, and type a message.");
        return;
    }

    fetch("/send-message", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            message: message,
            username: username,
            recipient: currentRecipientId
        })
    })
    .then(response => response.json())
    .then(data => {
        console.log("Message sent:", data);
        document.getElementById("message").value = "";
    })
    .catch(error => {
        console.error("Error:", error);
    });
}

// Function to append messages inside chat-box
function appendMessage(message, sender, type = "received") {
    let chatBox = document.getElementById("chat-box");
    let msgDiv = document.createElement("div");
    msgDiv.classList.add("message", type);

    let currentTime = new Date().toLocaleTimeString([], { hour: "2-digit", minute: "2-digit" });
    msgDiv.innerHTML = `<span class="sender">${sender}</span><p>${message}</p><span class="timestamp">${currentTime}</span>`;

    chatBox.appendChild(msgDiv);
    chatBox.scrollTop = chatBox.scrollHeight; // Auto-scroll to latest message
}

// Function to listen to messages from Laravel WebSockets
function listenToChat(recipientId) {
    console.log(`Listening to chat.${recipientId}`);
    
    echo.private(`chat.${recipientId}`)
        .listen(".new-message", (data) => { // ✅ Correct event name
            console.log("New message received:", data);
            appendMessage(data.message, data.username, "received");
        })
        .error((err) => {
            console.error("WebSocket Error:", err);
        });
}

// Auto-scroll chat box to latest message
function scrollChatToBottom() {
    let chatBox = document.getElementById("chat-box");
    chatBox.scrollTop = chatBox.scrollHeight;
}

// Attach event listener for the Enter key in the input box
document.getElementById("message").addEventListener("keypress", function (e) {
    if (e.key === "Enter") {
        sendMessage();
    }
});

<!-- resources/views/chatbot.blade.php -->
<div id="chat-container">
    <div id="messages"></div>
    <input type="text" id="user-input" placeholder="Type a message...">
    <button onclick="sendMessage()">Send</button>
</div>

<script>
    async function sendMessage() {
        let message = document.getElementById('user-input').value;
        let response = await fetch('/chatbot', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ message: message })
        });
        let responseData = await response.json();
        document.getElementById('messages').innerHTML += `<p>User: ${message}</p><p>Bot: ${responseData.response}</p>`;
    }
</script>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monitoring Creatures Chatbot</title>
    <style>
        h2 {
            font-family: "Bebas Neue", "Lobster", "Oswald"!important;
            font-size: 30px;
            text-align: center;
            color: #ffcc80;
            margin: 10px 0;
        }

        /* Full-screen background setup */
        body {
            font-family: Arial, sans-serif;
            background-image: url('/images/monitoring-creatures.png'); /* Path to the image */
            background-size: cover;
            background-position: center;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            color: white;
        }

        /* Chat container styling */
        #chat-container {
            width: 90%;
            max-width: 400px;
            height: 550px;
            background-color: rgba(0, 0, 0, 0.7); /* Semi-transparent dark background */
            border-radius: 8px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            padding: 15px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        }

        /* Chatbox styling */
        #chat-box {
            flex-grow: 1;
            overflow-y: auto;
            margin-bottom: 10px;
            display: flex;
            flex-direction: column;
            gap: 8px;
            padding-right: 10px;
        }

        /* Chat message styling */
        .message {
            padding: 10px 15px;
            border-radius: 18px;
            max-width: 75%;
            font-size: 15px;
            line-height: 1.4;
            word-wrap: break-word;
        }

        .user-message {
            background: linear-gradient(135deg, #E39900, #E39900); /* Instagram-style blue gradient */
            color: white;
            align-self: flex-end;
            text-align: left;
            border-bottom-right-radius: 2px;
        }

        .bot-response {
            background-color: #f0f0f0; /* Light grey for bot responses */
            color: black;
            align-self: flex-start;
            text-align: left;
            border-bottom-left-radius: 2px;
        }

        /* Input and button styling */
        #user-message {
            width: calc(100% - 70px);
            padding: 10px;
            border: none;
            border-radius: 5px;
            margin-right: 10px;
            font-size: 16px;
            outline: none;
        }

        #send-button {
            padding: 10px 20px;
            font-size: 16px;
            color: white;
            background-color: #ff7043; /* Orange button */
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        #send-button:hover {
            background-color: #ff5722;
        }

        /* Scrollbar styling for chat-box */
        #chat-box::-webkit-scrollbar {
            width: 8px;
        }

        #chat-box::-webkit-scrollbar-thumb {
            background-color: #555;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <div id="chat-container">
        <h2>Monitoring Creatures Chatbot</h2>
        <div id="chat-box"></div>

        <!-- User input and send button container -->
        <div style="display: flex;">
            <input type="text" id="user-message" placeholder="Type your message...">
            <button id="send-button">Send</button>
        </div>
    </div>

    <script>
        document.getElementById('send-button').addEventListener('click', function() {
            let userMessage = document.getElementById('user-message').value;
            if (userMessage.trim() === '') return;

            // Display user's message in the chat container
            let chatBox = document.getElementById('chat-box');
            chatBox.innerHTML += `<div class="message user-message">${userMessage}</div>`;
            document.getElementById('user-message').value = '';

            // Send the message to the backend for a response
            fetch('/chat/respond', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ message: userMessage })
            })
            .then(response => response.json())
            .then(data => {
                // Display the bot's response in the chat container
                chatBox.innerHTML += `<div class="message bot-response">${data.response}</div>`;
                chatBox.scrollTop = chatBox.scrollHeight; // Scroll to the bottom
            })
            .catch(error => {
                console.error("Error:", error);
                chatBox.innerHTML += `<div class="message bot-response">Sorry, there was an error processing your request.</div>`;
                chatBox.scrollTop = chatBox.scrollHeight;
            });
        });
    </script>

</body>
</html>

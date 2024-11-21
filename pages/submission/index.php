<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Group Chat</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">

<div class="max-w-4xl mx-auto p-6 bg-white rounded-lg shadow-md mt-6">
    <h1 class="text-2xl font-bold mb-4">Group Chat</h1>
    <div id="messages-container" class="h-96 overflow-y-auto border border-gray-300 rounded-lg p-4 bg-gray-50">
        <!-- Messages will load here -->
    </div>

    <form id="chat-form" class="mt-4 flex">
        <input type="text" id="user_name" name="user_name" placeholder="Your Name"
               class="w-1/4 p-2 border border-gray-300 rounded-l-lg focus:outline-none focus:ring">
        <input type="text" id="message" name="message" placeholder="Type your message"
               class="w-2/4 p-2 border border-gray-300 focus:outline-none focus:ring">
        <button type="submit"
                class="w-1/4 p-2 bg-blue-600 text-white rounded-r-lg hover:bg-blue-700 focus:outline-none">
            Send
        </button>
    </form>
</div>

<script>
    // Fetch messages
    function fetchMessages() {
        fetch('fetch_messages.php')
            .then(response => response.json())
            .then(data => {
                const container = document.getElementById('messages-container');
                container.innerHTML = '';
                data.forEach(msg => {
                    const messageElement = document.createElement('div');
                    messageElement.classList.add('p-2', 'mb-2', 'bg-white', 'rounded-lg', 'shadow');
                    messageElement.innerHTML = `
                        <p class="font-bold">${msg.user_name}</p>
                        <p>${msg.message}</p>
                        <p class="text-sm text-gray-500">${new Date(msg.created_at).toLocaleString()}</p>
                    `;
                    container.appendChild(messageElement);
                });
                container.scrollTop = container.scrollHeight; // Auto-scroll
            })
            .catch(console.error);
    }

    // Send message
    document.getElementById('chat-form').addEventListener('submit', function (event) {
        event.preventDefault();
        const userName = document.getElementById('user_name').value || 'Anonymous';
        const message = document.getElementById('message').value;

        fetch('send_message.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `user_name=${encodeURIComponent(userName)}&message=${encodeURIComponent(message)}`
        }).then(response => response.json())
          .then(() => {
              document.getElementById('message').value = ''; // Clear the input
              fetchMessages(); // Refresh messages
          })
          .catch(console.error);
    });

    // Auto-refresh messages every 5 seconds
    setInterval(fetchMessages, 5000);
    fetchMessages(); // Initial fetch
</script>
</body>
</html>

<!doctype html>
<html>
<head>
    <title>OpenAI Assistant Chat</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <style>
        @font-face {
            font-family: "ColfaxAI";
            src: url(https://cdn.openai.com/API/fonts/ColfaxAIRegular.woff2) format("woff2"),
            url(https://cdn.openai.com/API/fonts/ColfaxAIRegular.woff) format("woff");
            font-weight: normal;
            font-style: normal;
        }

        @font-face {
            font-family: "ColfaxAI";
            src: url(https://cdn.openai.com/API/fonts/ColfaxAIBold.woff2) format("woff2"),
            url(https://cdn.openai.com/API/fonts/ColfaxAIBold.woff) format("woff");
            font-weight: bold;
            font-style: normal;
        }

        body,
        input {
            line-height: 24px;
            color: #353740;
            font-family: "ColfaxAI", Helvetica, sans-serif;
        }

        body {
            display: flex;
            flex-direction: column; /* Change to row to align children horizontally */
            align-items: stretch; /* Align items at the start of the cross axis */
            justify-content: center; /* Center items on the main axis */
            width: 100%; /* Ensure full width */
            margin: 0; /* Remove default margin */
            padding: 0; /* Remove default padding */
            overflow: hidden;
        }

        .icon {
            width: 34px;
        }

        h3 {
            font-size: 32px;
            line-height: 40px;
            font-weight: bold;
            color: #202123;
            margin: 16px 0 40px;
        }

        .chat-container {
            width: 100%;
            padding: 20px;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            float: right;
            overflow-y: auto;
            box-sizing: border-box;
            justify-content: space-between;
        }

        .user-message,
        .assistant-message {
            padding: 12px 16px;
            border-radius: 4px;
            margin-bottom: 8px;
            max-width: 80%;
            word-wrap: break-word;
            font-size: 16px;
        }

        .user-message {
            align-self: flex-end !important;
            background-color: #f7f7f8;
        }

        .assistant-message {
            align-self: flex-start !important;
            background-color: #ebfaeb;
        }

        .message-input-container {
            position: relative;
            width: 100%; /* Match the chat container's width */
            background: #fff;
            box-sizing: border-box;
            display: flex;
            justify-content: center;
            align-items: start;
            z-index: 100;
        }

        .message-input-container form {
            display: flex; /* Use flexbox to layout children */
            align-items: center; /* Align items vertically */
            width: 100%; /* Take full width to accommodate children */
        }

        form {
            max-width: 600px;
            width: 100%;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        textarea {
            border: 1px solid #c5c5d2;
            border-radius: 8px;
            margin-bottom: 24px;
            width: calc(100% - 20px);
            resize: vertical;
            overflow: auto;
            margin: 0;
            margin-right: 10px;
            flex-grow: 1;
            padding: 8px 12px;
            max-height: 32px;
            box-sizing: border-box; /* Include padding in the element's total dimensions */
        }

        input[type="submit"],
        input[type="button"] {
            padding: 12px 16px;
            color: #fff;
            background-color: #10a37f;
            border: none;
            border-radius: 4px;
            text-align: center;
            cursor: pointer;
            flex: 1;
            margin: 0 2px;
        }

        input[type="submit"] {
            flex-grow: 4;
        }

        input[type="button"] {
            flex-grow: 1;
            background-color: #f44336;
        }

        ::placeholder {
            color: #8e8ea0;
            opacity: 1;
        }

        .result {
            font-weight: bold;
            margin-top: 40px;
        }

        .typing-indicator-container {
            display: flex;
            justify-content: flex-start;
        }

        .typing-indicator {
            margin-left: 4px;
            font-size: 16px; /* Adjust size as needed */
        }

        .typing-indicator::after {
            content: "•";
            animation: typing 1.5s infinite step-start;
        }

        @keyframes typing {
            0%,
            100% {
                content: "•";
            }
            33% {
                content: "••";
            }
            66% {
                content: "•••";
            }
        }

        .button-group {
            display: flex;
            align-items: center; /* Add this to vertically center the elements */
            justify-content: space-between; /* Adjust as needed */
        }

        .file-upload-input {
            display: none; /* Hide the actual input */
        }

        #upload-banner {
            display: none;
            position: fixed;
            top: 0;
            width: 100%;
            background-color: #10a37f;
            color: white;
            text-align: center;
            padding: 10px;
            z-index: 1000;
        }

        #ids-container {
            font-size: 9px;
            margin-bottom: 20px;
            text-align: center;
        }

        /* The Modal (background) */
        .modal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 1; /* Sit on top */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgb(0, 0, 0); /* Fallback color */
            background-color: rgba(0, 0, 0, 0.4); /* Black w/ opacity */
        }

        /* Modal Content */
        .modal-content {
            background-color: #fefefe;
            margin: 15% auto; /* 15% from the top and centered */
            padding: 20px;
            border: 1px solid #888;
            width: 80%; /* Could be more or less, depending on screen size */
        }

        /* The Close Button */
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        .file-icon {
            cursor: pointer;
            color: #000;
            display: inline-block;
            font-size: 24px;
            padding-left: 5px;
        }

        .header {
            background-color: white;
            width: 100%;
            padding: 10px 0;
            display: flex; /* Add this line */
            align-items: center; /* Center items vertically */
            justify-content: start;
        }

        .header img {
            height: 20px;
            margin-right: 10px;
        }

        .header .demo-text {
            font-size: 15px;
            font-weight: bold;
        }

        .message-role {
            align-self: flex-start;
            font-size: 12pt;
            color: #000000;
            margin-bottom: 4px;
        }

        .message-role.user {
            align-self: flex-end;
        }

        #send-btn, .send-btn {
            width: 42px;
            height: 32px;
            border-radius: 4px;
            border: 1px solid #c5c5d2;
            background-color: #10a37f;
            color: #fff;
            cursor: pointer;
            justify-content: center;
            align-items: center;
        }

        .file-upload-section {
            /* display: flex; */
            width: 600px;
            max-width: 600px;
            flex-direction: column;
            justify-content: space-around; /* Adjust content distribution */
            align-items: center; /* Center content horizontally */
            padding: 20px;
            box-sizing: border-box;
            border-right: 1px solid #c5c5d2; /* Optional: border to separate from the chat section */
        }

        .centered-text {
            padding: 20px;
            text-align: center; /* Center the text inside the div */
            width: 100%; /* Ensure the div takes up the full width */
        }

        .file-upload-btn,
        .file-upload-input + label {
            margin-top: auto; /* Push the button to the bottom */
            width: calc(
                100% - 40px
            ); /* Adjust width to ensure it fits within the parent's padding */
            padding: 4px 8px;
            cursor: pointer;
            background-color: #10a37f;
            color: white;
            border: none;
            max-height: 32px;
            border-radius: 8px;
            box-sizing: border-box;
            text-align: center;
        }

        /* Clear floats */
        body::after {
            content: none;
        }

        .file-upload-section,
        .chat-container {
            float: none;
        }

        .main-content {
            display: flex;
            flex-direction: row; /* Align children (file upload section and chat container) horizontally */
            height: 100vh; /* Adjust height based on header height */
            overflow: auto; /* Allow scrolling within this container */
            align-items: stretch;
        }

        .messages {
            flex-grow: 1; /* Allow this container to take up available space */
            overflow-y: auto; /* Scroll if content exceeds height */
            display: flex;
            flex-direction: column;
            min-height: 300px;
            max-height: 300px;
        }

        .hidden {
            display: none;
        }

        #filesList {
            width: 100%;
        }

        .file-entry {
            display: flex;
            justify-content: space-between;
            align-items: center; /* Vertically center the items */
            gap: 10px; /* Add some space between the icon and the text */
            padding-bottom: 15px;
        }

        .file-entry div {
            display: flex;
            align-items: center;
        }

        .file-entry span {
            flex-grow: 1; /* Allows the file ID to take up any available space */
            margin: 0 10px; /* Adds some spacing around the file ID */
        }

        #filesDivider {
            border-top: 1px solid #ececf1; /* Sets the color and height of the divider */
            width: 100%; /* Ensures the divider stretches across the full width of its container */
        }

    </style>
</head>
<body>
<div class="chat-container">
    <div class="messages">
        @foreach ($conversations as $conversation)
            @if($conversation['role'] == 'user')
                <div class="message-role user">User</div>
                <div class="user-message">
                    {!! nl2br($conversation['content']) !!}
                </div>
            @endif
            @if($conversation['role'] == 'assistant')
                <div class="message-role">Assistant</div>
                <div class="assistant-message">
                    {!! nl2br($conversation['content']) !!}
                </div>
            @endif
        @endforeach
    </div>
    <div class="message-input-container">
        <form id="form-chat" action="#" method="post">
            <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
            <input type="hidden" name="collection_name" value="{{$bot->code}}"/>
            <textarea
                name="message"
                placeholder="Enter your message"
                required
            ></textarea>
            <div class="button-group">
                <button type="submit" id="send-btn">&#x2191;</button>
            </div>
        </form>
    </div>
</div>
<script>
    document
        .getElementById("form-chat")
        .addEventListener("submit", function (event) {
            event.preventDefault();
            const messageInput = document.querySelector(
                'textarea[name="message"]'
            );
            const collectionInput = document.querySelector(
                'input[name="collection_name"]'
            );
            const message = messageInput.value.trim();
            const collection_name = collectionInput.value.trim();
            const chatContainer = document.querySelector(".messages");
            // Append the user's message to the chat container
            if (message) {
                const roleDiv = document.createElement("div");
                roleDiv.classList.add("message-role");
                roleDiv.classList.add("user");

                roleDiv.textContent = "User";
                chatContainer.appendChild(roleDiv);

                const userMessageDiv = document.createElement("div");
                userMessageDiv.classList.add("user-message");
                userMessageDiv.textContent = message;
                chatContainer.appendChild(userMessageDiv);
            }
            // Clear the message input
            messageInput.value = "";
            // Send the user's message to the server using AJAX
            fetch("/api/chat", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify({message: message, collection_name: collection_name}),
            })
                .then((response) => response.json())
                .then((data) => {
                    if (data.success) {
                        const roleDiv = document.createElement("div");
                        roleDiv.classList.add("message-role");
                        roleDiv.classList.add("assistant");

                        roleDiv.textContent = "Assistant";
                        chatContainer.appendChild(roleDiv);

                        // Remove the typing indicator
                        typingIndicator.remove();

                        // Append the assistant's message to the chat container
                        const assistantMessageDiv = document.createElement("div");
                        assistantMessageDiv.classList.add("assistant-message");
                        assistantMessageDiv.innerHTML = data.message.replace(/\n/g, "<br />");
                        chatContainer.appendChild(assistantMessageDiv);
                        // Scroll to the bottom of the chat container
                        chatContainer.scrollTop = chatContainer.scrollHeight;
                    }
                })
                .catch((error) => {
                    console.error("Error:", error);
                });

            // Create a typing indicator container
            const typingIndicatorContainer = document.createElement("div");
            typingIndicatorContainer.classList.add("typing-indicator-container");

            // Create a typing indicator
            const typingIndicator = document.createElement("div");
            typingIndicator.classList.add("typing-indicator");
            typingIndicator.textContent = "•••";

            // Append the typing indicator to its container
            typingIndicatorContainer.appendChild(typingIndicator);

            // Append the typing indicator container to the chat container
            chatContainer.appendChild(typingIndicatorContainer);

            // Scroll to the bottom of the chat container
            chatContainer.scrollTop = chatContainer.scrollHeight;
        });
</script>
</body>
</html>

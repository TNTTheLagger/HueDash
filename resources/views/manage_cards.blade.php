<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Manage Cards</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=IBM+Plex+Mono:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;1,100;1,200;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet">

    <style>
        body {
            font-family: 'IBM Plex Mono', monospace;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f0f0f0;
        }

        .container {
            width: 80%;
            max-width: 800px;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
        }

        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .form-group button {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .form-group button:hover {
            background-color: #0056b3;
        }

        .card-list {
            margin-top: 20px;
            max-height: 400px;
            /* Set a max height for the card list */
            overflow-y: auto;
            /* Enable vertical scrolling */
        }

        .card-item {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-bottom: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card-item button {
            padding: 5px 10px;
            background-color: #dc3545;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .card-item button:hover {
            background-color: #c82333;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Manage Cards</h1>
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" id="title" placeholder="Enter card title">
        </div>
        <div class="form-group">
            <label for="body">Body</label>
            <textarea id="body" rows="4" placeholder="Enter card body"></textarea>
        </div>
        <div class="form-group">
            <label for="urgency">Urgency</label>
            <select id="urgency">
                <option value="">None</option>
                <option value="high">High</option>
                <option value="medium">Medium</option>
                <option value="low">Low</option>
            </select>
        </div>
        <div class="form-group">
            <label for="topic">Topic</label>
            <select id="topic">
                <option value="">Select a topic</option>
                <!-- Topics will be dynamically added here -->
            </select>
        </div>
        <div class="form-group">
            <button onclick="addCard()">Add Card</button>
        </div>

        <div class="form-group">
            <h2>Manage Topics</h2>
            <label for="new-topic">New Topic</label>
            <input type="text" id="new-topic" placeholder="Enter new topic">
            <button onclick="addTopic()">Add Topic</button>
        </div>

        <div class="form-group">
            <label for="topics-list">Existing Topics</label>
            <select id="topics-list">
                <!-- Topics will be dynamically added here -->
            </select>
            <button onclick="deleteTopic()">Delete Topic</button>
        </div>

        <div class="card-list" id="card-list">
            <!-- Cards will be dynamically added here -->
        </div>
    </div>

    <script>
        async function fetchTopics() {
            const response = await fetch('/topics');
            const data = await response.json();
            const topicSelect = document.getElementById('topic');
            const topicsList = document.getElementById('topics-list');
            topicSelect.innerHTML = '<option value="">Select a topic</option>';
            topicsList.innerHTML = '';
            data.forEach(topic => {
                const option = document.createElement('option');
                option.value = topic.id;
                option.textContent = topic.name;
                topicSelect.appendChild(option);

                const listOption = document.createElement('option');
                listOption.value = topic.id;
                listOption.textContent = topic.name;
                topicsList.appendChild(listOption);
            });
        }

        async function fetchCardData() {
            const topic = window.location.pathname.split('/').pop();
            const response = await fetch(`/cards`);
            const data = await response.json();
            const cardList = document.getElementById('card-list');
            cardList.innerHTML = '';

            data.forEach(card => {
                const cardItem = document.createElement('div');
                cardItem.classList.add('card-item');
                cardItem.innerHTML = `
                    <div>
                        <strong>${card.title}</strong>
                        <p>${card.body}</p>
                        <small>${card.urgency ? card.urgency : 'No urgency'}</small>
                    </div>
                    <button onclick="deleteCard(${card.id})">Delete</button>
                `;
                cardList.appendChild(cardItem);
            });
        }

        async function addCard() {
            const title = document.getElementById('title').value;
            const body = document.getElementById('body').value;
            const urgency = document.getElementById('urgency').value;
            const topicId = document.getElementById('topic').value;

            const response = await fetch('/cards', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    title,
                    body,
                    urgency,
                    topic_id: topicId
                }),
            });

            if (response.ok) {
                fetchCardData();
            } else {
                const errorData = await response.json();
                alert('Error: ' + JSON.stringify(errorData.errors));
            }
        }

        async function addTopic() {
            const name = document.getElementById('new-topic').value;
            const response = await fetch('/topics', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    name
                }),
            });

            if (response.ok) {
                fetchTopics();
            } else {
                const errorData = await response.json();
                alert('Error: ' + JSON.stringify(errorData.errors));
            }
        }

        async function deleteTopic() {
            const topicId = document.getElementById('topics-list').value;
            const response = await fetch(`/topics/${topicId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
            });

            if (response.ok) {
                fetchTopics();
            } else {
                const errorData = await response.json();
                alert('Error: ' + errorData.error);
            }
        }

        async function deleteCard(id) {
            const response = await fetch(`/cards/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
            });

            if (response.ok) {
                fetchCardData();
            } else {
                const errorData = await response.json();
                alert('Error: ' + errorData.error);
            }
        }

        fetchTopics();
        fetchCardData();
    </script>
</body>

</html>

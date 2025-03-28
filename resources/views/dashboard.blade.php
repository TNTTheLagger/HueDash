<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard</title>

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
            align-items: flex-start;
            height: 100vh;
            overflow: hidden;
            position: relative;
            background-color: black;
            /* Set background to black */
            color: white;
            /* Set text color to white */
        }

        .dashboard {
            column-count: 4;
            column-gap: 5px;
            width: 95%;
            padding-top: 20px;
            height: 100%;
        }

        .card {
            display: inline-block;
            width: 100%;
            margin-bottom: 5px;
            background: rgba(255, 255, 255, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.3);
            backdrop-filter: blur(10px);
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 10px;
            box-sizing: border-box;
            break-inside: avoid;
            -webkit-column-break-inside: avoid;
            -moz-column-break-inside: avoid;
            opacity: 0;
            transition: opacity 0.5s ease-in-out;
            overflow: hidden;
            /* Prevent scroll bars */
            text-overflow: ellipsis;
            /* Ensure text wraps */
            white-space: normal;
            /* Ensure text wraps */
            color: white;
            /* Ensure card text is readable */
            min-width: 250px;
            /* Set minimum width for cards */
        }

        .card.show {
            opacity: 1;
        }

        .card.remove {
            opacity: 0;
            transition: opacity 1s ease-in-out;
            /* Add transition for fade out */
        }

        .card-header {
            font-weight: bold;
            margin-bottom: 5px;
            overflow-wrap: break-word;
            position: relative;
        }

        .card-topic {
            position: absolute;
            top: 0;
            right: 0;
            font-size: 10px;
            color: white;
        }

        .card-body {
            font-size: 14px;
            overflow-wrap: break-word;
        }

        .urgent-high {
            border-left: 5px solid red;
        }

        .urgent-medium {
            border-left: 5px solid orange;
        }

        .urgent-low {
            border-left: 5px solid green;
        }

        .error-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 24px;
            z-index: 1000;
            backdrop-filter: blur(10px);
            opacity: 0;
            transition: opacity 0.5s ease-in-out;
        }

        .error-overlay.show {
            opacity: 1;
        }

        @media (max-width: 1200px) {
            .dashboard {
                column-count: 3;
                /* Adjust columns for smaller screens */
            }
        }

        @media (max-width: 900px) {
            .dashboard {
                column-count: 2;
                /* Adjust columns for smaller screens */
            }
        }

        @media (max-width: 600px) {
            .dashboard {
                column-count: 1;
                /* Adjust columns for smaller screens */
            }
        }
    </style>

<body>
    <div class="dashboard" id="dashboard">
    </div>

    <div class="error-overlay" id="error-overlay">
        NO SERVER CONNECTION
    </div>

    <script>
        let existingCards = {};

        async function fetchCardData() {
            try {
                const topic = "{{ request('topic') }}"; // Get the topic from the query parameter
                const response = await fetch(`/cards${topic ? '?topic=' + topic : ''}`);
                if (!response.ok) throw new Error('Network response was not ok');
                const data = await response.json();
                const dashboard = document.getElementById('dashboard');
                const errorOverlay = document.getElementById('error-overlay');
                errorOverlay.classList.remove('show');

                const newCards = {};
                data.forEach(card => {
                    newCards[card.id] = card;
                    if (!existingCards[card.id]) {
                        const cardElement = document.createElement('div');
                        cardElement.classList.add('card');
                        cardElement.setAttribute('data-id', card.id);
                        if (card.urgency) {
                            cardElement.classList.add(`urgent-${card.urgency.toLowerCase()}`);
                        }

                        cardElement.innerHTML = `
                                <div class="card-header">
                                    ${card.title}
                                    <span class="card-topic">${card.topic ? card.topic.name : ''}</span>
                                </div>
                                <div class="card-body">${card.body}</div>
                            `;
                        dashboard.appendChild(cardElement);
                        setTimeout(() => cardElement.classList.add('show'), 10);
                    }
                });

                // Remove cards that are no longer in the new data
                Object.keys(existingCards).forEach(id => {
                    if (!newCards[id]) {
                        const cardElement = document.querySelector(`.card[data-id="${id}"]`);
                        if (cardElement) {
                            cardElement.classList.add('remove');
                            setTimeout(() => cardElement.remove(), 500); // Delay removal to allow fade out
                        }
                    }
                });

                // Move existing cards to match the new order
                const sortedCardElements = Array.from(dashboard.children).sort((a, b) => {
                    const priorityOrder = {
                        'high': 1,
                        'medium': 2,
                        'low': 3
                    };
                    const aPriority = priorityOrder[a.classList[1]?.split('-')[1]] || 4;
                    const bPriority = priorityOrder[b.classList[1]?.split('-')[1]] || 4;
                    return aPriority - bPriority;
                });
                sortedCardElements.forEach(cardElement => {
                    cardElement.style.transition = 'opacity 0.5s ease-in-out';
                    dashboard.appendChild(cardElement);
                });

                existingCards = newCards;
            } catch (error) {
                document.getElementById('error-overlay').classList.add('show');
            }
        }

        setInterval(fetchCardData, 2500); // Update every 5 seconds
        fetchCardData(); // Initial fetch
    </script>
</body>

</html>

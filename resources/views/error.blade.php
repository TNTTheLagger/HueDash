<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Error</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Mono:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'IBM Plex Mono', monospace;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: black;
            color: white;
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

        .error-message {
            text-align: center;
        }

        .error-message h1 {
            font-size: 3rem;
            margin-bottom: 1rem;
        }

        .error-message p {
            font-size: 1.5rem;
        }
    </style>
</head>

<body>
    <div class="error-overlay" id="error-overlay">
        <div class="error-message">
            <h1>Error</h1>
            <p>{{ $message }}</p>
        </div>
    </div>

    <script>
        window.onload = function() {
            setTimeout(() => {
                document.getElementById('error-overlay').classList.add('show');
            }, 10);
        };
    </script>
</body>

</html>

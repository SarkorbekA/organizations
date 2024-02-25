<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Birthday Greetings</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #333;
        }

        p {
            color: #666;
            line-height: 1.6;
        }

    </style>
</head>
<body>
<div class="container">
    <h1>Happy Birthday, {{ $user->surname }} {{ $user->name }}!</h1>
    <p>May your special day be filled with love, happiness, and joy. Wishing you all the best!</p>
    <p>Best regards,<br>Your friend, Sarkor</p>
</div>
</body>
</html>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Confirmation</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 30px 25px 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #333;
            font-size: 20px;
            line-height: 140%;
            font-family: sans-serif;
        }

        p {
            color: #666;
            line-height: 1.6;
            text-align: center;
            font-size: 18px;
            margin-top: 20px;
            margin-bottom: 16px;
        }

        .code {
            width: 100%;
            text-align: center;
            padding: 15px 10px;
            background-color: #f4f0ff;
            border-radius: 12px;
            color: black;
            letter-spacing: 2px;
            font-size: 20px;
            font-weight: 700;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Congratulations {{ $user->name }}! You have successfully registered on our platform. However, before you can
            start enjoying all the benefits, we kindly ask you to verify your email address.</h1>
        <p>Here is your confirmation code:</p>
        <div class="code">
            <h3>{{ $random }}</h3>
        </div>
    </div>
</body>

</html>

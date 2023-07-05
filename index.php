<?php
// start server session
session_start();
?>

<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        .container {
            text-align: center;
        }

        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
    </style>
</head>

<body>
    <div class="container">
        <form action="qrcode.php" method="post">
            <label for="email">Enter your mail</label>
            <input type="email" name="email" id="email" /><br>
            <label for="password">Enter your password</label>
            <input type="password" name="password" id="password" /><br>
            <input type="submit" name="submit">
        </form>
    </div>

</body>

</html>
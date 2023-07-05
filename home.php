<?php

session_start();

if (!isset($_SESSION['user'])) {
    header("Location: index.php");
}

if (isset($_POST['logout'])) {
    session_start();
    unset($_SESSION['google2fa_user']);
    unset($_SESSION['user']);
    session_destroy();
    header("Location:index.php");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>

<body>
    <h1>Welcome back!</h1>
    <form action="" method="post">
        <input type="submit" name="logout" value="Logout">
    </form>
</body>

</html>
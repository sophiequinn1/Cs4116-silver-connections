<?php
session_start();
require 'config.php';
require 'navbar.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Silver Connections</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to your CSS file -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<div class="login-container">
    <img src="title.PNG" alt="Silver Connections Title">
    <form action="login.php" method="post">
        <label>
            <input type="text" name="username" placeholder="Username...">
        </label>
        <br>
        <label>
            <input type="password" name="password" placeholder="Password...">
        </label>
        <br>
        <input type="submit" value="Login" class="btn">
    </form>
    <a href="register_page.php" class="register-button btn btn-link">Register</a>

    <span class="button-checkbox">
        <a href="forgotPassword.php" class="btn btn-link">Forgot Password?</a>
    </span>

</div>

</body>
</html>
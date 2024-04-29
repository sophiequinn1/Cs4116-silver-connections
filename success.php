<?php
require 'config.php';
require 'navbar.php';
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    //a test
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Success - Silver Connections</title>
    <link rel="stylesheet" href="success.php.css">
</head>
<body style="background: linear-gradient(45deg, #ff99cc, #ff66b2, #e64980);">

<div class="success-container">
    <h2>Success! You have registered for Silver Connections.</h2>
    <p>Please click the button below to log in.</p>
    <a href="index.php" class="login-button">Log In</a>
</div>

</body>
</html>
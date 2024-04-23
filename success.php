<?php
require 'config.php';
require 'navbar.php';
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Success - Silver Connections</title>
    <link rel="stylesheet" href="success.php.css">
</head>
<body>

<div class="success-container">
    <h2>Success! You have registered for Silver Connections.</h2>
    <p>Please click the button below to log in.</p>
    <a href="index.php" class="login-button">Log In</a>
</div>

</body>
</html>
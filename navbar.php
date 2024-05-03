<?php
require 'checkAdmin.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rounded Table Example</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="banner">
    <img src="logo.PNG" alt="Silver Connections Logo">
    <link rel="stylesheet" href="styles.css">
    <div class="menu">
        <a href="home.php">HOME</a>
        <a href="searchPage.php">SEARCH</a>
        <?php if(session_status() != PHP_SESSION_NONE):?>
            <a href="viewProfile.php?UserId=<?php echo $_SESSION['UserId']; ?>">PROFILE</a>
        <?php endif; ?>
        <?php if($isAdmin == 1):?>
            <a href="reportsView.php">REPORTS</a>
        <?php endif; ?>
        <a href="logout.php">LOGOUT</a>
    </div>
</div>

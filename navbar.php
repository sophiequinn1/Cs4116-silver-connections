<?php
require 'checkAdmin.php';
?>

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
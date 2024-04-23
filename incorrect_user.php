<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Silver Connections</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to your CSS file -->
    <style>
        @font-face {
            font-family: 'Love Ya Like A Sister';
            src: url('LoveYaLikeASister-myEa.ttf') format('truetype'); /* Path to LoveYaLikeASister-myEa.ttf */
            /* You can also include another format (e.g., woff2) if available */
        }
    </style>
</head>
<body>

<div class="banner">
    <img src="logo.PNG" alt="Silver Connections Logo"> <!-- Logo image -->
    <div class="menu">
        <a href="home.php">HOME</a>
        <a href="aboutPage.php">ABOUT US</a>
        <a href="searchPage.php">SEARCH</a>
        <a href="#">PROFILE</a>
        <a href="contactPage.php">CONTACT US</a>
        <a href="logout.php">Logout</a>
    </div>
</div>

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
        <input type="submit" value="Login">
    </form>
    <a href="register_page.php" class="register-button">Register</a>
    <div class="error-message">
            User does not exist, or incorrect password entered. Please try again.
    </div>
</div>

</body>
</html>
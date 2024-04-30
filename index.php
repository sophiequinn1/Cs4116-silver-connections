<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Silver Connections</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        @font-face {
            font-family: 'Love Ya Like A Sister';
            src: url('LoveYaLikeASister-myEa.ttf') format('truetype');

        }
    </style>
</head>
<body>

<div class="banner">
    <img src="logo.PNG" alt="Silver Connections Logo"> <!-- Logo image -->
    <div class="menu">
        <a href="#">HOME</a>
        <a href="#">ABOUT US</a>
        <a href="#">SEARCH</a>
        <a href="#">PROFILE</a>
        <a href="#">CONTACT US</a>
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
</div>

</body>
</html>
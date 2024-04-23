<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Silver Connections</title>
    <link rel="stylesheet" href="register_page.css"> <!-- Link to your CSS file -->

    <!-- Font -->
    <style>
        @font-face {
            font-family: 'Love Ya Like A Sister';
            src: url('LoveYaLikeASister-myEa.ttf') format('truetype'); /* Path to LoveYaLikeASister-myEa.ttf */
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

<div class="register-container">
    <h2>Register</h2>
    <form action="register.php" method="post"> <!-- Updated form action -->
        <label>
            First Name:
            <input type="text" name="first_name" required>
        </label>
        <br>
        <label>
            Last Name:
            <input type="text" name="last_name" required>
        </label>
        <br>
        <label>
            Username:
            <input type="text" name="username" required>
        </label>
        <br>
        <label>
            Password:
            <input type="password" name="password" required>
        </label>
        <br>
        <label>
            Email:
            <input type="email" name="email" required>
        </label>
        <br>
        <label>
            Date of Birth:
            <input type="date" name="dob" required>
        </label>
        <br>
        <input type="submit" value="Register">
    </form>
</div>

</body>
</html>
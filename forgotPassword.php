<?php
require 'config.php';
require 'navbar.php';
session_start();
?>


<!DOCTYPE html>
<html>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Silver Connections</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

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
<div class="container-fluid">
    <a href="index.php">
        <img src="logo.PNG" alt="Silver Connections Logo">
    </a>
</div>
<div class="container">
    <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
        <p> Please enter the email address associated with your account</p>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">

            <form action="" method="post">
                <fieldset>
                    <div class="form-group">
                        <input type="email" name="email" id="email" class="form-control input" placeholder="Email Address" required>
                    </div>

                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <input type="submit" class="btn btn-lg btn-success btn-block" value="Reset Password">
                        </div>

                    </div>
                </fieldset>
            </form>
        </div>
    </div>

</body>
</html>
<?php
session_start();
require('config.php');

$userId = $_SESSION['userId'];
$servername = "127.0.0.1";
//    $username_db = "if0_36147664";
//    $password_db = "cs4116project";
$username_db = "root";
$password_db = "";
$dbname = "if0_36147664_silver_connections";

$db = new mysqli($servername, $username_db, $password_db, $dbname);
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}
$sql="SELECT * FROM Profiles, users";
$result = $db->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Search Page</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
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

<div>
    <div class="pull-left">
        <button id="resultButton" class="tablinks" id="search" onclick="openTable(event, 'searchDIV')">Profiles</button>
    </div>
    <form action="" method="post">
        <input type="text" name="search" placeholder="Search...">
        <button id="button" type="submit" name="submit" value="Search""><i class="fa fa-search"></i></button>
    </form>

    <div class="tab">
        <p style="font-size:20px; margin-left:10px; margin-top:20px;">Search users:</p>
        <button class="tablinks" id="profiles" onclick="openTable(event, 'profilesDiv')"></button>
    </div>


    <div id="profilesDiv" class="tabcontent" style="margin-left:20px";>
        <p style="font-size:20px; text-align: left; margin-top:30px;">Oldies:</p>
        <table width="60%">
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>View Profile</th>
            <tr>

            <?php

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr><td><br>" . $row["Interests"]. " ". $row["Gender"].  "</td><td><br>" . $row["Age"]. "</td><td><br><a href='#" . $row['UserId'] . "'> View Profile". "</a></td></tr>";
                }
                echo "</table>";
            } else {
                echo "0 results";
            }

            ?>

        </table>
    </div>
</body>
</html>


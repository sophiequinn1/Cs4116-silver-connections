<?php
session_start();
require 'config.php';
require 'navbar.php';

if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}
$sql="SELECT * FROM users";
$result = $db->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Search Page</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<div>
    <div class="pull-left">
        <button id="resultButton" class="tablinks" id="search" onclick="openTable(event, 'searchDIV')">Profiles</button>
    </div>
    <form action="" method="post">
        <input type="text" name="search" class="input-group" placeholder="Search...">
    </form>

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
                    echo "<tr><td><br>" . $row["Username"].  "</td><td><br>" . $row["Email"]. "</td><td><br><a href='viewProfile.php?UserId=" . $row['UserId'] . "'> View Profile". "</a></td></tr>";
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

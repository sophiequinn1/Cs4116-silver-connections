<?php
session_start();
require 'config.php';
require 'navbar.php';

if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}
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
    <div>
        <form action="" method="post">
            <input type="text" name="searchName" class="input-group" placeholder="Name...">
            <input type="text" name="searchInterest" class="input-group" placeholder="Interest...">
            <input type="text" name="searchAge" class="input-group" placeholder="Age...">
            <input type="submit" value="Search" onclick="openTable(event, 'profilesDiv')">
        </form>
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

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $nameValue = $_POST['searchName'];
                $interestValue = $_POST['searchInterest'];
                $ageValue = $_POST['searchAge'];

                $sql = "SELECT profiles.*, users.* 
                        FROM profiles 
                        INNER JOIN users 
                        ON profiles.UserId = users.UserId
                        WHERE Username = ? OR Interests LIKE ? OR Age = ?";
                $stmt = $db->prepare($sql);
                $stmt->bind_param("ssi", $nameValue, $interestValue, $ageValue);
                $stmt->execute();

                $result = $stmt->get_result();
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        if ($row["UserId"] != $_SESSION["UserId"]) {
                            echo "<tr><td><br>" . $row["Username"] . "</td><td><br>" . $row["Email"] . "</td><td><br><a href='viewProfile.php?UserId=" . $row['UserId'] . "'> View Profile" . "</a></td></tr>";
                        }
                    }
                }
                else {
                    echo "0 results";
                }
                $stmt->close();
            }


            echo "</table>";
        ?>

        </table>
    </div>
</body>
</html>


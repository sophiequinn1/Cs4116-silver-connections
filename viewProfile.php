<?php
require 'config.php';
require 'navbar.php';
require 'checkAdmin.php';

$userId = $_GET['UserId'];

$sql="SELECT * FROM profiles WHERE UserId = '$userId'";
$result = $db->query($sql);
$sql2="SELECT * FROM users WHERE UserId = '$userId'";
$result2 = $db->query($sql2);
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

<div class="button-container">
    <button id="button1">Like</button>
    <button id="button2"></button>
    <?php
    if ($isAdmin) {
        echo '<button id="button3">Ban</button>';
    } else {
        echo '<button id="button3">Report</button>';
    }
    ?>
</div>
<div id="profilesDiv" class="tabcontent" style="margin-left:20px">
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
                    $row2 = $result->fetch_assoc();
                    echo "<tr><td><br>" . $row2["Username"].  "</td><td><br>" . $row["Interests"]. "'> ". "</a></td></tr>";
                }
                echo "</table>";
            }

            ?>

    </table>
</div>

</body>
</html>

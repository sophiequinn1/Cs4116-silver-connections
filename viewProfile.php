<?php
require 'config.php';
require 'navbar.php';
require 'checkAdmin.php';

$userId = $_GET['UserId'];

$sql = "SELECT profiles.*, users.* 
        FROM profiles 
        INNER JOIN users 
        ON profiles.UserId = users.UserId 
        WHERE profiles.UserId = '$userId'";

// Execute the query
$result = $db->query($sql);
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
    <?php if ($isAdmin): ?>
        <button method="post" action="buttonActions.php" value="ban">Ban</button>
    <?php else: ?>
        <button method="post" action="buttonActions.php" value="block">Block</button>
    <?php endif; ?>
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
                echo "<tr><td><br>" . $row["Username"].  "</td><td><br>" . $row["Interests"]. "'> ". "</a></td></tr>" . $row["Bio"]. "'> ". "</a></td></tr>";
            }
            echo "</table>";
        }

        ?>

    </table>
</div>

</body>
</html>

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
    <div class="container" style="width: 20%;">
        <form action="" method="post" class="mt-4">
            <div class="form-group">
                <label>Name:</label>
                <input type="text" name="searchName" class="input-group">
            </div>
            <div class="form-group">
                <label>Interest:</label>
                <input type="text" name="searchInterest" class="input-group">
            </div>
            <div class="form-group">
                <label>Age:</label>
                <input type="text" name="searchAge" class="input-group">
            </div>
            <div class="text-center">
                <input type="submit" value="Search" class="btn btn-primary">
            </div>
        </form>
    </div>

        <?php

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $nameValue = $_POST['searchName'];
                $interestValue = $_POST['searchInterest'];
                $ageValue = $_POST['searchAge'];

                $sql = "SELECT Profiles.*, users.* 
                        FROM Profiles 
                        INNER JOIN users 
                        ON Profiles.UserId = users.id
                        WHERE username = ? OR Interests LIKE ? OR Age = ?";

                $stmt = $db->prepare($sql);
                $stmt->bind_param("ssi", $nameValue, $interestValue, $ageValue);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
        ?>
    <div id="profilesDiv" class="tabcontent container" style="width: 50%;">
        <p style="font-size:20px; text-align: left; margin-top:30px;">Oldies:</p>
        <table class="table table-bordered table-rounded">
            <thead style="background-color: #ffb4b4;">
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>View Profile</th>
            </tr>
            </thead>
                <?php
                    while($row = $result->fetch_assoc()) {
                        if ($row["id"] != $_SESSION["UserId"]) {
                            echo "<tr>";
                            echo "<td>" . $row["username"] . "</td>";
                            echo "<td>" . $row["email"] . "</td>";
                            echo "<td><a href='viewProfile.php?UserId=" . $row['id'] . "' class='btn btn-info'>View Profile</a></td>";
                            echo "</tr>";
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


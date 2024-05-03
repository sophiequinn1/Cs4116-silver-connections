<?php
session_start();
require 'config.php';
require 'navbar.php';

$userId = $_SESSION['UserId'];
$reportId = $_GET['ReportId'];

$sql = "SELECT * FROM reports WHERE reportId = ?";
$stmt = $db->prepare($sql);
$stmt->bind_param("i", $reportId);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $reportedUser = $row['userId1'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Success - Silver Connections</title>
    <link rel="stylesheet" href="success.php.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<div>
    <div id="profilesDiv" class="tabcontent" style="margin-left:20px";>
        <p style="font-size:20px; text-align: left; margin-top:30px;">User Info:</p>
        <table class="table table-bordered table-striped table-hover" width="50%">
            <thead style="background-color: #ffb4b4;">
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>View Profile</th>
            </tr>
        </thead>

        <?php
        $sql = "SELECT Profiles.*, users.* 
                        FROM Profiles 
                        INNER JOIN users 
                        ON Profiles.UserId = users.id
                        WHERE users.id = ?";
        $stmt = $db->prepare($sql);
        $stmt->bind_param("i", $reportedUser);
        $stmt->execute();

        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                if ($row["id"] != $_SESSION["UserId"]) {
                    echo "<tr><td><br>" . $row["username"] . "</td><td><br>" . $row["email"] . "</td><td><br><a class='btn btn-info' href='viewProfile.php?UserId=" . $row['id'] . "'> View Profile" . "</a></td></tr>";
                }
            }
        }
         $stmt->close();
            echo "</table>";
        ?>


        </table>
    </div>

</body>
</html>

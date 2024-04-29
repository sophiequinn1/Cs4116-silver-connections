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
    <title>Reports Page</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<div>
    <div id="profilesDiv" class="tabcontent" style="margin-left:20px";>
        <p style="font-size:20px; text-align: left; margin-top:30px;">Reports:</p>
        <table width="60%">
            <tr>
                <th>Reported</th>
                <th>Report Reason</th>
                <th>Report Time</th>
                <th>View Report</th>
            <tr>

                <?php
                $sql = "SELECT *
                    FROM reports
                    LEFT JOIN users ON users.userid = reports.userid1";
                    $stmt = $db->prepare($sql);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr><td><br>" . $row["Username"] . "</td><td><br>" . $row["reportReason"] . "</td><td><br>" . $row['reportDateTime'] . "</td><td><br><a href='viewReportInfo.php?ReportId=" . $row['reportId'] . "'> View Report" . "</a></td></tr>";
                        }
                    }
                    else {
                        echo "0 results";
                    }
                    $stmt->close();


                echo "</table>";
                ?>

        </table>
    </div>
</body>
</html>


<?php
session_start();
require 'config.php';
require 'navbar.php';
require 'checkAdmin.php';

$userId = $_SESSION['UserId'];
$userId2 = $_GET['UserId'];

$stmt = $db->prepare("SELECT * FROM bannedusers WHERE UserId = ?");
$stmt->bind_param("i", $userId2);
$stmt->execute();
if ($stmt->fetch()) {
    $isBanned = true;
} else {
    $isBanned = false;
}
$stmt->close();

$stmt = $db->prepare("SELECT * FROM blocks WHERE UserId1 = ? AND UserId2 = ?");
$stmt->bind_param("ii", $userId, $userId2);
$stmt->execute();
if ($stmt->fetch()) {
    $isBlocker = true;
} else {
    $isBlocker = false;
}
$stmt->close();

$stmt = $db->prepare("SELECT * FROM blocks WHERE UserId1 = ? AND UserId2 = ?");
$stmt->bind_param("ii", $userId2, $userId1);
$stmt->execute();
if ($stmt->fetch()) {
    $hasBeenBlocked = true;
} else {
    $hasBeenBlocked = false;
}
$stmt->close();

$ownProfile = $userId == $userId2;
$stmt = $db->prepare("SELECT * FROM likes WHERE UserId1 = ? AND UserId2 = ?");
$stmt->bind_param("ii", $userId, $userId2);
$stmt->execute();
if ($stmt->fetch()) {
    $alreadyLiked = true;
} else {
    $alreadyLiked = false;
}
$stmt->close();

$sql = "SELECT * FROM matches WHERE (UserId1 = ? AND UserId2 = ?) OR (UserId1 = ? AND UserId2 = ?)";
$stmt = $db->prepare($sql);
$stmt->bind_param("iiii", $userId, $userId2, $userId2, $userId);
$stmt->execute();
if ($stmt->fetch()) {
    $alreadyMatched = true;
} else {
    $alreadyMatched = false;
}
$stmt->close();
if($ownProfile){
    $userIdToView = $userId;
}
else{
    $userIdToView = $userId2;
}
$sql = "SELECT profiles.*, users.* 
        FROM profiles 
        INNER JOIN users 
        ON profiles.UserId = users.UserId 
        WHERE profiles.UserId = '$userIdToView'";

$result = $db->query($sql);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['like'])) {
        $userId = $_POST['UserId'];
        $userId2 = $_POST['UserId2'];

        if ($alreadyLiked) {
            $stmt = $db->prepare("DELETE FROM likes WHERE UserId1 = ? AND UserId2 = ?");
            // form kept resubmitting when refreshing the page so button kept being pressed
            echo "<meta http-equiv='refresh' content='0'>'";
            $stmt->bind_param("ii", $userId, $userId2);
            $stmt->execute();
            $stmt->close();

            if($alreadyMatched){
                $stmt = $db->prepare("DELETE FROM matches WHERE (UserId1 = ? AND UserId2 = ?) OR (UserId1 = ? AND UserId2 = ?)");
                echo "<meta http-equiv='refresh' content='0'>'";
                $stmt->bind_param("iiii", $userId, $userId2, $userId2, $userId);
                $stmt->execute();
                $stmt->close();
            }
        } else {
            $stmt = $db->prepare("INSERT INTO likes (UserId1, UserId2, LikeDateTime) VALUES (?, ?, NOW())");
            echo "<meta http-equiv='refresh' content='0'>'";
            $stmt->bind_param("ii", $userId, $userId2);
            $stmt->execute();
            $stmt->close();

            $stmt = $db->prepare("SELECT * FROM likes WHERE UserId1 = ? AND UserId2 = ?");
            $stmt->bind_param("ii", $userId2, $userId);
            $stmt->execute();
            if ($stmt->fetch()) {
                $stmt->close();
                $stmt = $db->prepare("INSERT INTO Matches (UserId1, UserId2, MatchDateTime) VALUES (?, ?, NOW())");

                echo "<meta http-equiv='refresh' content='0'>'";
                $stmt->bind_param("ii", $userId2, $userId);
                $stmt->execute();
                $stmt->close();
            }
        }
    }
    else if(isset($_POST['ban'])) {
        if($isBanned){
            $stmt = $db->prepare("DELETE FROM bannedusers WHERE UserId = ?");
            echo "<meta http-equiv='refresh' content='0'>'";
            $stmt->bind_param("i", $userId2);
            $stmt->execute();
            $stmt->close();
        }
        else {
            $stmt = $db->prepare("INSERT INTO BannedUsers (UserId, BannedDateTime, BanDetails) VALUES (?, NOW(), 'banned')");
            echo "<meta http-equiv='refresh' content='0'>'";
            $stmt->bind_param("i", $userId2);
            $stmt->execute();
            $stmt->close();
        }
    }
    else if(isset($_POST['deleteAccount'])) {
        $stmt = $db->prepare("DELETE FROM users WHERE UserId = ?");
        echo "<meta http-equiv='refresh' content='0'>'";
        $stmt->bind_param("i", $userId2);
        $stmt->execute();
        $stmt->close();
        $stmt = $db->prepare("DELETE FROM profiles WHERE UserId = ?");
        echo "<meta http-equiv='refresh' content='0'>'";
        $stmt->bind_param("i", $userId2);
        $stmt->execute();
        $stmt->close();
        $stmt = $db->prepare("DELETE FROM likes WHERE UserId1 = ? OR UserId2 = ?");
        echo "<meta http-equiv='refresh' content='0'>'";
        $stmt->bind_param("ii", $userId2, $userId2);
        $stmt->execute();
        $stmt->close();
        $stmt = $db->prepare("DELETE FROM matches WHERE UserId1 = ? OR UserId2 = ?");
        echo "<meta http-equiv='refresh' content='0'>'";
        $stmt->bind_param("ii", $userId2, $userId2);
        $stmt->execute();
        $stmt->close();
    }
    else if(isset($_POST['block'])) {
        if ($isBlocker){
            $stmt = $db->prepare("DELETE FROM blocks WHERE UserId1 = ? AND UserId2 = ?");
            echo "<meta http-equiv='refresh' content='0'>'";
            $stmt->bind_param("ii", $userId, $userId2);
            $stmt->execute();
            $stmt->close();
        }
        else {
            $stmt = $db->prepare("INSERT INTO blocks (UserId1, UserId2, BlockDateTime) VALUES (?, ?, NOW())");
            echo "<meta http-equiv='refresh' content='0'>'";
            $stmt->bind_param("ii", $userId, $userId2);
            $stmt->execute();
            $stmt->close();
        }
    }
    else if(isset($_POST['report'])) {
        $stmt = $db->prepare("INSERT INTO reports (UserId1, UserId2, reportDateTime, reportReason) VALUES (?, ?, NOW(), 'reported')");
        echo "<meta http-equiv='refresh' content='0'>'";
        $stmt->bind_param("ii", $userId, $userId2);
        $stmt->execute();
        $stmt->close();
    }
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

<?php if($isBanned && $isAdmin == 0):
    echo "This user is banned";
elseif($hasBeenBlocked):
    echo "You are blocked";
else:
?>

<?php if (!$ownProfile):?>
<div class="button-container">
    <form method="post" action="">
        <input type="hidden" name="UserId" value="<?php echo $userId; ?>">
        <input type="hidden" name="UserId2" value="<?php echo $userId2; ?>">
        <?php if($isAdmin == 0): ?>
            <button type="post" name="like" class="btn-success button">
        <?php
            if($alreadyLiked) {
                echo "Unlike";
            }
            else{
                echo "Like";
            }
            endif;
        ?></button>
    </form>
    <?php if ($isAdmin == 1): ?>
        <form method="post" action="">
            <input type="hidden" name="deleteAccount" value="deleteAccount">
            <button type="submit" class="btn-danger button">Delete User</button>
        </form>
        <form method="post" action="">
            <input type="hidden" name="ban" value="ban">
            <button type="submit" class="btn-danger button"><?php
                if($isBanned) {
                    echo "Unban";
                }
                else{
                    echo "Ban";
                }

                ?></button>
        </form>
    <?php else: ?>
        <form method="post" action="">
            <input type="hidden" name="block" value="block">
            <button type="submit" class="btn-danger button">
                <?php
                if($isBlocker) {
                echo "Unblock";
                }
                else{
                echo "Block";
                }

                ?></button>
        </form>
        <form method="post" action="">
            <input type="hidden" name="report" value="report">
            <button type="submit" class="btn-danger button">Report</button>
        </form>

    <?php endif; ?>
</div>
<?php endif;?>
<div id="profilesDiv" class="tabcontent" style="margin-left:20px">
    <p style="font-size:20px; text-align: left; margin-top:30px;">Bio:</p>
    <table width="60%">
        <tr>
            <th>Name</th>
            <th>Interests</th>
            <th>Gender</th>
            <th>Age</th>
        <tr>

        <?php

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                    if ($row["Gender"] == 1)
                        $gender = "Male";
                    else{
                        $gender = "Female";
                    }
                echo "<tr><td><br>" . $row["Username"].  "</td><td><br>" . $row["Interests"]. "</td><td><br>" . $gender. "</td><td><br>" . $row["Age"] . "</a></td></tr>" . $row["Bio"]. " ". "</a></td></tr>";
            }
            echo "</table>";
        }
        ?>

    </table>
</div>
<?php endif;?>

</body>
</html>

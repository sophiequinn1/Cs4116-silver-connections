<?php
require 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && isset($_POST['UserId'])) {
    $action = $_POST['action'];
    $userId = $_POST['UserId'];

    $userId2 = $_GET['UserId'];

    if ($db->connect_error) {
        die("Connection failed: " . $db->connect_error);
    }
    if ($action === 'ban') {
        $sql = "INSERT INTO BannedUsers (UserId, BannedDateTime, BanDetails) VALUES ($userId, NOW(), 'banned fr')";
        $stmt = $db->prepare($sql);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $stmt->close();
    } elseif ($action === 'block') {
        $sql = "INSERT INTO Blocks (UserId1, UserId2, BlockDateTime) VALUES ($userId, $userId2, NOW())";
        $stmt = $db->prepare($sql);
        $stmt->bind_param("ii", $userId, $userId2);
        $stmt->execute();
        $stmt->close();
    } elseif ($action === 'like') {
        $sql = "INSERT INTO Likes (UserId1, UserId2, LikeDateTime) VALUES ($userId, $userId2, NOW())";
        $stmt = $db->prepare($sql);
        $stmt->bind_param("ii", $userId, $userId2);
        $stmt->execute();
        $stmt->close();

        $sql = $sql = "SELECT * FROM Likes WHERE UserId1 = '$userId' AND UserId2 = '$userId2'";
        $stmt = $db->prepare($sql);
        $stmt->bind_param("ii", $userId, $userId2);
        $stmt->execute();
        if ($stmt->fetch()) {
            $match = true;
        } else {
            $match = false;
        }
        $stmt->close();

        if($match){
            $sql = "INSERT INTO Matches (UserId1, UserId2, MatchDateTime) VALUES ($userId, $userId2, NOW())";
            $stmt = $db->prepare($sql);
            $stmt->bind_param("ii", $userId, $userId2);
            $stmt->execute();
            $stmt->close();
        }
    }
}
?>
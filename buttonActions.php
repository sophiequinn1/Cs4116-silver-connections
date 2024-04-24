<?php
require 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && isset($_POST['UserId'])) {
    $action = $_POST['action'];
    $userId = $_POST['UserId'];

if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}
if ($action === 'ban') {
    $sql = "";//update banned user table
    $stmt = $db->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $stmt->close();
} elseif ($action === 'block') {
    $sql = "";//update blocks table
    $stmt = $db->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $stmt->close();
}
?>
<?php
require 'config.php';

$userId = $_SESSION['UserId'];
$sql="SELECT Admin FROM users WHERE id = ?";
$stmt = $db->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $isAdmin = $row['Admin'];
} else {
    echo "No user found with the provided ID.";
}
$stmt->close();
?>
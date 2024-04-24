<?php
require 'config.php';
$userId = $_GET['UserId'];

$sql="SELECT IsAdmin FROM users WHERE UserId = '$userId'";
$isAdmin = $db->query($sql);

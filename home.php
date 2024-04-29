<?php
session_start();
require 'config.php';
require 'navbar.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Redirect Button</title>
</head>
<body>

<form id="redirectForm" method="post" action="profile_preview.php">
    <button type="submit">Go to Profile Preview Page</button>
</form>

</body>
</html>
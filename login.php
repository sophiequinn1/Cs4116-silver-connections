<?php
// Retrieve username and password from form submission
$username = $_POST['username'];
$password = $_POST['password'];

// Database connection parameters
$servername = "sql204.infinityfree.com";
$username_db = "if0_36314684";
$password_db = "cs4116silvercon";
$dbname = "if0_36314684_cs4116silverconnections";

// Create connection
$conn = new mysqli($servername, $username_db, $password_db, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query database for user with submitted username
// Query database for user with submitted username
$sql = "SELECT * FROM users WHERE username = '$username'";
$result = $conn->query($sql);

// Check if user exists and verify password
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    // Debugging output
    echo "Stored Password: " . $row['password'] . "<br>";
    echo "Submitted Password (Hashed): " . password_hash($password, PASSWORD_DEFAULT) . "<br>";

    // Verify hashed password
    if (password_verify($password, $row['password'])) {
        // Password is correct, redirect to success page
        header("Location: success.php");
        exit;
    } else {
        // Password is incorrect, display error message
        echo "Incorrect password";
    }
} else {
    // User does not exist, display error message
    echo "User not found";
}

$conn->close();
?>

<?php
// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Start session
session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Database connection parameters
    $servername = "127.0.0.1";
//    $username_db = "if0_36147664";
//    $password_db = "cs4116project";
    $username_db = "root";
    $password_db = "";
    $dbname = "if0_36147664_silver_connections";

    // Create connection
    $conn = new mysqli($servername, $username_db, $password_db, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare SQL statement
    $stmt = $conn->prepare("SELECT UserId, Password FROM users WHERE Username = ?");
    $stmt->bind_param("s", $username);

    if (!$stmt->execute()) {
        die("Error executing SQL query: " . $stmt->error);
    }

    $result = $stmt->get_result();

    // Check if user exists
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Verify password
        if (strcmp($password, $row['Password']) == 0) {
            // Store user ID in session
            $_SESSION['UserId'] = $row['UserId'];

            // Redirect to home page
            header("Location: home.php");
            exit;
        } else {
            header("Location: incorrect_user.php");
            exit;
        }
    } else {
        header("Location: incorrect_user.php");
        exit;
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}
?>
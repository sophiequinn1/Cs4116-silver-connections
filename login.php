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
    $servername = "sql204.infinityfree.net";
    $username_db = "if0_36314684";
    $password_db = "cs4116silvercon";
    $dbname = "if0_36314684_cs4116silverconnections";

    // Create connection
    $conn = new mysqli($servername, $username_db, $password_db, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare SQL statement
    $stmt = $conn->prepare("SELECT user_id, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);

    if (!$stmt->execute()) {
        die("Error executing SQL query: " . $stmt->error);
    }

    $result = $stmt->get_result();

    // Check if user exists
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $row['password'])) {
            // Store user ID in session
            $_SESSION['user_id'] = $row['user_id'];

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
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
    $servername = "sql204.infinityfree.com";
    $username_db = "if0_36147664";
    $password_db = "cs4116project";
    $dbname = "if0_36147664_silver_connections";

    // Create connection
    $conn = new mysqli($servername, $username_db, $password_db, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare SQL statement

    $stmt = $conn->prepare("SELECT id, password, has_profile FROM users WHERE username = ?");
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
            // Store user ID and has_profile in session
            $_SESSION['UserId'] = $row['id'];
            $_SESSION['has_profile'] = $row['has_profile'];

            // Check has_profile value
            if ($row['has_profile'] == 1) {
                // User has a profile, redirect to home.php
                header("Location: home.php");
                exit;
            } else {
                // User does not have a profile, redirect to profile_creation.php
                header("Location: profile_creation.php");
                exit;
            }
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
}
?>
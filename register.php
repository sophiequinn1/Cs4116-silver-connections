<?php
// Enable error reporting for debugging (remove in production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $first_name = $_POST["first_name"];
    $last_name = $_POST["last_name"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    $email = $_POST["email"];
    $dob = $_POST["dob"];

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $full_name = $first_name . ' ' . $last_name;

    // Database connection parameters
    $servername = "sql204.infinityfree.com";
    $username_db = "if0_36314684";
    $password_db = "cs4116silvercon";
    $dbname = "if0_36314684_silver_connections";

    // Create connection
    $conn = new mysqli($servername, $username_db, $password_db, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare SQL statement for user registration
    $sql_user = "INSERT INTO users (username, password, full_name, email, date_of_birth) VALUES (?, ?, ?, ?, ?)";
    $stmt_user = $conn->prepare($sql_user);

    // Bind parameters and execute the statement for user registration
    $stmt_user->bind_param("sssss", $username, $hashed_password, $full_name, $email, $dob);
    if ($stmt_user->execute()) {
        // Redirect to success.php
        header("Location: success.php");
        exit;
    } else {
        // Redirect to error page with error message
        header("Location: error.php?error=" . urlencode("Registration failed: " . $stmt_user->error));
        exit;
    }

    // Close statements and connection
    $stmt_user->close();
    $conn->close();
}
?>
<?php
// Enable error reporting for debugging (remove in production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "Debugging started"; // Debugging statement

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

echo "Connected to database"; // Debugging statement

// Create users table if it doesn't exist
$sql_create_table = "
    CREATE TABLE IF NOT EXISTS users (
        id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(255) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        full_name VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL UNIQUE,
        date_of_birth DATE NOT NULL
    )
";

if ($conn->query($sql_create_table) === TRUE) {
    echo "Table created successfully"; // Debugging statement
} else {
    echo "Error creating table: " . $conn->error; // Debugging statement
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo "Form submitted"; // Debugging statement

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

    // Prepare SQL statement for user registration
    $sql_user = "INSERT INTO users (username, password, full_name, email, date_of_birth) VALUES (?, ?, ?, ?, ?)";
    $stmt_user = $conn->prepare($sql_user);

    // Bind parameters and execute the statement for user registration
    $stmt_user->bind_param("sssss", $username, $hashed_password, $full_name, $email, $dob);
    if ($stmt_user->execute()) {
        echo "Registration successful"; // Debugging statement

        // Redirect to success.php
        header("Location: success.php");
        exit;
    } else {
        echo "Registration failed: " . $stmt_user->error; // Debugging statement

        // Redirect to error page with error message
        header("Location: error.php?error=" . urlencode("Registration failed: " . $stmt_user->error));
        exit;
    }

    // Close statements and connection
    $stmt_user->close();
    $conn->close();
}
?>
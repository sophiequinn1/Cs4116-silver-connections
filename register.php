<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "Debugging started";

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
} else {
    echo "Connected successfully"; // Debugging statement
}

// Create users table if it doesn't exist
$sql_create_table = "
    CREATE TABLE IF NOT EXISTS users (
        id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(255) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        full_name VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL UNIQUE,
        date_of_birth DATE NOT NULL,
        has_profile BOOLEAN DEFAULT FALSE
    );
";

if ($conn->query($sql_create_table) === TRUE) {
    echo "Table created successfully"; // Debugging statement
} else {
    echo "Error creating table: " . $conn->error; // Debugging statement
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $first_name = $_POST["first_name"];
    $last_name = $_POST["last_name"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    $email = $_POST["email"];
    $dob = $_POST["dob"];

    // Check if the username already exists
    $sql_check_username = "SELECT COUNT(*) as count FROM users WHERE username = ?";
    $stmt_check_username = $conn->prepare($sql_check_username);
    $stmt_check_username->bind_param("s", $username);
    $stmt_check_username->execute();
    $result_check_username = $stmt_check_username->get_result();
    $row = $result_check_username->fetch_assoc();
    if ($row['count'] > 0) {
        // Username already exists, display pop-up alert
        echo "<script>alert('Username already exists');</script>";
        exit;
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $full_name = $first_name . ' ' . $last_name;

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

    // Prepare SQL statement for user registration
    $sql_user = "INSERT INTO users (username, password, full_name, email, date_of_birth) VALUES (?, ?, ?, ?, ?)";
    $stmt_user = $conn->prepare($sql_user);

    // Bind parameters and execute the statement for user registration
    $stmt_user->bind_param("sssss", $username, $password, $full_name, $email, $dob);
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
    $stmt_check_username->close();
    $conn->close();
}
?>
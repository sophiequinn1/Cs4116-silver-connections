
<?php
// Start the session
session_start();

// Check if the user is logged in and the session variable is set
if(isset($_SESSION['UserId'])) {
    // Connect to your database
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "local_database";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Assuming you have some way to identify the current logged-in user, let's say you have their ID stored in a variable $user_id
    $user_id = $_SESSION['UserId']; // Adjust this according to your authentication system

    // Prepare a SQL query to retrieve the user's name
    $sql_name = "SELECT full_name FROM users WHERE id = $user_id";

    // Execute the query
    $result_name = $conn->query($sql_name);

    // Check if the query was successful
    if ($result_name) {
        // Fetch the result as an associative array
        $row_name = $result_name->fetch_assoc();
        // Extract the user's name
        $full_name = $row_name["full_name"];
        // Split the full name into an array using space as delimiter
        $name_parts = explode(' ', $full_name);
        // Extract the first name (first element of the array)
        $user_name = $name_parts[0];
    } else {
        // Default name if user is not found
        $user_name = "Unknown";
    }

    // Prepare a SQL query to retrieve the user's age
    $sql_age = "SELECT age FROM profiles WHERE UserID = $user_id";

    // Execute the query
    $result_age = $conn->query($sql_age);

    // Check if the query was successful
    if ($result_age) {
        // Fetch the result as an associative array
        $row_age = $result_age->fetch_assoc();
        // Extract the user's age
        $user_age = $row_age["age"];
    } else {
        // Default age if user's age is not found
        $user_age = "Unknown";
    }

    // Prepare a SQL query to retrieve the user's bio
    $sql_bio = "SELECT bio FROM profiles WHERE UserID = $user_id";

    // Execute the query
    $result_bio = $conn->query($sql_bio);

    // Check if the query was successful
    if ($result_bio) {
        // Fetch the result as an associative array
        $row_bio = $result_bio->fetch_assoc();
        // Extract the user's bio
        $user_bio = $row_bio["bio"];
    } else {
        // Default bio if user's bio is not found
        $user_bio = "No bio available";
    }

    // Prepare a SQL query to retrieve the user's city
    $sql_city = "SELECT City FROM profiles WHERE UserID = $user_id";

    // Execute the query
    $result_city = $conn->query($sql_city);

    // Check if the query was successful
    if ($result_city) {
        // Fetch the result as an associative array
        $row_city = $result_city->fetch_assoc();
        // Extract the user's city
        $user_city = $row_city["City"];
    } else {
        // Default city if user's city is not found
        $user_city = "Unknown";
    }

    // Prepare a SQL query to retrieve the user's country
    $sql_country = "SELECT Country FROM profiles WHERE UserID = $user_id";

    // Execute the query
    $result_country = $conn->query($sql_country);

    // Check if the query was successful
    if ($result_country) {
        // Fetch the result as an associative array
        $row_country = $result_country->fetch_assoc();
        // Extract the user's country
        $user_country = $row_country["Country"];
    } else {
        // Default country if user's country is not found
        $user_country = "Unknown";
    }

    // Concatenate city and country
    $user_location = $user_city . ", " . $user_country;

    // Close the database connection
    $conn->close();
} else {
    // Redirect the user to the login page or display an error message
    echo "You are not logged in.";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Silver Connections</title>
    <link rel="stylesheet" href="profile_preview.css"> <!-- Link to your CSS file -->
    <style>
        @font-face {
            font-family: 'Love Ya Like A Sister';
            src: url('LoveYaLikeASister-myEa.ttf') format('truetype'); /* Path to LoveYaLikeASister-myEa.ttf */
            /* You can also include another format (e.g., woff2) if available */
        }
    </style>
</head>
<body>

<div class="banner">
    <img src="logo.PNG" alt="Silver Connections Logo"> <!-- Logo image -->
    <div class="menu">
        <a href="#">HOME</a>
        <a href="#">ABOUT US</a>
        <a href="#">SEARCH</a>
        <a href="#">PROFILE</a>
        <a href="#">CONTACT US</a>
    </div>
</div>

<div class="profile-container">
    <div class="profile-heading">Profile</div>
    <div class="action-buttons">
        <button>My Profile</button>
        <button>Settings</button>
        <button>Edit Profile</button>
    </div>
    <div class="profile-info">
        <div class="profile-picture"></div> <!-- Add the profile picture here -->
        <div class="profile-details">
            <div class="profile-name"><?php echo $user_name; ?></div>
            <div class="profile-age"><?php echo $user_age; ?></div> <!-- Corrected variable name -->
        </div>
        <div class="profile-location"><?php echo $user_location; ?></div>
    </div>
    <div class="hobbies-heading">Hobbies & Interests</div>
    <div class="hobbies">
        <input type="text" placeholder="Hobby 1">
        <input type="text" placeholder="Hobby 2">
        <input type="text" placeholder="Hobby 3">
        <input type="text" placeholder="Hobby 4">
        <input type="text" placeholder="Hobby 5">
        <input type="text" placeholder="Hobby 6">
    </div>
    <div class="profile-bio"><?php echo $user_bio; ?></div>
    <div class="profile-squares">
        <div class="square"></div>
        <div class="square"></div>
    </div>
</div>

</body>
</html>

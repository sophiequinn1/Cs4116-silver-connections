
<?php

session_start();


if(isset($_SESSION['UserId'])) {

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "local_database";


    $conn = new mysqli($servername, $username, $password, $dbname);

    // Connect to your database
    $servername = "sql204.infinityfree.com";
    $username_db = "if0_36147664";
    $password_db = "cs4116project";
    $dbname = "if0_36147664_silver_connections";

    // Create connection
    $conn = new mysqli($servername, $username_db, $password_db, $dbname);



    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }


    $user_id = $_SESSION['UserId'];


    $sql_name = "SELECT full_name FROM users WHERE id = $user_id";


    $result_name = $conn->query($sql_name);


    if ($result_name) {

        $row_name = $result_name->fetch_assoc();

        $full_name = $row_name["full_name"];

        $name_parts = explode(' ', $full_name);

        $user_name = $name_parts[0];
    } else {

        $user_name = "Unknown";
    }


    $sql_age = "SELECT age FROM profiles WHERE UserID = $user_id";


    $result_age = $conn->query($sql_age);

    if ($result_age) {

        $row_age = $result_age->fetch_assoc();

        $user_age = $row_age["age"];
    } else {

        $user_age = "Unknown";
    }


    $sql_bio = "SELECT bio FROM profiles WHERE UserID = $user_id";


    $result_bio = $conn->query($sql_bio);


    if ($result_bio) {

        $row_bio = $result_bio->fetch_assoc();

        $user_bio = $row_bio["bio"];
    } else {

        $user_bio = "No bio available";
    }


    $sql_city = "SELECT City FROM profiles WHERE UserID = $user_id";


    $result_city = $conn->query($sql_city);

    if ($result_city) {

        $row_city = $result_city->fetch_assoc();

        $user_city = $row_city["City"];
    } else {

        $user_city = "Unknown";
    }


    $sql_country = "SELECT Country FROM profiles WHERE UserID = $user_id";


    $result_country = $conn->query($sql_country);


    if ($result_country) {

        $row_country = $result_country->fetch_assoc();

        $user_country = $row_country["Country"];
    } else {

        $user_country = "Unknown";
    }

    $user_location = $user_city . ", " . $user_country;


    $conn->close();
} else {

    echo "You are not logged in.";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Silver Connections</title>
    <link rel="stylesheet" href="profile_preview.css">
    <style>
        @font-face {
            font-family: 'Love Ya Like A Sister';
            src: url('LoveYaLikeASister-myEa.ttf') format('truetype');

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

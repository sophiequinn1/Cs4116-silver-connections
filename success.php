<?php
session_start();
require 'config.php';
require 'navbar.php';

// Database connection settings
$servername = "sql204.infinityfree.com";
$username_db = "if0_36147664";
$password_db = "cs4116project";
$dbname = "if0_36147664_silver_connections";

// Establish connection to database
$conn = new mysqli($servername, $username_db, $password_db, $dbname);

// Check if connection is successful
if ($conn->connect_error) {
    die('Connection Failed : '.$conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $userID = $_SESSION['UserId'];

    $userCheckStmt = $conn->prepare("SELECT id FROM users WHERE id = ?");
    $userCheckStmt->bind_param("i", $userID);
    $userCheckStmt->execute();
    $userCheckResult = $userCheckStmt->get_result();

    if ($userCheckResult->num_rows == 0) {
        die("No user found with ID: " . $userID);
    }

    // Check if profile-image1 is uploaded
    if (!empty($_FILES["profile-image1"]["tmp_name"])) {
        $file1TmpName = $_FILES["profile-image1"]["tmp_name"];

        // Read file content of profile-image1
        $file1Content = file_get_contents($file1TmpName);

        // Encode file content to base64
        $base64Image1 = base64_encode($file1Content);

        // Sanitize user input
        $age = mysqli_real_escape_string($conn, $_POST['age']);
        $country = mysqli_real_escape_string($conn, $_POST['country']);
        $city = mysqli_real_escape_string($conn, $_POST['city']);
        $bio = mysqli_real_escape_string($conn, $_POST['bio']);
        $gender = mysqli_real_escape_string($conn, $_POST['gender']);
        $looking_for = mysqli_real_escape_string($conn, $_POST['looking_for']);

        // Retrieve interests from form
        $interests = [];
        for ($i = 1; $i <= 6; $i++) {
            if (!empty($_POST['hobby' . $i])) {
                $interests[] = mysqli_real_escape_string($conn, $_POST['hobby' . $i]);
            }
        }

        // Combine interests into a comma-separated string
        $interestsString = implode(',', $interests);

        // Prepare SQL statement to insert profile-image1 into profiles table
        $stmt = $conn->prepare("INSERT INTO Profiles (Photo, Gender, Age, SexualPreference, Bio, City, Country, Interests, UserID) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

        if ($stmt) {
            // Bind parameters for profile-image1
            $stmt->bind_param("ssiissssi", $base64Image1, $gender, $age, $looking_for, $bio, $city, $country, $interestsString, $userID);

            if ($stmt->execute()) {
                // Retrieve auto-generated ProfilePhotoID
                $profilePhotoID = $stmt->insert_id;

                // Update the profile record with ProfilePhotoID
                $updateStmt = $conn->prepare("UPDATE profiles SET ProfilePhotoID = ? WHERE UserID = ?");
                $updateStmt->bind_param("ii", $profilePhotoID, $userID);
                $updateStmt->execute();
                $updateStmt->close();

                // Update has_profile to 1 in the Users table
                $updateHasProfileStmt = $conn->prepare("UPDATE users SET has_profile = 1 WHERE id = ?");
                $updateHasProfileStmt->bind_param("i", $userID);
                $updateHasProfileStmt->execute();
                $updateHasProfileStmt->close();

                // Success message
                echo "Profile created successfully. ProfilePhotoID: " . $profilePhotoID;

                // Set success flag
                $success = true;
            } else {
                echo "Error executing SQL: " . $stmt->error;
            }


            $stmt->close();
        } else {
            echo "Error preparing SQL statement: " . $conn->error;
        }
    } else {
        echo "Please upload a profile image.";
    }

    // Handling profile-image2 and profile-image3
    for ($i = 1; $i <= 3; $i++) {
        if (!empty($_FILES["profile-image$i"]["tmp_name"])) {
            $fileNTmpName = $_FILES["profile-image$i"]["tmp_name"];

            // Read file content
            $fileNContent = file_get_contents($fileNTmpName);

            // Prepare PhotoPath (blob)
            $photoPath = mysqli_real_escape_string($conn, $fileNContent);

            // Generate unique PhotoID
            $photoID = $_SESSION['UserId'] . '_' . uniqid();

            // Prepare SQL statement to insert profile image into ProfilePhoto table
            $insertStmt = $conn->prepare("INSERT INTO ProfilePhoto (PhotoID, UserID, PhotoPath, UploadDateTime) VALUES (?, ?, ?, NOW())");

            if ($insertStmt) {
                // Bind parameters for profile-image2 and profile-image3
                $insertStmt->bind_param("sss", $photoID, $userID, $photoPath);

                // Execute SQL statement
                if ($insertStmt->execute()) {
                    echo "Profile image $i uploaded successfully to ProfilePhoto table.";
                    $success = true;
                } else {
                    echo "Error executing SQL: " . $insertStmt->error;
                }

                $insertStmt->close();
            } else {
                echo "Error preparing SQL statement: " . $conn->error;
            }
        }
    }

    // Check if operation was successful
    if ($success) {
        header("Location: success.php");
        exit;
    } else {
        echo "Operation failed.";
    }
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    //a test
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Success - Silver Connections</title>
    <link rel="stylesheet" href="success.php.css">
</head>
<body style="background: linear-gradient(45deg, #ff99cc, #ff66b2, #e64980);">

<div class="success-container">
    <h2>Success! You have registered for Silver Connections.</h2>
    <p>Please click the button below to log in.</p>
    <a href="index.php" class="login-button">Log In</a>
</div>

</body>
</html>
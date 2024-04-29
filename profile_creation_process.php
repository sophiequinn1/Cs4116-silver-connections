<?php
session_start();
// Initialize connection
$conn = new mysqli('localhost', 'root', '', 'local_database');

// Check connection
if($conn->connect_error) {
    die('Connection Failed : '.$conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // File details for profile-image1
    $file1Name = $_FILES["profile-image1"]["name"];
    $file1TmpName = $_FILES["profile-image1"]["tmp_name"];
    $file1Type = $_FILES["profile-image1"]["type"];
    $file1Size = $_FILES["profile-image1"]["size"];

    // Check if file1 is uploaded
    if ($file1TmpName) {
        // Read file1 content
        $file1Content = file_get_contents($file1TmpName);

        // Encode file1 content to base64
        $base64Image1 = base64_encode($file1Content);

        // Sanitize user input
        $age = mysqli_real_escape_string($conn, $_POST['age']);
        $country = mysqli_real_escape_string($conn, $_POST['country']);
        $city = mysqli_real_escape_string($conn, $_POST['city']);
        $bio = mysqli_real_escape_string($conn, $_POST['bio']);
        $gender = mysqli_real_escape_string($conn, $_POST['gender']);
        $looking_for = mysqli_real_escape_string($conn, $_POST['looking_for']);

        // Retrieve interests from form
        $interests = array();
        for ($i = 1; $i <= 6; $i++) {
            if (isset($_POST['hobby' . $i])) {
                $interests[] = mysqli_real_escape_string($conn, $_POST['hobby' . $i]);
            }
        }

        // Combine interests into a comma-separated string
        $interestsString = implode(',', $interests);

        $userID = $_SESSION['UserId'];

        // Prepare SQL statement to insert profile-image1 into profiles table
        $stmt = $conn->prepare("INSERT INTO profiles (Photo, Gender, Age, SexualPreference, Bio, City, Country, Interests, UserID) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

        if($stmt) {
            // Bind parameters for profile-image1
            $stmt->bind_param("ssiissssi", $base64Image1, $gender, $age, $looking_for, $bio, $city, $country, $interestsString, $userID);

            // Execute SQL statement for profile-image1
            if($stmt->execute()) {
                // Retrieve auto-generated ProfilePhotoID
                $profilePhotoID = $conn->insert_id;

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

                echo "Profile created successfully. ProfilePhotoID: " . $profilePhotoID;
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
    $success = false;

    // Handling profile-image2 and profile-image3
    for ($i = 1; $i <= 3; $i++) {
        $fileNName = $_FILES["profile-image$i"]["name"];
        $fileNTmpName = $_FILES["profile-image$i"]["tmp_name"];

        // Check if file is uploaded
        if ($fileNTmpName) {
            echo "Processing profile image $i...";

            // Read file content
            $fileNContent = file_get_contents($fileNTmpName);

            if ($fileNContent === false) {
                echo "Error reading file content for profile image $i";
                continue; // Skip this iteration
            }

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

    if ($success) {
        header("Location: success.php");
        exit;
    } else {
        exit;
    }

    // Close connection
    $conn->close();
}
?>

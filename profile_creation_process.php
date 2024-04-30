<?php
session_start();

$conn = new mysqli('localhost', 'root', '', 'local_database');


if($conn->connect_error) {
    die('Connection Failed : '.$conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $file1Name = $_FILES["profile-image1"]["name"];
    $file1TmpName = $_FILES["profile-image1"]["tmp_name"];
    $file1Type = $_FILES["profile-image1"]["type"];
    $file1Size = $_FILES["profile-image1"]["size"];

    if ($file1TmpName) {

        $file1Content = file_get_contents($file1TmpName);


        $base64Image1 = base64_encode($file1Content);


        $age = mysqli_real_escape_string($conn, $_POST['age']);
        $country = mysqli_real_escape_string($conn, $_POST['country']);
        $city = mysqli_real_escape_string($conn, $_POST['city']);
        $bio = mysqli_real_escape_string($conn, $_POST['bio']);
        $gender = mysqli_real_escape_string($conn, $_POST['gender']);
        $looking_for = mysqli_real_escape_string($conn, $_POST['looking_for']);


        $interests = array();
        for ($i = 1; $i <= 6; $i++) {
            if (isset($_POST['hobby' . $i])) {
                $interests[] = mysqli_real_escape_string($conn, $_POST['hobby' . $i]);
            }
        }


        $interestsString = implode(',', $interests);

        $userID = $_SESSION['UserId'];


        $stmt = $conn->prepare("INSERT INTO profiles (Photo, Gender, Age, SexualPreference, Bio, City, Country, Interests, UserID) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

        if($stmt) {

            $stmt->bind_param("ssiissssi", $base64Image1, $gender, $age, $looking_for, $bio, $city, $country, $interestsString, $userID);


            if($stmt->execute()) {

                $profilePhotoID = $conn->insert_id;


                $updateStmt = $conn->prepare("UPDATE profiles SET ProfilePhotoID = ? WHERE UserID = ?");
                $updateStmt->bind_param("ii", $profilePhotoID, $userID);
                $updateStmt->execute();
                $updateStmt->close();


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


    for ($i = 1; $i <= 3; $i++) {
        $fileNName = $_FILES["profile-image$i"]["name"];
        $fileNTmpName = $_FILES["profile-image$i"]["tmp_name"];


        if ($fileNTmpName) {
            echo "Processing profile image $i...";


            $fileNContent = file_get_contents($fileNTmpName);

            if ($fileNContent === false) {
                echo "Error reading file content for profile image $i";
                continue; // Skip this iteration
            }


            $photoPath = mysqli_real_escape_string($conn, $fileNContent);


            $photoID = $_SESSION['UserId'] . '_' . uniqid();


            $insertStmt = $conn->prepare("INSERT INTO ProfilePhoto (PhotoID, UserID, PhotoPath, UploadDateTime) VALUES (?, ?, ?, NOW())");

            if ($insertStmt) {

                $insertStmt->bind_param("sss", $photoID, $userID, $photoPath);


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

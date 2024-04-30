<?php
session_start();
require 'navbar.php';

$servername = "sql204.infinityfree.com";
$username_db = "if0_36147664";
$password_db = "cs4116project";
$dbname = "if0_36147664_silver_connections";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username_db, $password_db);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $userID = $_SESSION['UserId'] ?? null;


    $age = '';


    $stmt = $pdo->prepare("SELECT date_of_birth FROM users WHERE id = ?");
    $stmt->execute([$userID]);

    $date_of_birth = $stmt->fetchColumn();

    if ($date_of_birth !== false) {

        $birth_date = new DateTime($date_of_birth);
        $current_date = new DateTime();
        $age = $current_date->diff($birth_date)->y;
    } else {
        echo "Date of birth not found.<br>";
    }

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Profile</title>
    <link rel="stylesheet" href="profile_creation.css">
    <style>
        @font-face {
            font-family: 'Love Ya Like A Sister';
            src: url('LoveYaLikeASister-myEa.ttf') format('truetype');
        }
        .custom-file-label {
            font-family: 'Love Ya Like A Sister', sans-serif !important; /* Use the custom font */
            font-size: 11px;
        }
    </style>
</head>
<body>
<div class="banner">
    <img src="logo.PNG" alt="Silver Connections Logo">
    <div class="create-profile-text">
        CREATE A PROFILE
    </div>
  </div>
<div class="container">
    <form action="profile_creation_process.php" method="post" enctype="multipart/form-data">
        <div class="profile-section">
            <div class="pic-boxes">
                <div class="pic-box-1">
                    <input type="file" name="profile-image1" id="profile-image1" accept="image/*" hidden onchange="displayImage('profile-image1', 'pic-box-1')">
                    <label for="profile-image1" class="custom-file-label" id="profile-image1-label" onclick="document.getElementById('profile-image1').click()">Profile Pic!</label>
                    <img id="preview-image1" src="#" alt="Preview Image" style="display:none;">
                </div>
                <div class="pic-box-two">
                    <input type="file" name="profile-image2" id="profile-image2" accept="image/*" hidden onchange="displayImage('profile-image2', 'pic-box-two')">
                    <label for="profile-image2" class="custom-file-label" id="profile-image2-label" onclick="document.getElementById('profile-image2').click()">Another Pic!</label>
                    <img id="preview-image2" src="#" alt="Preview Image" style="display:none;">
                </div>
                <div class="pic-box-three">
                    <input type="file" name="profile-image3" id="profile-image3" accept="image/*" hidden onchange="displayImage('profile-image3', 'pic-box-three')">
                    <label for="profile-image3" class="custom-file-label" id="profile-image3-label" onclick="document.getElementById('profile-image3').click()">Another Pic!</label>
                    <img id="preview-image3" src="#" alt="Preview Image" style="display:none;">
                </div>
            </div>
            <div class="profile-details">
                <div class="input-group age-group">
                    <label for="age">Age:</label>
                    <input type="text" id="age" name="age" value="<?php echo htmlspecialchars($age); ?>">
                </div>
                <div class="input-group">
                    <label for="country">Country:</label>
                    <select id="country" name="country">

                    </select>
                </div>
                <div class="input-group">
                    <label for="city">Town/City:</label>
                    <input type="text" id="city" name="city">
                </div>
                <div class="input-group">
                    <label for="bio">Biography:</label>
                    <textarea id="bio" name="bio" rows="8"></textarea>
                </div>
            </div>

            <div class="hobbies-group-one">
                <div class="input-group">
                    <label for="hobby1">Hobby 1:</label>
                    <input type="text" id="hobby1" name="hobby1">
                </div>
                <div class="input-group">
                    <label for="hobby2">Hobby 2:</label>
                    <input type="text" id="hobby2" name="hobby2">
                </div>
                <div class="input-group">
                    <label for="hobby3">Hobby 3:</label>
                    <input type="text" id="hobby3" name="hobby3">
                </div>
                <div class="input-group">
                    <label for="gender">Gender:</label>
                    <select id="gender" name="gender">
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                <input type="submit" name="submit" value="Submit" style="background-color: #6c2a8f; color: white; border: none; border-radius: 4px; padding: 15px 30px; font-size: 18px; height: 50px; cursor: pointer; transition: background-color 0.3s; margin-top: 13px; margin-left: 55px;">
            </div>
            <div class="hobbies-group-two">
                <div class="input-group">
                    <label for="hobby4">Hobby 4:</label>
                    <input type="text" id="hobby4" name="hobby4">
                </div>
                <div class="input-group">
                    <label for="hobby5">Hobby 5:</label>
                    <input type="text" id="hobby5" name="hobby5">
                </div>
                <div class="input-group">
                    <label for="hobby6">Hobby 6:</label>
                    <input type="text" id="hobby6" name="hobby6">
                </div>
                <div class="input-group">
                    <label for="looking_for">Looking For:</label>
                    <select id="looking_for" name="looking_for">
                        <option value="1">Male</option>
                        <option value="2">Female</option>
                        <option value="3">Other</option>
                    </select>
                </div>
            </div>
        </div>
    </form>
</div>
<script>

    const countries = [
        "Afghanistan", "Albania", "Algeria", "Andorra", "Angola", "Antigua and Barbuda", "Argentina", "Armenia", "Australia", "Austria",
        "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bhutan", "Bolivia",
        "Bosnia and Herzegovina", "Botswana", "Brazil", "Brunei", "Bulgaria", "Burkina Faso", "Burundi", "Cabo Verde", "Cambodia",
        "Cameroon", "Canada", "Central African Republic", "Chad", "Chile", "China", "Colombia", "Comoros", "Congo (Congo-Brazzaville)",
        "Costa Rica", "Croatia", "Cuba", "Cyprus", "Czechia (Czech Republic)", "Democratic Republic of the Congo", "Denmark", "Djibouti",
        "Dominica", "Dominican Republic", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Eswatini (fmr. Swaziland)",
        "Ethiopia", "Fiji", "Finland", "France", "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Greece", "Grenada", "Guatemala",
        "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Holy See", "Honduras", "Hungary", "Iceland", "India", "Indonesia", "Iran", "Iraq",
        "Ireland", "Israel", "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Kuwait", "Kyrgyzstan", "Laos",
        "Latvia", "Lebanon", "Lesotho", "Liberia", "Libya", "Liechtenstein", "Lithuania", "Luxembourg", "Madagascar", "Malawi", "Malaysia",
        "Maldives", "Mali", "Malta", "Marshall Islands", "Mauritania", "Mauritius", "Mexico", "Micronesia", "Moldova", "Monaco", "Mongolia",
        "Montenegro", "Morocco", "Mozambique", "Myanmar (formerly Burma)", "Namibia", "Nauru", "Nepal", "Netherlands", "New Zealand", "Nicaragua",
        "Niger", "Nigeria", "North Korea", "North Macedonia", "Norway", "Oman", "Pakistan", "Palau", "Palestine State", "Panama", "Papua New Guinea",
        "Paraguay", "Peru", "Philippines", "Poland", "Portugal", "Qatar", "Romania", "Russia", "Rwanda", "Saint Kitts and Nevis", "Saint Lucia",
        "Saint Vincent and the Grenadines", "Samoa", "San Marino", "Sao Tome and Principe", "Saudi Arabia", "Senegal", "Serbia", "Seychelles",
        "Sierra Leone", "Singapore", "Slovakia", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Korea", "South Sudan", "Spain",
        "Sri Lanka", "Sudan", "Suriname", "Sweden", "Switzerland", "Syria", "Tajikistan", "Tanzania", "Thailand", "Timor-Leste", "Togo", "Tonga",
        "Trinidad and Tobago", "Tunisia", "Turkey", "Turkmenistan", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom",
        "United States of America", "Uruguay", "Uzbekistan", "Vanuatu", "Venezuela", "Vietnam", "Yemen", "Zambia", "Zimbabwe"
    ];


    const countrySelect = document.getElementById('country');


    countries.forEach(country => {
        const option = document.createElement('option');
        option.value = country;
        option.text = country;
        countrySelect.appendChild(option);
    });

    function hideLabel(labelId) {
        const label = document.getElementById(labelId);
        label.style.display = 'none';
    }

    function displayImage(inputId, picBoxClass) {
        const input = document.getElementById(inputId);
        const picBox = document.querySelector(`.${picBoxClass}`);
        const img = picBox.querySelector('img');
        const label = document.getElementById(`${inputId}-label`);

        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
                img.src = e.target.result;
                img.style.display = 'block';
                img.style.width = '100%';
                img.style.height = '100%';
                img.style.objectFit = 'cover';
                label.style.display = 'none';
            };

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
</body>
</html>

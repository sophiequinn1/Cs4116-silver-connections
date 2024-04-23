<?php
// Start session
session_start();
require 'navbar.php';

// Database connection parameters
$host = 'sql204.infinityfree.com';
$dbname = 'if0_36314684_cs4116silverconnections';
$username = 'if0_36314684';
$password = 'cs4116silvercon';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch age from the profiles table using the profile ID stored in the session
    $profile_id = isset($_SESSION['profile_id']) ? $_SESSION['profile_id'] : null; // Retrieve profile ID from session

    if (!$profile_id) {
        throw new Exception("Profile ID is not set in session.");
    }

    $stmt = $pdo->prepare("SELECT age FROM profiles WHERE profile_id = ?");
    $stmt->execute([$profile_id]);

    $age = $stmt->fetchColumn();

    if ($age === false) {
        $age = ''; // Default value if age is not found
        echo "Age not found in database.<br>";  // Debug output
    } else {
        echo "Fetched Age: " . $age . "<br>";  // Debug output
    }

} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Profile</title>
    <link rel="stylesheet" href="profile_creation.css">
</head>
<body>
<div class="container">
    <div class="profile-section">
        <div class="profile-picture">
            <label for="profile-image" class="profile-image-label">
                <img src="./placeholder.jpg" alt="Select Profile Picture">
                <input type="file" name="profile-image" id="profile-image" accept="image/*">
            </label>
        </div>
        <div class="logo">
            <img src="./logo.PNG" alt="Logo">
        </div>
    </div>
    <div class="profile-details">
        <div class="input-group">
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
</div>
<script>
    // Populate the country dropdown
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

    // Get the select element
    const countrySelect = document.getElementById('country');

    // Populate the dropdown with countries
    countries.forEach(country => {
        const option = document.createElement('option');
        option.value = country;
        option.text = country;
        countrySelect.appendChild(option);
    });
</script>
</body>
</html>
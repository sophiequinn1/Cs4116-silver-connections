<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="register_page.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <title>User Registration</title>
</head>
<body>
<h2>User Registration</h2>
<form action="register.php" method="post">
    <label for="fullname">Full Name:</label>
    <input type="text" id="fullname" name="fullname" required><br><br>

    <label for="username">Username:</label>
    <input type="text" id="username" name="username" required><br><br>

    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required><br><br>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required><br><br>

    <label for="dob">Date of Birth:</label>
    <input type="date" id="dob" name="dob" required><br><br>

    <input type="submit" value="Register">
</form>

<script>
    function validateForm() {
        var fullname = document.getElementById('fullname').value;
        var username = document.getElementById('username').value;
        var password = document.getElementById('password').value;
        var email = document.getElementById('email').value;
        var dob = document.getElementById('dob').value;

        if (fullname !== '' && username !== '' && password !== '' && email !== '' && dob !== '') {
            document.getElementById('registerForm').submit(); // Submit the form
        } else {
            alert('Please fill out all fields.');
        }
    }
</script>

</body>
</html>

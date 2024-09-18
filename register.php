<?php

require_once('db.php');

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm-password'];

    // Check if username and passwords are provided
    if (empty($username) || empty($password) || empty($confirm_password)) {
        $error = "Please fill all fields.";
    } elseif ($password !== $confirm_password) {
        $error = "Passwords do not match.";
    } else {
        // Check if the username already exists
        $sql_check = "SELECT * FROM users WHERE username = '$username'";
        $result = mysqli_query($conn, $sql_check);
        if (mysqli_num_rows($result) > 0) {
            $error = "Username already exists.";
        } else {
            // Insert the new user into the database
            $sql = "INSERT INTO users (username, password, role) VALUES ('$username', '$password', 'user')";
            if (mysqli_query($conn, $sql)) {
                $success = "Registration successful! You can now <a href='login.php'>log in</a>.";
            } else {
                $error = "Error: " . mysqli_error($conn);
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="style.css">
    <title>Register</title>
    <script>
        // JavaScript validation for password confirmation, username and password length
        function validateForm(event) {
            var username = document.getElementById("username").value;
            var password = document.getElementById("password").value;
            var confirmPassword = document.getElementById("confirm-password").value;

            var usernameError = document.getElementById("username-error");
            var passwordError = document.getElementById("password-error");
            var confirmPasswordError = document.getElementById("confirm-password-error");

            // Clear previous errors
            usernameError.innerHTML = "";
            passwordError.innerHTML = "";
            confirmPasswordError.innerHTML = "";

            let isValid = true;

            if (username.length < 4) {
                usernameError.innerHTML = "Username must be at least 4 characters long!";
                isValid = false;
            }

            if (password.length < 4) {
                passwordError.innerHTML = "Password must be at least 4 characters long!";
                isValid = false;
            }

            if (password !== confirmPassword) {
                confirmPasswordError.innerHTML = "Passwords do not match!";
                isValid = false;
            }

            if (!isValid) {
                event.preventDefault();
            }
        }
    </script>
</head>

<body>
    <div class="login-container">
        <div>
            <img src="images/register.jpg" alt="Logo">
        </div>
        <div class="login-form">
            <h1>Register</h1>

            <?php if (!empty($error)) : ?>
                <p class="error"><?php echo $error; ?></p>
            <?php endif; ?>

            <?php if (!empty($success)) : ?>
                <p class="success-message"><?php echo $success; ?></p>
            <?php endif; ?>


            <form action="register.php" method="post" onsubmit="validateForm(event)">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username">
                    <p class="error" id="username-error"></p>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password">
                    <p class="error" id="password-error"></p>
                </div>
                <div class="form-group">
                    <label for="confirm-password">Confirm Password</label>
                    <input type="password" id="confirm-password" name="confirm-password">
                    <p class="error" id="confirm-password-error"></p>
                </div>
                <button type="submit">Register</button>
            </form>
            <div class="other-options">
                <p><a href="guest/">Continue as a Guest</a></p>
                <p>Already have an account? <a href="login.php">Login</a></p>
            </div>
        </div>
    </div>
</body>

</html>
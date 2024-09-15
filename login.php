<?php

require_once('db.php');

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_POST['username'];
    $password = $_POST['password'];
    if (empty($username) || empty($password)) {
        $error = "Please enter username and password";
    } else {


        $sql = "SELECT * FROM users WHERE username = '$username'";

        $result = mysqli_query($conn, $sql);
        $user = mysqli_fetch_assoc($result);
        if ($user && $user['password'] === $password) {
            session_start();
            $_SESSION['username'] = $username;
            $_SESSION['id'] = $user['id'];
            $_SESSION['role'] = $user['role'];

            if ($_SESSION['role'] == 'admin') {
                header("Location: admin/index.php");
            } else {
                header("Location: user/index.php");
            }
        } else {
            $error = "Invalid username or password";
        }
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>

<body>
    <div class="login-container">
        <h2>Login</h2>

        <?php if (!empty($error)) : ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>

        <form action="login.php" method="post">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>

            <button type="submit">Login</button>
        </form>
    </div>


</body>

</html>
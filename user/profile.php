<?php
session_start();
$title = "My Profile";
include '../db.php';

// Redirect if not logged in
if (!isset($_SESSION['username'])) {
    header("Location: ../login.php");
    exit();
}

// Fetch the logged-in user's information
$user_id = $_SESSION['id']; // Assuming you have stored user ID in session

// Fetch user data
$query = "SELECT * FROM users WHERE id = '$user_id'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);
} else {
    echo "User not found.";
    exit();
}

// Update user if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $contact = $_POST['contact'];
    $password = $_POST['password'];

    // Handle image upload
    if (!empty($_FILES['image']['name'])) {
        $image = $_FILES['image']['name'];
        $image_tmp = $_FILES['image']['tmp_name'];
        $upload_dir = "../uploads/users/";
        $image_path = $upload_dir . basename($image);

        if (move_uploaded_file($image_tmp, $image_path)) {
            // Delete old image if new one is uploaded
            if (!empty($user['image']) && file_exists($user['image'])) {
                unlink($user['image']);
            }

            $_SESSION['image'] = $image_path;
        } else {
            echo "Failed to upload the image.";
            exit();
        }
    } else {
        $image_path = $user['image'];
    }

    // Update user details in the database
    $update_query = "UPDATE users SET 
        username = '$username', 
        contact = '$contact', 
        image = '$image_path'";

    // Only update password if a new one is provided
    if (!empty($password)) {
        $update_query .= ", password = '$password'";
    }

    $update_query .= " WHERE id = '$user_id'";

    if (mysqli_query($conn, $update_query)) {
        // Update the session with the new username
        $_SESSION['username'] = $username;

        header('Location: profile.php?msg=Profile+updated+successfully');
        exit();
    } else {
        echo "Error updating profile: " . mysqli_error($conn);
    }
}

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="../style.css">
</head>

<body>
    <div class="admin-container">
        <?php include('../navbar.php'); ?>
        <?php include 'sidebar.php'; ?>

        <div class="admin-content">
            <h1 class="page-title">Edit Profile</h1>

            <?php if (isset($_GET['msg'])) : ?>
                <p class="success-message"><?php echo $_GET['msg']; ?></p>
            <?php endif; ?>

            <form action="profile.php" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" value="<?php echo $user['username']; ?>" required>
                </div>

                <div class="form-group">
                    <label for="password">New Password (leave blank to keep current)</label>
                    <input type="password" name="password" id="password" placeholder="New password">
                </div>

                <div class="form-group">
                    <label for="contact">Contact</label>
                    <input type="text" name="contact" id="contact" value="<?php echo $user['contact']; ?>">
                </div>

                <div class="form-group">
                    <label for="image">Profile Picture</label>
                    <input type="file" name="image" id="image" accept="image/*">
                    <?php if (!empty($user['image'])) : ?>
                        <p>Current image:</p>
                        <img src="<?php echo $user['image']; ?>" alt="Current Image" width="100" class="profile-image">
                    <?php endif; ?>
                </div>

                <button type="submit" class="create-btn">Update Profile</button>
            </form>
        </div>
    </div>
</body>

</html>
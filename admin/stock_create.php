<?php
session_start();
include '../db.php';
$title = "Manage Stock";

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $quantity = mysqli_real_escape_string($conn, $_POST['quantity']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);

    // Handle file upload
    $image = $_FILES['image']['name'];
    $image_tmp = $_FILES['image']['tmp_name'];
    $upload_dir = "../uploads/";
    $image_path = $upload_dir . basename($image);

    if (move_uploaded_file($image_tmp, $image_path)) {
        // Insert product into the database
        $query = "INSERT INTO products (name, description, price, quantity, image, category) 
                  VALUES ('$name', '$description', '$price', '$quantity', '$image_path', '$category')";

        if (mysqli_query($conn, $query)) {
            header('Location: stock_manage.php');
            exit();
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        echo "Failed to upload the image.";
    }
}

mysqli_close($conn);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Product</title>
    <link rel="stylesheet" href="../style.css">
</head>

<body>
    <div class="admin-container">
        <?php include('../navbar.php'); ?>
        <?php include 'sidebar.php'; ?>

        <div class="admin-content">
            <h1 class="page-title">Create Product</h1>

            <form action="" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="name">Product Name</label>
                    <input type="text" name="name" id="name" required>
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea name="description" id="description" rows="4" required></textarea>
                </div>

                <div class="form-group">
                    <label for="price">Price</label>
                    <input type="number" name="price" id="price" step="0.01" required>
                </div>

                <div class="form-group">
                    <label for="quantity">Quantity</label>
                    <input type="number" name="quantity" id="quantity" required>
                </div>

                <div class="form-group">
                    <label for="category">Category</label>
                    <select name="category" id="category">
                        <?php
                        $categories = ['Electronic', 'Clothing', 'Furniture', 'Food', 'Other'];
                        foreach ($categories as $cat) {
                            echo "<option value='$cat'>$cat</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="image">Product Image</label>
                    <input type="file" name="image" id="image" accept="image/*" required>
                </div>

                <button type="submit" class="create-btn">Create Product</button>
            </form>
        </div>
    </div>
</body>

</html>
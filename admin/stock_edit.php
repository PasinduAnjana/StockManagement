<?php
session_start();
include '../db.php';
if (isset($_GET['id'])) {
    $product_id = mysqli_real_escape_string($conn, $_GET['id']);

    $query = "SELECT * FROM products WHERE id = '$product_id'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $product = mysqli_fetch_assoc($result);
    } else {
        echo "Product not found.";
        exit();
    }
} else {
    echo "Invalid product ID.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $quantity = mysqli_real_escape_string($conn, $_POST['quantity']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);

    if (!empty($_FILES['image']['name'])) {
        $image = $_FILES['image']['name'];
        $image_tmp = $_FILES['image']['tmp_name'];
        $upload_dir = "../uploads/";
        $image_path = $upload_dir . basename($image);

        if (move_uploaded_file($image_tmp, $image_path)) {
            // Delete the old image if a new one is uploaded
            if (file_exists($product['image'])) {
                unlink($product['image']);
            }
        } else {
            echo "Failed to upload the image.";
            exit();
        }
    } else {
        $image_path = $product['image']; // Keep the old image if not updated
    }

    // Update the product
    $update_query = "UPDATE products SET 
        name = '$name', 
        description = '$description', 
        price = '$price', 
        quantity = '$quantity', 
        category = '$category', 
        image = '$image_path' 
        WHERE id = '$product_id'";

    if (mysqli_query($conn, $update_query)) {
        header('Location: stock_manage.php');
        exit();
    } else {
        echo "Error updating product: " . mysqli_error($conn);
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
    <title>Edit Product</title>
    <link rel="stylesheet" href="../style.css">
</head>

<body>
    <div class="admin-container">
        <?php include('./navbar.php'); ?>
        <?php include 'sidebar.php'; ?>

        <div class="admin-content">
            <h1 class="page-title">Edit Product</h1>

            <form action="stock_edit.php?id=<?php echo $product['id']; ?>" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="name">Product Name</label>
                    <input type="text" name="name" id="name" value="<?php echo $product['name']; ?>" required>
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea name="description" id="description" rows="4" required><?php echo $product['description']; ?></textarea>
                </div>

                <div class="form-group">
                    <label for="price">Price</label>
                    <input type="number" name="price" id="price" step="0.01" value="<?php echo $product['price']; ?>" required>
                </div>

                <div class="form-group">
                    <label for="quantity">Quantity</label>
                    <input type="number" name="quantity" id="quantity" value="<?php echo $product['quantity']; ?>" required>
                </div>

                <div class="form-group">
                    <label for="category">Category</label>
                    <select name="category" id="category">
                        <?php
                        $categories = ['Electronic', 'Clothing', 'Furniture', 'Food', 'Other'];
                        foreach ($categories as $cat) {
                            echo "<option value='$cat'" . ($product['category'] == $cat ? ' selected' : '') . ">$cat</option>";
                        }
                        ?>
                    </select>
                </div>


                <div class="form-group">
                    <label for="image">Product Image</label>
                    <input type="file" name="image" id="image" accept="image/*">
                    <p>
                    <p>Current image:</p> <img src="<?php echo $product['image']; ?>" alt="Current Image" width="100"></p>
                </div>

                <button type="submit" class="create-btn">Update Product</button>
            </form>
        </div>
    </div>
</body>

</html>
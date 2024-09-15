<?php
session_start();
include '../db.php'; // Include your database connection file

// Check if product ID is passed as a URL parameter
if (isset($_GET['id'])) {
    $product_id = mysqli_real_escape_string($conn, $_GET['id']);

    // Fetch the product image path to delete the image file
    $query = "SELECT image FROM products WHERE id = '$product_id'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);

    if ($row) {
        // Delete the product image from the server
        $image_path = $row['image'];
        if (file_exists($image_path)) {
            unlink($image_path); // Delete the image file
        }

        // Delete the product from the database
        $delete_query = "DELETE FROM products WHERE id = '$product_id'";
        if (mysqli_query($conn, $delete_query)) {
            // Redirect to manage_stock.php after successful deletion
            header('Location: stock_manage.php');
            exit();
        } else {
            echo "Error deleting product: " . mysqli_error($conn);
        }
    } else {
        echo "Product not found.";
    }
} else {
    echo "Invalid product ID.";
}

// Close the database connection
mysqli_close($conn);

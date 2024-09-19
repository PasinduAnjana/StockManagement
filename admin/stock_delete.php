<?php
session_start();
include '../db.php';

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}


if (isset($_GET['id'])) {
    $product_id = mysqli_real_escape_string($conn, $_GET['id']);

    $query = "SELECT image FROM products WHERE id = '$product_id'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);

    if ($row) {
        $image_path = $row['image'];
        if (file_exists($image_path)) {
            unlink($image_path);
        }

        $delete_query = "DELETE FROM products WHERE id = '$product_id'";
        if (mysqli_query($conn, $delete_query)) {
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

mysqli_close($conn);

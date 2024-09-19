<?php
session_start();
include '../db.php';

if (!isset($_SESSION['id']) || $_SESSION['role'] != 'admin') {
    echo "You must be an admin to perform this action.";
    exit;
}

if (!isset($_GET['id']) || !isset($_GET['status'])) {
    echo "Invalid request.";
    exit;
}

$order_id = $_GET['id'];
$status = $_GET['status'];

// Validate status value
if (!in_array($status, ['approved', 'rejected'])) {
    echo "Invalid status.";
    exit;
}

// Fetch the order details
$order_query = "SELECT * FROM orders WHERE id = $order_id";
$order_result = mysqli_query($conn, $order_query);
$order = mysqli_fetch_assoc($order_result);

if (!$order) {
    echo "Order not found.";
    exit;
}

$product_id = $order['product_id'];
$quantity = $order['quantity'];

// Update the order status
$update_status_query = "UPDATE orders SET status = '$status' WHERE id = $order_id";
mysqli_query($conn, $update_status_query);

// If rejected, update the stock quantity
if ($status == 'rejected') {
    // Fetch current stock
    $product_query = "SELECT quantity FROM products WHERE id = $product_id";
    $product_result = mysqli_query($conn, $product_query);
    $product = mysqli_fetch_assoc($product_result);

    $new_quantity = $product['quantity'] + $quantity;

    // Update product quantity
    $update_quantity_query = "UPDATE products SET quantity = $new_quantity WHERE id = $product_id";
    mysqli_query($conn, $update_quantity_query);
}

mysqli_close($conn);

// Redirect back to the orders page
header("Location: order_view.php");
exit;

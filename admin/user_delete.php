<?php
session_start();
include '../db.php';

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

if (isset($_GET['id'])) {
    $user_id = mysqli_real_escape_string($conn, $_GET['id']);

    $delete_orders_query = "DELETE FROM orders WHERE user_id = $user_id";
    $result_orders = mysqli_query($conn, $delete_orders_query);

    if ($result_orders) {
        $delete_user_query = "DELETE FROM users WHERE id = $user_id";
        $result_user = mysqli_query($conn, $delete_user_query);

        if ($result_user) {
            header("Location: manage_users.php?message=success");
            exit();
        } else {
            echo "Error deleting user: " . mysqli_error($conn);
        }
    } else {
        echo "Error deleting orders: " . mysqli_error($conn);
    }
} else {
    echo "Invalid user ID.";
}

mysqli_close($conn);

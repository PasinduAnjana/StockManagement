<?php
session_start();
include '../db.php';

// Check if the user is logged in and is an admin
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

if (isset($_GET['id'])) {
    $user_id = mysqli_real_escape_string($conn, $_GET['id']);

    // Delete related orders
    $delete_orders_query = "DELETE FROM orders WHERE user_id = $user_id";
    $result_orders = mysqli_query($conn, $delete_orders_query);

    if ($result_orders) {
        // Now delete the user after deleting related orders
        $delete_user_query = "DELETE FROM users WHERE id = $user_id";
        $result_user = mysqli_query($conn, $delete_user_query);

        if ($result_user) {
            // Redirect to the user management page after successful deletion
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

// Close the database connection
mysqli_close($conn);

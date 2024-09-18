<?php
session_start();

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

$title = "Home";

// Database connection
include '../db.php';

// Fetch users count
$user_query = "SELECT COUNT(*) as count FROM users";
$user_result = mysqli_query($conn, $user_query);
$user_count = mysqli_fetch_assoc($user_result)['count'];

// Fetch products count
$product_query = "SELECT COUNT(*) as count FROM products";
$product_result = mysqli_query($conn, $product_query);
$product_count = mysqli_fetch_assoc($product_result)['count'];

// Fetch orders count
$order_query = "SELECT COUNT(*) as count FROM orders";
$order_result = mysqli_query($conn, $order_query);
$order_count = mysqli_fetch_assoc($order_result)['count'];

// Close connection
mysqli_close($conn);


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <title>Admin Dashboard</title>
</head>

<body>
    <div class="admin-container">
        <!-- Navbar inclusion -->
        <?php include('../navbar.php'); ?>

        <!-- Sidebar inclusion -->
        <?php include('sidebar.php'); ?>

        <!-- Main content area -->
        <main class="admin-content">
            <header class="admin-header">
                <h1>Dashboard</h1>
            </header>
            <section>
                <h2>Summary</h2>
                <div class="card-container">
                    <a href="manage_users.php" class="card">
                        <img src="../images/person.png" alt="Users Icon" width="40" class="card-icon">
                        <p>Users</p>
                        <p style="font-size: 3rem;"><?php echo $user_count; ?></p>
                    </a>
                    <a href="stock_manage.php" class="card">
                        <img src="../images/packages.png" alt="Products Icon" width="40" class="card-icon">
                        <p>Products</p>
                        <p style="font-size: 3rem;"><?php echo $product_count; ?></p>
                    </a>
                    <a href="order_view.php" class="card">
                        <img src="../images/clipboard.png" alt="Orders Icon" width="40" class="card-icon">
                        <p>Orders</p>
                        <p style="font-size: 3rem;"><?php echo $order_count; ?></p>
                    </a>
                </div>



            </section>
        </main>
    </div>
</body>

</html>
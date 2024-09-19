<?php
session_start();

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

$title = "Home";
include '../db.php';

// user count
$user_query = "SELECT COUNT(*) as count FROM users";
$user_result = mysqli_query($conn, $user_query);
$user_count = mysqli_fetch_assoc($user_result)['count'];

// products count
$product_query = "SELECT COUNT(*) as count FROM products";
$product_result = mysqli_query($conn, $product_query);
$product_count = mysqli_fetch_assoc($product_result)['count'];

// order count
$order_query = "SELECT COUNT(*) as count FROM orders";
$order_result = mysqli_query($conn, $order_query);
$order_count = mysqli_fetch_assoc($order_result)['count'];

mysqli_close($conn);


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="../style.css">
    <title>Admin Dashboard</title>
</head>

<body>
    <div class="admin-container">
        <?php include('../navbar.php'); ?>
        <?php include('sidebar.php'); ?>

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
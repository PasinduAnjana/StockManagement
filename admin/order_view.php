<?php
session_start();
include '../db.php';


if (!isset($_SESSION['id']) || $_SESSION['role'] != 'admin') {
    echo "You must be an admin to view this page.";
    exit;
}

$title = "View Orders";

$query = "
    SELECT o.id as order_id, p.name as product_name, o.quantity, p.price, o.order_date, p.image, u.username
    FROM orders o
    JOIN products p ON o.product_id = p.id
    JOIN users u ON o.user_id = u.id
    ORDER BY o.order_date DESC
";

$result = mysqli_query($conn, $query);
$orders = mysqli_fetch_all($result, MYSQLI_ASSOC);

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Orders</title>
    <link rel="stylesheet" href="../style.css">
</head>

<body>
    <div class="admin-container">
        <?php include('../navbar.php'); ?>
        <?php include 'sidebar.php'; ?>

        <div class="admin-content">
            <h1 class="page-title">All Orders</h1>

            <?php if (empty($orders)): ?>
                <p>No orders available.</p>
            <?php else: ?>
                <table>
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Order ID</th>
                            <th>User Name</th>
                            <th>Product Name</th>
                            <th>Quantity</th>
                            <th>Item Price</th>
                            <th>Total Price</th>
                            <th>Order Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orders as $order): ?>
                            <tr>
                                <td>
                                    <?php
                                    if (!empty($order['image'])) {
                                        echo "<img src='" . $order['image'] . "' alt='Product Image' class='product-image-small'>";
                                        echo "<img src='" . $order['image'] . "' alt='Product Image' class='product-image-large'>";
                                    } else {
                                        echo "No image";
                                    } ?>
                                </td>
                                <td><?php echo $order['order_id']; ?></td>
                                <td><?php echo $order['username']; ?></td>
                                <td><?php echo $order['product_name']; ?></td>
                                <td><?php echo $order['quantity']; ?></td>
                                <td>Rs.<?php echo number_format($order['price'], 2); ?></td>
                                <td>Rs.<?php echo number_format($order['price'] * $order['quantity'], 2); ?></td>
                                <td><?php echo date('Y-m-d H:i', strtotime($order['order_date'])); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>
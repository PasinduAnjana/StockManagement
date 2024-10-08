<?php
session_start();
include '../db.php';


if (!isset($_SESSION['id']) || $_SESSION['role'] != 'admin') {
    echo "You must be an admin to view this page.";
    exit;
}

$title = "View Orders";

$query = "
    SELECT o.id as order_id, p.name as product_name, o.quantity,o.status, p.price, o.order_date, p.image, u.username
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
                            <th>Status</th>
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
                                <td>
                                    <?php
                                    if ($order['status'] == 'pending') {
                                        echo "<a class='edit-btn' href='order_status.php?id=" . $order['order_id'] . "&status=approved'>Approve</a>";
                                        echo "<a class='delete-btn' href='order_status.php?id=" . $order['order_id'] . "&status=rejected'>Reject</a>";
                                    } else {
                                        if ($order['status'] == 'approved') {
                                            echo "<span style='color: green; font-weight: bold;'>Approved</span>";
                                        } else if ($order['status'] == 'rejected') {
                                            echo "<span style='color: red;'>Rejected</span>";
                                        }
                                    }
                                    ?>
                                </td>

                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>
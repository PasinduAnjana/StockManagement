<?php
session_start();

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}
$title = "Help";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Help</title>
    <link rel="stylesheet" href="../style.css">
</head>

<body>
    <div class="admin-container">
        <?php include('../navbar.php'); ?>
        <?php include 'sidebar.php'; ?>

        <div class="admin-content">
            <h1 class="page-title">Help</h1>
            <div class="help-container">
                <div class="help-card">
                    <h3 class="help-title">Dashboard Sumamry</h3>
                    <p>You will see the summary of your stocks and users by default. You can change the view by clicking on the "Home" tab in the sidebar.</p>
                </div>

                <div class="help-card">
                    <h3 class="help-title">Managing Users</h3>
                    <p>To manage users, click on the "Manage Users" tab in the sidebar.
                        You will see a list of all users and their details. You can delete the user accounts.
                        But this will cause all their orders to be deleted.
                    </p>
                </div>

                <div class="help-card">
                    <h3 class="help-title">Managing Stock</h3>
                    <p>To manage stock, click on the "Manage Stock" tab in the sidebar.
                        You will see a list of all products and their details. You can update, and delete products.
                        To add new stocks click on the 'Add' button of the product you want to add.
                        You can enter the count and change the quantity.
                    </p>
                </div>

                <div class="help-card">
                    <h3 class="help-title">Creating New Products</h3>
                    <p>To create new products, click on the "Click Product" button in Manage Stock page.
                        You will see a form to enter the product details. Enter the details and click on 'Create Product'.
                </div>

                <div class="help-card">
                    <h3 class="help-title">View Orders</h3>
                    <p>To view orders, click on the "View Orders" tab in the sidebar.
                        You will see a list of all orders and the status of each order.
                        You can approve or reject the order.
                </div>

            </div>
        </div>

    </div>
</body>

</html>
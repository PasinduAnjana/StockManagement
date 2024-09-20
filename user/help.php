<?php
session_start();

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'user') {
    header("Location: ../login.php");
    exit();
}
$title = "Help";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>My Orders</title>
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
                    <p>You will see the summary of your stocks by default. You can navigate to summary from anywhere by clicking on the "Home" tab in the sidebar.</p>
                </div>

                <div class="help-card">
                    <h3 class="help-title">How do I view available stocks?</h3>
                    <p>To view available stocks, click on the "View Stocks" tab in the sidebar.</p>
                </div>

                <div class="help-card">
                    <h3 class="help-title">How do I place an order?</h3>
                    <p>In the 'View Stocks' page, click on the 'Order' button of the product you want to place an order.
                        Then enter the quantity you want to order and click on the 'Place order' button.
                        The order will mark as "Pending". The admin will approve or reject the order.
                    </p>
                </div>

                <div class="help-card">
                    <h3 class="help-title">How do I view my orders?</h3>
                    <p>To view your orders, click on the "View Orders" tab in the sidebar.
                        You will see a list of your orders and the status of each order.</p>
                </div>

                <div class="help-card">
                    <h3 class="help-title">How do I change my Profile Details?</h3>
                    <p>In the "Profile" tab, you can update your profile details such as username, password, and contact and profile picture.</p>
                </div>
            </div>
        </div>
</body>

</html>
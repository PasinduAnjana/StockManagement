<?php
session_start();
include '../db.php';

if (!isset($_GET['id'])) {
    echo "No product selected.";
    exit;
}

$product_id = $_GET['id'];
$query = "SELECT * FROM products WHERE id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, 'i', $product_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$product = mysqli_fetch_assoc($result);

if (!$product) {
    echo "Product not found.";
    exit;
}

$title = "Order Product";
$order_success = false; // To track if the order was successful

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $quantity = intval($_POST['quantity']);

    if ($quantity > 0 && $quantity <= $product['quantity']) {
        $user_id = $_SESSION['id']; // Assuming user_id is stored in session after login
        $order_query = "INSERT INTO orders (user_id, product_id, quantity, order_date) VALUES (?, ?, ?, NOW())";
        $order_stmt = mysqli_prepare($conn, $order_query);
        mysqli_stmt_bind_param($order_stmt, 'iii', $user_id, $product_id, $quantity);
        mysqli_stmt_execute($order_stmt);

        // Reduce the stock count
        $new_stock = $product['quantity'] - $quantity;
        $update_stock_query = "UPDATE products SET quantity = ? WHERE id = ?";
        $update_stock_stmt = mysqli_prepare($conn, $update_stock_query);
        mysqli_stmt_bind_param($update_stock_stmt, 'ii', $new_stock, $product_id);
        mysqli_stmt_execute($update_stock_stmt);

        $product['quantity'] = $new_stock; // Update the product quantity in the page
        $order_success = true; // Indicate that the order was successful
    } else {
        echo "<p>Invalid quantity. Please select a valid quantity.</p>";
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <link rel="stylesheet" href="../style.css">
    <script>
        function updateQuantity(change) {
            var quantityInput = document.getElementById('quantity');
            var currentQuantity = parseInt(quantityInput.value);
            var newQuantity = currentQuantity + change;

            if (newQuantity >= 0 && newQuantity <= <?php echo $product['quantity']; ?>) {
                quantityInput.value = newQuantity;
            }
        }

        function hideSuccessMessage() {
            setTimeout(function() {
                document.getElementById('success-message').style.display = 'none';
            }, 3000);
        }
    </script>
</head>

<body onload="hideSuccessMessage()">

    <div class="admin-container">
        <?php include('../navbar.php'); ?>
        <?php include 'sidebar.php'; ?>

        <div class="admin-content">
            <h1 class="page-title"><?php echo $title; ?></h1>

            <div class="product-order-container">
                <div class="product-order-image-large">
                    <?php if (!empty($product['image'])): ?>
                        <img src="<?php echo $product['image']; ?>" alt="Product Image">
                    <?php else: ?>
                        <div class="no-image">No Image</div>
                    <?php endif; ?>
                </div>

                <div class="product-details">
                    <h2><?php echo $product['name']; ?></h2>
                    <p><?php echo $product['description']; ?></p>
                    <p><strong>Category:</strong> <?php echo $product['category']; ?></p>
                    <p><strong>Price:</strong> Rs.<?php echo number_format($product['price'], 2); ?></p>
                    <p><strong>Available Quantity:</strong> <?php echo $product['quantity']; ?></p>

                    <form action="" method="POST">
                        <div class="quantity-control">
                            <button type="button" onclick="updateQuantity(-1)">-</button>
                            <input type="number" id="quantity" name="quantity" value="1" min="1" max="<?php echo $product['quantity']; ?>" required>
                            <button type="button" onclick="updateQuantity(1)">+</button>
                        </div>
                        <button type="submit" class="order-btn">Place Order</button>
                    </form>

                    <?php if ($order_success): ?>
                        <div id="success-message" class="success-message">
                            Order placed successfully!
                        </div>
                    <?php endif; ?>
                </div>


            </div>
        </div>
    </div>

</body>

</html>
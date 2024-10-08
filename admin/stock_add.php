<?php
session_start();
include '../db.php';

if (!isset($_SESSION['id']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit;
}

if (!isset($_GET['id'])) {
    echo "No product selected.";
    exit;
}

$product_id = $_GET['id'];

$query = "SELECT * FROM products WHERE id = $product_id";
$result = mysqli_query($conn, $query);
$product = mysqli_fetch_assoc($result);

if (!$product) {
    echo "Product not found.";
    exit;
}

$title = "Add Products to Stock";
$update_success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $quantity = $_POST['quantity'];

    if ($quantity > 0) {
        // increase quantity
        $new_stock = $product['quantity'] + $quantity;
        $update_stock_query = "UPDATE products SET quantity = $new_stock WHERE id = $product_id";
        mysqli_query($conn, $update_stock_query);

        $product['quantity'] = $new_stock;
        $update_success = true;
    } else {
        echo "<p>Invalid quantity. Please enter a valid number.</p>";
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title><?php echo $title; ?></title>
    <link rel="stylesheet" href="../style.css">
    <script>
        function updateQuantity(change) {
            var quantityInput = document.getElementById('quantity');
            var currentQuantity = parseInt(quantityInput.value);
            var newQuantity = currentQuantity + change;

            if (newQuantity >= 1) {
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
                            <input type="number" id="quantity" name="quantity" value="1" min="1" required>
                            <button type="button" onclick="updateQuantity(1)">+</button>
                        </div>
                        <button type="submit" class="order-btn">Add to Stock</button>
                    </form>

                    <?php if ($update_success): ?>
                        <div id="success-message" class="success-message">
                            Stock updated successfully!
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
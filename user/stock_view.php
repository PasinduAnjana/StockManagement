<?php
session_start();
include '../db.php';

$search_query = '';
if (isset($_POST['search'])) {
    $search_query = mysqli_real_escape_string($conn, $_POST['search']);
}

$query = "SELECT * FROM products WHERE name LIKE '%$search_query%' OR category LIKE '%$search_query%'";
$result = mysqli_query($conn, $query);

$title = "View Stock";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <link rel="stylesheet" href="../style.css">
</head>

<body>
    <div class="admin-container">
        <?php include('../navbar.php'); ?>
        <?php include 'sidebar.php'; ?>

        <div class="admin-content">
            <div class="admin-header">
                <h1 class="page-title"><?php echo $title; ?></h1>

                <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="search-form">
                    <input type="text" name="search" placeholder="Search by name or category" value="<?php echo htmlspecialchars($search_query); ?>">
                    <button type="submit">Search</button>
                </form>
            </div>

            <div class="products-grid">
                <?php
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<div class='product-tile'>";
                        if (!empty($row['image'])) {
                            echo "<img src='" . $row['image'] . "' alt='Product Image' class='product-image-tile'>";
                        } else {
                            echo "<div class='no-image'>No Image</div>";
                        }
                        echo "<div class='product-details'>";
                        echo "<div class='badge-container'>";
                        echo "<h4>" . $row['name'] . "</h4>";
                        echo "<div class='badge'>" . $row['category'] . "</div>";
                        echo "</div>";

                        echo "<h3> Rs." . number_format($row['price'], 2) . "</h3>";

                        echo "<button class='order-btn' onclick=\"window.location.href='stock_order.php?id=" . $row['id'] . "'\">Order</button>";
                        echo "</div>";
                        echo "</div>";
                    }
                } else {
                    echo "<p>No products found</p>";
                }
                ?>
            </div>
        </div>
    </div>
</body>

</html>

<?php
mysqli_close($conn);
?>
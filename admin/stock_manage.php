<?php
session_start();
include '../db.php';

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}


$query = "SELECT * FROM products";
$result = mysqli_query($conn, $query);

$title = "Manage Stock";
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
                <button class="create-btn" onclick="window.location.href='stock_create.php';">Create Product</button>
            </div>



            <table>
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Product Name</th>
                        <th>Description</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>";
                            if (!empty($row['image'])) {
                                echo "<img src='" . $row['image'] . "' alt='Product Image' class='product-image-small'>";
                                echo "<img src='" . $row['image'] . "' alt='Product Image' class='product-image-large'>";
                            } else {
                                echo "No image";
                            }
                            echo "<td>" . $row['name'] . "</td>";
                            echo "<td>" . $row['description'] . "</td>";
                            echo "<td>" . $row['category'] . "</td>";
                            echo "<td>Rs." . number_format($row['price'], 2) . "</td>";
                            echo "<td>" . $row['quantity'] . "</td>";
                            echo "<td>
                                <a class='edit-btn' href='stock_edit.php?id=" . $row['id'] . "'>Edit</a> 
                                
                                <a class='delete-btn' href='stock_delete.php?id=" . $row['id'] . "' onclick='return confirm(\"Are you sure?\");'>Delete</a>
                              </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>No products found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

</body>

</html>

<?php
mysqli_close($conn);
?>
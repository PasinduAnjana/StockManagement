<?php
session_start();
include '../db.php';

if (!isset($_SESSION['id']) || $_SESSION['role'] != 'admin') {
    echo "You must be an admin to view this page.";
    exit;
}

$title = "Manage Users";

$search_query = '';
if (isset($_POST['search'])) {
    $search_query = $_POST['search'];
}


$query = "SELECT * FROM users WHERE username LIKE '%$search_query%' ";
$result = mysqli_query($conn, $query);

// user count
$user_query = "SELECT COUNT(*) as count FROM users";
$user_result = mysqli_query($conn, $user_query);
$user_count = mysqli_fetch_assoc($user_result)['count'];

//users with orders
$user_query = "SELECT COUNT(*) as count FROM users WHERE id IN (SELECT user_id FROM orders)";
$user_result = mysqli_query($conn, $user_query);
$user_order_count = mysqli_fetch_assoc($user_result)['count'];

//user with highest order count
$user_query = "SELECT u.id, u.username, COUNT(o.user_id) as order_count
                FROM users u
                JOIN orders o ON u.id = o.user_id
                GROUP BY u.id
                ORDER BY order_count DESC
                LIMIT 1";
$user_result = mysqli_query($conn, $user_query);
$user_max_orders = mysqli_fetch_assoc($user_result);

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Manage Users</title>
    <link rel="stylesheet" href="../style.css">
</head>

<body>
    <div class="admin-container">
        <?php include('../navbar.php'); ?>
        <?php include 'sidebar.php'; ?>

        <div class="admin-content">
            <h1 class="page-title">User Details</h1>

            <div class="card-container">
                <a href="#" class="card">
                    <img src="../images/person.png" alt="Users Icon" width="40" class="card-icon">
                    <p>Total Users</p>
                    <p style="font-size: 3rem;"><?php echo $user_count; ?></p>
                </a>
                <a href="order_view.php" class="card">
                    <img src="../images/packages.png" alt="Products Icon" width="40" class="card-icon">
                    <p>Users with Orders</p>
                    <p style="font-size: 3rem;"><?php echo $user_order_count  ?></p>
                </a>
                <a href="#" class="card">
                    <img src="../images/clipboard.png" alt="Orders Icon" width="40" class="card-icon">
                    <p>User with the highest order count</p>
                    <p style="font-size: 3rem;">
                        <?php
                        if ($user_max_orders && $user_max_orders['order_count'] > 0) {
                            echo $user_max_orders['username'];
                        } else {
                            echo "No orders yet";
                        }
                        ?>
                    </p>
                </a>
            </div>
            <div style="margin-top: 20px;" class="admin-header">
                <h2 class="page-title">All Users</h2>
                <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="search-form">
                    <input type="text" name="search" placeholder="Search user" value="<?php echo htmlspecialchars($search_query); ?>">
                    <button type="submit">Search</button>
                </form>
            </div>



            <?php if (isset($_GET['message']) && $_GET['message'] == 'success-message') : ?>
                <p class="success">User deleted successfully!</p>
            <?php endif; ?>





            <table>
                <thead>
                    <tr>
                        <th>Profile Image</th>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Contact</th>
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
                                echo "<img src='" . $row['image'] . "' alt='Product Image' class='profile-image'>";
                            } else {
                                echo "<img src='../images/user.png' alt='Profile Picture' class=profile-image>";
                            }
                            echo "<td>" . $row['id'] . "</td>";
                            echo "<td>" . $row['username'] . "</td>";
                            echo "<td>";
                            if (!empty($row['contact'])) {
                                echo $row['contact'];
                            } else {
                                echo "-";
                            }

                            echo "<td>
                                
                                <a class='delete-btn' href='user_delete.php?id=" . $row['id'] . "' onclick='return confirm(\"Are you sure? This will remove all the related orders of this user.\");'>Delete</a>
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
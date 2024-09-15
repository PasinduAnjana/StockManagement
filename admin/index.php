<?php
session_start();

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

$title = "Home";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <title>Admin Dashboard</title>
</head>

<body>
    <div class="admin-container">
        <!-- Navbar inclusion -->
        <?php include('navbar.php'); ?>

        <!-- Sidebar inclusion -->
        <?php include('sidebar.php'); ?>

        <!-- Main content area -->
        <main class="admin-content">
            <header class="admin-header">
                <h1>Dashboard</h1>
            </header>
            <section class="admin-card">
                <h2>Summary</h2>
                <!-- Add your summary content here -->
            </section>
        </main>
    </div>
</body>

</html>
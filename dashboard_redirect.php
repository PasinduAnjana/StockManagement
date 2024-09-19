<?php
session_start();

if (!isset($_SESSION['role'])) {
    header("Location: login.php");
    exit();
} elseif ($_SESSION['role'] === 'admin') {
    header("Location: admin/index.php");
    exit();
} elseif ($_SESSION['role'] === 'user') {
    header("Location: user/index.php");
    exit();
}

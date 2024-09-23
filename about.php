<!DOCTYPE html>
<html lang="en">

<head>
    <title>StockWise</title>
    <link rel="stylesheet" href="style2.css">
</head>

<body>
    <header>
        <nav>
            <div class="logo">
                <img src="images/logo_light.png" alt="">
                <span>StockWise</span>
            </div>
            <ul>
                <li><a href="dashboard_redirect.php">Dashboard</a></li>
                <li><a href="about.php">About us</a></li>

                <li>
                    <?php
                    session_start();
                    if (isset($_SESSION['username'])) : ?>

                        <div class="nav-user">
                            <div class="profile-pic">
                                <?php if (isset($_SESSION['image'])) : ?>
                                    <img src="uploads/<?php echo $_SESSION['image']; ?>" alt="Profile Picture" class="profile-image">
                                <?php else : ?>
                                    <img src="images/user.png" alt="Profile Picture" class="profile-image">
                                <?php endif; ?>

                                <div class="dropdown-menu">
                                    <span class="username"><?php echo strtoupper($_SESSION['username']); ?></span>
                                    <a href="logout.php" class="logout-btn">Logout</a>
                                </div>
                            </div>


                        </div>
                    <?php else : ?>
                        <a href="login.php" class="logout-btn">Login</a>

                    <?php endif; ?>
                </li>

            </ul>
        </nav>
    </header>

    <main>
        <section class="about-us-section">
            <div class="about-container">


                <h1>About Us</h1>
                <div class="about-logo">
                    <img src="images/logo.png" alt="">
                    <span>StockWise</span>
                </div>
                <p>
                    <span style="font-weight: bold;">StockWise </span>is a cutting-edge stock management system designed to simplify inventory management for businesses of all sizes.
                    With an intuitive interface and real-time tracking, StockWise helps you stay on top of your stock levels, orders, and users effortlessly.
                </p>
                <p>
                    Our goal is to provide a reliable, user-friendly solution that boosts efficiency, reduces costs, and optimizes the overall inventory workflow.
                    Whether you're managing a small store or a large warehouse, StockWise adapts to your needs.
                </p>

            </div>
        </section>
    </main>


    <footer class="footer">
        <div class="footer-container">
            <div class="footer-section">
                <h3>Contact Us</h3>
                <p><strong>Address:</strong>35, Reid Avenue, Colombo 7 SRI LANKA</p>
                <p><strong>Phone:</strong> (+94) 123 4567</p>
                <p><strong>Email:</strong> stockwise@gmail.com</p>
            </div>

            <div class="footer-section">
                <h3>Follow Us</h3>
                <ul>
                    <li><a href="#">Facebook</a></li>
                    <li><a href="#">Twitter</a></li>
                    <li><a href="#">Instagram</a></li>
                    <li><a href="#">LinkedIn</a></li>
                </ul>
            </div>

            <div class="footer-section">
                <h3>Information</h3>
                <ul>
                    <li><a href="#">Privacy Policy</a></li>
                    <li><a href="#">Terms of Service</a></li>
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">FAQ</a></li>
                </ul>
            </div>
        </div>

        <div class="footer-bottom">
            <p>&copy; 2024 Your Company Name. All rights reserved.</p>
        </div>
    </footer>


    <script src="script.js"></script>
</body>

</html>
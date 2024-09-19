<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

    <section class="hero">
        <img src="mainimages/main.jpg" alt="Stock Management" class="hero-bg">
        <div class="hero-content">
            <div class="hero-text">
                <h1>Manage Your Inventory with Us!</h1>
                <p style="width:70%">Best software for businesses to manage inventory, place orders, and keep track of your stocks.</p>
                <a href="login.php" class="cta-button">Get Started</a>
            </div>
        </div>
    </section>


    <section class="front-section">
        <div class="front-content">
            <!-- First Pair -->
            <div class="front-item">
                <div class="front-description">
                    <h2>Track Your Inventory</h2>
                    <p>
                        Easily track your inventory with real time data updates, ensuring you know what is in stock and what needs restocking.
                    </p>
                </div>
                <div class="front-image ">
                    <img class='img1' src="mainimages/inventory.jpg" alt="Front 1">
                </div>
            </div>

            <!-- Second Pair -->
            <div class="front-item">
                <div class="front-image ">
                    <img class='img2' src="mainimages/orderlist.jpg" alt="Front 2">
                </div>
                <div class="front-description">
                    <h2>Manage Orders Efficiently</h2>
                    <p>
                        Manage your orders efficiently, with easy to use features that help streamline your workflow.
                    </p>
                </div>

            </div>

            <!-- Third Pair -->
            <div class="front-item">
                <div class="front-description">
                    <h2>Informative Dashboard</h2>
                    <p>
                        With our user-friendly interface and dynamic features, the Dashboard ensures you stay informed and in control of your stock management process.
                    </p>
                </div>
                <div class="front-image">
                    <img class='img1' src="mainimages/dashboard.jpg" alt="Front 3">
                </div>
            </div>
        </div>
    </section>



    <footer class="footer">
        <div class="footer-container">
            <!-- Contact Information -->
            <div class="footer-section">
                <h3>Contact Us</h3>
                <p><strong>Address:</strong>35, Reid Avenue, Colombo 7 SRI LANKA</p>
                <p><strong>Phone:</strong> (+94) 123 4567</p>
                <p><strong>Email:</strong> stockwise@gmail.com</p>
            </div>

            <!-- Social Media Links -->
            <div class="footer-section">
                <h3>Follow Us</h3>
                <ul>
                    <li><a href="#">Facebook</a></li>
                    <li><a href="#">Twitter</a></li>
                    <li><a href="#">Instagram</a></li>
                    <li><a href="#">LinkedIn</a></li>
                </ul>
            </div>

            <!-- Useful Links -->
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

        <!-- Footer Bottom -->
        <div class="footer-bottom">
            <p>&copy; 2024 Your Company Name. All rights reserved.</p>
        </div>
    </footer>


    <script src="script.js"></script>
</body>

</html>
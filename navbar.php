<div class="navbar">
    <!-- <div class="nav-title">
        <div>Stock Management System</div>
    </div> -->
    <div class="logo">
        <img src="../images/logo.png" alt="">
        <span>StockWise</span>
    </div>
    <?php if (isset($_SESSION['username'])) : ?>

        <div class="nav-user">
            <div class="profile-pic">
                <img src="../images/user.png" alt="Profile Picture" class="profile-image">
                <div class="dropdown-menu">
                    <span class="username"><?php echo strtoupper($_SESSION['username']); ?></span>
                    <a href="../logout.php" class="logout-btn">Logout</a>
                </div>
            </div>


        </div>
    <?php else : ?>
        <a href="../login.php" class="logout-btn">Login</a>

    <?php endif; ?>
</div>
<div class="navbar">

    <a href="../index.php">
        <div class="logo">
            <img src="../images/logo.png" alt="">
            <span>StockWise</span>
        </div>
    </a>

    <?php if (isset($_SESSION['username'])) : ?>

        <div class="nav-user">
            <div class="profile-pic">

                <?php if (isset($_SESSION['image'])) : ?>
                    <img src="<?php echo $_SESSION['image']; ?>" alt="Profile Picture" class="profile-image">
                <?php else : ?>
                    <img src="../images/user.png" alt="Profile Picture" class="profile-image">
                <?php endif; ?>

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
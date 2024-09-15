<div class="navbar">
    <!-- <div class="nav-title">
        <div>Stock Management System</div>
    </div> -->

    <div class="nav-user">
        <div class="profile-pic">
            <img src="user.png" Profile Picture" class="profile-image">
            <div class="dropdown-menu">
                <span class="username"><?php echo strtoupper($_SESSION['username']); ?></span>
                <a href="logout.php" class="logout-btn">Logout</a>
            </div>
        </div>
    </div>
</div>
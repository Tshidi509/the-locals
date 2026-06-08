<?php $user = current_user(); ?>
<header class="site-header">
    <a href="index.php" class="brand-mark"><img src="assets/logo.png" alt="Locals logo"></a>
    <nav class="main-nav">
        <a href="index.php">Home</a>
        <a href="brands.php">Brands</a>
        <a href="products.php">New In</a>
        <?php if ($user && $user['role'] === 'seller'): ?>
            <a href="seller-dashboard.php">Seller Dashboard</a>
        <?php endif; ?>
        <?php if ($user && $user['role'] === 'buyer'): ?>
            <a href="buyer-dashboard.php">My Account</a>
        <?php endif; ?>
        <?php if ($user && $user['role'] === 'admin'): ?>
            <a href="admin-dashboard.php">Admin</a>
        <?php endif; ?>
        <a href="cart.php">Cart</a>
        <?php if ($user): ?>
            <a href="logout.php">Logout</a>
        <?php else: ?>
            <a href="login.php">Login</a>
            <a href="register.php">Register</a>
        <?php endif; ?>
    </nav>
</header>

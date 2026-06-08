<?php include 'includes/config.php'; ?>
<!DOCTYPE html><html><head><title>The Locals</title><link rel="stylesheet" href="css/styles.css"></head><body>
<?php include 'includes/header.php'; ?>
<div class="quick-actions">
  <a href="brands.php">Shop Local Brands</a>
  <a href="products.php">Discover Drops</a>
  <a href="register.php">Join The Locals</a>
</div>
<section class="hero"><div class="hero-panel">
  <div class="kicker">Support local. Create together.</div>
  <h1>Local brands. Big dreams.</h1>
  <p>The Locals is a marketplace for real local creators, sellers and buyers. Sellers build their brands, buyers discover products, upload proof of payment and collect through local pickup or PEP-style collection.</p>
  <a class="btn" href="brands.php">Shop The Culture</a> <a class="btn secondary" href="register.php">Become a Seller</a>
</div></section>
<section class="section"><div class="section-title"><h2>Featured Brands</h2><a href="brands.php">View all</a></div><div class="grid">
<?php
$stmt=$pdo->query("SELECT * FROM brands ORDER BY created_at DESC LIMIT 6");
foreach($stmt as $b): ?>
<a class="brand-card" href="brand.php?id=<?= $b['id'] ?>"><h3><?= clean($b['brand_name']) ?></h3><p><?= clean(substr($b['description'],0,90)) ?></p></a>
<?php endforeach; ?>
</div></section>
<section class="section"><div class="section-title"><h2>New Drops</h2><a href="products.php">Shop all</a></div><div class="grid">
<?php
$stmt=$pdo->query("SELECT p.*, (SELECT image_path FROM product_images WHERE product_id=p.id LIMIT 1) img FROM products p ORDER BY p.created_at DESC LIMIT 8");
foreach($stmt as $p): ?>
<div class="card"><img src="<?= clean($p['img'] ?: 'assets/background.png') ?>"><h3><?= clean($p['product_name']) ?></h3><p class="muted"><?= clean($p['category']) ?></p><p class="price">R<?= number_format($p['price'],2) ?></p><a class="btn" href="product.php?id=<?= $p['id'] ?>">View Product</a></div>
<?php endforeach; ?>
</div></section>
<footer class="footer">The Locals. Real people. Real brands. Real impact.</footer>
</body></html>

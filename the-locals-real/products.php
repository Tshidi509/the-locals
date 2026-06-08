<?php include 'includes/config.php'; $cat=clean($_GET['category']??''); ?>
<!DOCTYPE html><html><head><title>Products</title><link rel="stylesheet" href="css/styles.css"></head><body><?php include 'includes/header.php'; ?>
<section class="section"><h1>New In</h1><form method="get" style="margin-bottom:20px"><input name="category" placeholder="Search category like hoodie, sneaker, tracksuit" value="<?= $cat ?>"></form><div class="grid">
<?php if($cat){$stmt=$pdo->prepare("SELECT p.*, (SELECT image_path FROM product_images WHERE product_id=p.id LIMIT 1) img FROM products p WHERE category LIKE ? OR product_name LIKE ? ORDER BY created_at DESC");$stmt->execute(["%$cat%","%$cat%"]);} else {$stmt=$pdo->query("SELECT p.*, (SELECT image_path FROM product_images WHERE product_id=p.id LIMIT 1) img FROM products p ORDER BY created_at DESC");} foreach($stmt as $prod): ?>
<div class="card"><img src="<?= clean($prod['img'] ?: 'assets/background.png') ?>"><h3><?= clean($prod['product_name']) ?></h3><p class="muted"><?= clean($prod['category']) ?></p><p class="price">R<?= number_format($prod['price'],2) ?></p><a class="btn" href="product.php?id=<?= $prod['id'] ?>">View Product</a></div>
<?php endforeach; ?>
</div></section></body></html>

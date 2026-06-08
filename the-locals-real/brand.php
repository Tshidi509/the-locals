<?php include 'includes/config.php'; $id=(int)($_GET['id']??0);$stmt=$pdo->prepare('SELECT * FROM brands WHERE id=?');$stmt->execute([$id]);$brand=$stmt->fetch(PDO::FETCH_ASSOC); if(!$brand) die('Brand not found'); ?>
<!DOCTYPE html><html><head><title><?= clean($brand['brand_name']) ?></title><link rel="stylesheet" href="css/styles.css"></head><body><?php include 'includes/header.php'; ?>
<section class="section"><h1><?= clean($brand['brand_name']) ?></h1><p class="muted"><?= clean($brand['description']) ?></p><br><div class="grid">
<?php $p=$pdo->prepare("SELECT p.*, (SELECT image_path FROM product_images WHERE product_id=p.id LIMIT 1) img FROM products p WHERE brand_id=? ORDER BY created_at DESC");$p->execute([$id]);foreach($p as $prod): ?>
<div class="card"><img src="<?= clean($prod['img'] ?: 'assets/background.png') ?>"><h3><?= clean($prod['product_name']) ?></h3><p class="muted"><?= clean($prod['category']) ?></p><p class="price">R<?= number_format($prod['price'],2) ?></p><a class="btn" href="product.php?id=<?= $prod['id'] ?>">View Product</a></div>
<?php endforeach; ?>
</div></section></body></html>

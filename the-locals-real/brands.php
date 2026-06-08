<?php include 'includes/config.php'; ?>
<!DOCTYPE html><html><head><title>Brands</title><link rel="stylesheet" href="css/styles.css"></head><body><?php include 'includes/header.php'; ?>
<section class="section"><h1>Discover Local Brands</h1><div class="grid">
<?php $stmt=$pdo->query('SELECT * FROM brands ORDER BY created_at DESC'); foreach($stmt as $b): ?>
<a class="brand-card" href="brand.php?id=<?= $b['id'] ?>"><h3><?= clean($b['brand_name']) ?></h3><p><?= clean($b['description']) ?></p></a>
<?php endforeach; ?>
</div></section></body></html>

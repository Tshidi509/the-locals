<?php include 'includes/config.php'; $id=(int)($_GET['id']??0);$stmt=$pdo->prepare('SELECT p.*, b.brand_name FROM products p JOIN brands b ON p.brand_id=b.id WHERE p.id=?');$stmt->execute([$id]);$p=$stmt->fetch(PDO::FETCH_ASSOC); if(!$p) die('Product not found');
if($_SERVER['REQUEST_METHOD']==='POST'){ require_role('buyer'); $_SESSION['cart'][$id]=($_SESSION['cart'][$id]??0)+1; header('Location: cart.php'); exit; }
?><!DOCTYPE html><html><head><title><?= clean($p['product_name']) ?></title><link rel="stylesheet" href="css/styles.css"></head><body><?php include 'includes/header.php'; ?>
<section class="section"><div class="grid"><div class="card">
<?php $imgs=$pdo->prepare('SELECT * FROM product_images WHERE product_id=?');$imgs->execute([$id]); foreach($imgs as $img): ?><img src="<?= clean($img['image_path']) ?>"><?php endforeach; ?>
</div><div class="card"><h1><?= clean($p['product_name']) ?></h1><p class="muted">Brand: <?= clean($p['brand_name']) ?> | <?= clean($p['category']) ?></p><p class="price">R<?= number_format($p['price'],2) ?></p><p><?= clean($p['description']) ?></p><br><form method="post"><button>Add to Cart</button></form></div></div></section></body></html>

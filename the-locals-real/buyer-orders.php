<?php include 'includes/config.php'; require_role('buyer'); $u=current_user(); ?>
<!DOCTYPE html><html><head><title>My Orders</title><link rel="stylesheet" href="css/styles.css"></head><body><?php include 'includes/header.php'; ?><section class="section"><h1>My Orders</h1><table class="table"><tr><th>Order</th><th>Total</th><th>Delivery</th><th>Status</th><th>Date</th></tr>
<?php $stmt=$pdo->prepare('SELECT * FROM orders WHERE buyer_id=? ORDER BY created_at DESC');$stmt->execute([$u['id']]);foreach($stmt as $o): ?><tr><td>#<?= $o['id'] ?></td><td>R<?= number_format($o['total'],2) ?></td><td><?= clean($o['delivery_method']) ?></td><td><?= clean($o['status']) ?></td><td><?= $o['created_at'] ?></td></tr><?php endforeach; ?>
</table></section></body></html>

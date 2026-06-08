<?php include 'includes/config.php'; require_role('seller'); $u=current_user();
$stmt=$pdo->prepare('SELECT * FROM brands WHERE seller_id=?');$stmt->execute([$u['id']]);$brand=$stmt->fetch(PDO::FETCH_ASSOC);
if($_SERVER['REQUEST_METHOD']==='POST'){
 $name=clean($_POST['brand_name']);$desc=clean($_POST['description']);$address=clean($_POST['address']);$pep=clean($_POST['pep_collection_point']);
 $logo=upload_file($_FILES['logo']??null,'uploads/brand_logos') ?: ($brand['logo_path']??null);
 if($brand){$pdo->prepare('UPDATE brands SET brand_name=?,description=?,address=?,pep_collection_point=?,logo_path=? WHERE seller_id=?')->execute([$name,$desc,$address,$pep,$logo,$u['id']]);}
 else {$pdo->prepare('INSERT INTO brands(seller_id,brand_name,description,address,pep_collection_point,logo_path) VALUES(?,?,?,?,?,?)')->execute([$u['id'],$name,$desc,$address,$pep,$logo]);}
 header('Location: seller-dashboard.php');exit;
}
?><!DOCTYPE html><html><head><title>Create Brand</title><link rel="stylesheet" href="css/styles.css"></head><body><?php include 'includes/header.php'; ?><form class="form-shell" method="post" enctype="multipart/form-data"><h1>Create Brand</h1><div class="field"><label>Brand Name</label><input name="brand_name" value="<?= clean($brand['brand_name']??'') ?>" required></div><div class="field"><label>Business Description</label><textarea name="description" required><?= clean($brand['description']??'') ?></textarea></div><div class="field"><label>Brand Address</label><textarea name="address"><?= clean($brand['address']??'') ?></textarea></div><div class="field"><label>Preferred PEP / Collection Point</label><input name="pep_collection_point" value="<?= clean($brand['pep_collection_point']??'') ?>"></div><div class="field"><label>Brand Logo</label><input type="file" name="logo"></div><button>Save Brand</button></form></body></html>

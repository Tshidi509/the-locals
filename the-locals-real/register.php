<?php include 'includes/config.php';
if($_SERVER['REQUEST_METHOD']==='POST'){
  $name=clean($_POST['full_name']); $email=strtolower(clean($_POST['email'])); $role=clean($_POST['role']); $pass=$_POST['password'];
  if(!in_array($role,['buyer','seller'])) die('Invalid role');
  $hash=password_hash($pass,PASSWORD_DEFAULT);
  try{$stmt=$pdo->prepare('INSERT INTO users(full_name,email,password_hash,role) VALUES(?,?,?,?)');$stmt->execute([$name,$email,$hash,$role]);
    $pdo->prepare('INSERT IGNORE INTO newsletters(email) VALUES(?)')->execute([$email]);
    header('Location: login.php?registered=1');exit;
  }catch(PDOException $e){$error='Email already exists or registration failed.';}
}
?><!DOCTYPE html><html><head><title>Register</title><link rel="stylesheet" href="css/styles.css"><script src="js/app.js"></script></head><body><?php include 'includes/header.php'; ?>
<form class="form-shell" method="post"><h1>Create Account</h1><?php if(isset($error)) echo "<p class='muted'>$error</p>"; ?>
<div class="field"><label>Full Name</label><input name="full_name" required></div>
<div class="field"><label>Email</label><input type="email" name="email" required></div>
<div class="field"><label>Password</label><div class="password-row"><input id="password" type="password" name="password" required><button type="button" onclick="togglePassword('password')">Show</button></div></div>
<div class="field"><label>Register As</label><select name="role" required><option value="buyer">Buyer</option><option value="seller">Seller</option></select></div>
<button>Create Account</button><p class="muted"><br>Already registered? <a href="login.php">Login</a></p></form></body></html>

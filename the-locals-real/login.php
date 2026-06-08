<?php include 'includes/config.php';
if($_SERVER['REQUEST_METHOD']==='POST'){
  $email=strtolower(clean($_POST['email']));$pass=$_POST['password'];
  $stmt=$pdo->prepare('SELECT * FROM users WHERE email=?');$stmt->execute([$email]);$u=$stmt->fetch(PDO::FETCH_ASSOC);
  if($u && password_verify($pass,$u['password_hash'])){$_SESSION['user']=['id'=>$u['id'],'name'=>$u['full_name'],'email'=>$u['email'],'role'=>$u['role']];
    if($u['role']==='seller') header('Location: seller-dashboard.php'); elseif($u['role']==='admin') header('Location: admin-dashboard.php'); else header('Location: buyer-dashboard.php'); exit;
  } else $error='Wrong email or password.';
}
?><!DOCTYPE html><html><head><title>Login</title><link rel="stylesheet" href="css/styles.css"><script src="js/app.js"></script></head><body><?php include 'includes/header.php'; ?>
<form class="form-shell" method="post"><h1>Login</h1><?php if(isset($_GET['registered'])) echo '<p class="muted">Registered successfully. Login now.</p>'; ?><?php if(isset($error)) echo "<p class='muted'>$error</p>"; ?>
<div class="field"><label>Email</label><input type="email" name="email" required></div>
<div class="field"><label>Password</label><div class="password-row"><input id="loginpass" type="password" name="password" required><button type="button" onclick="togglePassword('loginpass')">Show</button></div></div>
<button>Login</button><p class="muted"><br>No account? <a href="register.php">Register</a></p></form></body></html>

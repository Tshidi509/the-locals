<?php
session_start();

$host = "localhost";
$dbname = "the_locals";
$username = "root";
$password = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

const SELLER_YEARLY_FEE = 200;
const MAX_IMAGES_PER_PRODUCT = 5;
const MAX_TOTAL_IMAGES_PER_SELLER = 3000;

function clean($value) {
    return htmlspecialchars(trim($value ?? ''), ENT_QUOTES, 'UTF-8');
}

function current_user() {
    return $_SESSION['user'] ?? null;
}

function is_logged_in() {
    return isset($_SESSION['user']);
}

function require_login() {
    if (!is_logged_in()) {
        header("Location: login.php");
        exit;
    }
}

function require_role($role) {
    require_login();
    if ($_SESSION['user']['role'] !== $role) {
        header("Location: index.php");
        exit;
    }
}

function upload_file($file, $folder) {
    if (!isset($file) || $file['error'] !== UPLOAD_ERR_OK) {
        return null;
    }
    $allowed = ['image/jpeg','image/png','image/webp','image/jpg'];
    if (!in_array(mime_content_type($file['tmp_name']), $allowed)) {
        die("Only JPG, PNG and WEBP images are allowed.");
    }
    if ($file['size'] > 5 * 1024 * 1024) {
        die("Image too large. Maximum size is 5MB.");
    }
    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    $name = uniqid("locals_", true) . "." . strtolower($ext);
    $path = $folder . "/" . $name;
    move_uploaded_file($file['tmp_name'], $path);
    return $path;
}
?>

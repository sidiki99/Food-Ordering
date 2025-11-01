
<?php
session_start();
require_once 'includes/db_connect.php';

// Check if already logged in
if (isset($_SESSION['admin_logged_in'])) {
    header('Location: orders_dashboard.php');
    exit;
}

// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = 'admin'; // Change these to your actual admin credentials
    $password = 'admin321'; // In production, use hashed passwords
    
    if ($_POST['username'] === $username && $_POST['password'] === $password) {
        $_SESSION['admin_logged_in'] = true;
        header('Location: orders_dashboard.php');
        exit;
    } else {
        $error = "Invalid credentials";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="container" style="max-width: 500px; margin-top: 100px;">
        <h1>Admin Login</h1>
        <?php if (isset($error)): ?>
            <div style="color: red; margin-bottom: 15px;"><?= $error ?></div>
        <?php endif; ?>
        <form method="POST">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="submit-btn">Login</button>
        </form>
    </div>
</body>
</html>
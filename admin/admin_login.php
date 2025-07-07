<?php
session_start();
include '../includes/db_connect.php'; // Include database connection
include '../includes/admin_functions.php'; // Include admin functions

$login_error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = strtolower(trim($_POST['email']));

    $password = $_POST['password'];

    // Check if admin exists in the database
    $query = "SELECT * FROM admins WHERE email = '$email'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $admin = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $admin['password'])) {
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_username'] = $admin['username'];
            header('Location: dashboard.php');
            exit();
        } else {
            $login_error = 'Invalid password.';
        }
    } else {
        $login_error = 'Admin not found.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Canberra Bus</title>
    <link rel="stylesheet" href="../assets/css/admin_login.css">
</head>
<body>

    <div class="admin-login-card">
        <section class="admin-login-card-header">
            <img src="../assets/images/logo.png" alt="GOBus Logo" class="admin-login-logo">
            <h2 class="admin-login-title">Admin Login</h2>
            <p class="admin-login-subtitle">Sign in to manage GOBusBus</p>
        </section>
        <?php if (!empty($login_error)): ?>
            <div class="error-message"><?php echo $login_error; ?></div>
        <?php endif; ?>
        <form action="admin_login.php" method="POST" class="admin-login-form" autocomplete="off">
            <div class="form-group admin-login-input-group">
                <span class="admin-login-icon"><?php include '../assets/svg/contact.svg'; ?></span>
                <input type="email" id="email" name="email" placeholder="Email" required>
            </div>
            <div class="form-group admin-login-input-group">
                <span class="admin-login-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="10" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                </span>
                <input type="password" id="password" name="password" placeholder="Password" required>
            </div>
            <button type="submit" class="btn btn-primary admin-login-btn">Login</button>
        </form>
        <div class="back-home">
            <a href="../index.php">Back to Homepage</a>
        </div>
    </div>
</body>
</html>

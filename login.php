<?php
session_start();

$login_error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Identifiants valides
    $valid_username = 'admin';
    $valid_password = 'password123';

    if ($username === $valid_username && $password === $valid_password) {
        $_SESSION['user_id'] = 1;
        $_SESSION['username'] = $valid_username;
        header('Location: index.php');
        exit();
    } else {
       header('Location: index.php');    ;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - GOBus</title>
    <link rel="stylesheet" href="assets/css/signup.css">
    <script src="assets/js/login.js" defer></script>
</head>
<body>
    <?php include 'includes/header.php'; ?>
    <main>
        <div class="signup-card">
            <section class="signup-card-header" >
                <img src="assets/images/10.png" alt="GOBus Logo" class="signup-logo">
                <h2 class="signup-title">Welcome Back!</h2>
                <p class="signup-subtitle">Sign in to your GOBus account</p>
            </section>
            
            <?php if ($login_error): ?>
                <div class="error-message" style="color: #dc3545; background: #ffe0e0; padding: 10px; border-radius: 8px; margin-bottom: 20px; text-align: center; width: 100%;">
                    <?php echo $login_error; ?>
                </div>
            <?php endif; ?>

            <form action="login.php" method="POST" class="signup-form" autocomplete="off">
                <div class="signup-input-group">
                    <span class="signup-icon"><?php include 'assets/svg/user.svg'; ?></span>
                    <input type="text" id="username" name="username" placeholder="Username" required>
                </div>
                <div class="signup-input-group">
                    <span class="signup-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="10" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                    </span>
                    <input type="password" id="password" name="password" placeholder="Password" required>
                </div>
                <button type="submit" class="signup-btn">Login</button>
            </form>
            <p style="margin-top: 20px; color: #555; text-align: center;">
                Don't have an account? <a href="signup.php" style="color: #0055aa; text-decoration: none; font-weight: 600;">Sign up here</a>
            </p>
        </div>
    </main>
    <?php include 'includes/footer.php'; ?>
</body>
</html>

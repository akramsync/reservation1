<?php
session_start();

$registration_successful = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Génération d’un code de recharge simulé
    $recharge_code = strtoupper(bin2hex(random_bytes(4)));
    $balance = 0.00;

    // Simule une inscription réussie
    $registration_successful = true;

    // Connexion automatique de l'utilisateur
    $_SESSION['user_id'] = 1;
    $_SESSION['username'] = $username;

    // Redirection vers home.php
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - GOBusBus</title>
    <link rel="stylesheet" href="assets/css/signup.css">
    <script src="assets/js/signup.js" defer></script>
</head>
<body>
    <?php include 'includes/header.php'; ?>
    <main>
        <div class="signup-card">
            <section class="signup-card-header">
                <img src="assets/images/10.png" alt="GOBus Logo" class="signup-logo">
                <h2 class="signup-title">Create Your Account</h2>
                <p class="signup-subtitle">Join  GOBusBus for a seamless travel experience</p>
            </section>
            <?php if ($registration_successful): ?>
                <div id="success-popup" class="popup">
                    <div class="popup-content">
                        <h3>Registration Successful!</h3>
                        <p>Your account has been created successfully.</p>
                        <button onclick="window.location.href='index.php';">Go to Dashboard</button>
                        <button onclick="window.location.href='logout.php';">Logout and Login</button>
                    </div>
                </div>
            <?php else: ?>
                <form action="signup.php" method="POST" class="signup-form" autocomplete="off">
                    <div class="form-group signup-input-group">
                        <span class="signup-icon"><?php include 'assets/svg/user.svg'; ?></span>
                        <input type="text" id="username" name="username" placeholder="Username" required>
                    </div>
                    <div class="form-group signup-input-group">
                        <span class="signup-icon"><?php include 'assets/svg/contact.svg'; ?></span>
                        <input type="email" id="email" name="email" placeholder="Email" required>
                    </div>
                    <div class="form-group signup-input-group">
                        <span class="signup-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="10" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                        </span>
                        <input type="password" id="password" name="password" placeholder="Password" required>
                    </div>
                    <div class="form-group signup-input-group">
                        <span class="signup-icon"><?php include 'assets/svg/user.svg'; ?></span>
                        <input type="text"  name="First Name" placeholder="First Name" required>
                    </div>
                    <div class="form-group signup-input-group">
                        <span class="signup-icon"><?php include 'assets/svg/user.svg'; ?></span>
                        <input type="text"  name="Last Name" placeholder="Last Name" required>
                    </div>
                    <div class="form-group signup-input-group">
                        <span class="signup-icon"><?php include 'assets/svg/user.svg'; ?></span>
                        <input type="text"  name="Country of Residence" placeholder="Country of Residence" required>
                    </div>
                    <div class="form-group signup-input-group">
                        <span class="signup-icon"><?php include 'assets/svg/user.svg'; ?></span>
                        <input type="text"  name="Post Code" placeholder="Post Code" required>
                    
                    </div>
                    <button type="submit" class="btn btn-primary signup-btn">Sign Up</button>
                </form>
            <?php endif; ?>
        </div>
    </main>
    <?php include 'includes/footer.php'; ?>
</body>
</html>

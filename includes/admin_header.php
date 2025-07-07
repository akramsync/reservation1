<?php
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Canberra Bus Booking</title>
    
    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="../assets/images/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../assets/images/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/images/favicon/favicon-16x16.png">
    <link rel="manifest" href="../assets/images/favicon/site.webmanifest">
    <link rel="mask-icon" href="../assets/images/favicon/safari-pinned-tab.svg" color="#004080">
    <meta name="msapplication-TileColor" content="#004080">
    <meta name="theme-color" content="#004080">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Reset and Base Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f7fa;
            padding-top: 66px; /* Height of the header */
        }

        /* Admin Header Styling */
        .admin-header {
            background: linear-gradient(to right, #004080, #0066cc);
            color: white;
            padding: 12px 24px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            height: 66px;
        }

        .admin-header .logo {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .admin-header .logo h1 {
            margin: 0;
            font-size: 22px;
            font-weight: 600;
            color: #fff;
            letter-spacing: 0.5px;
        }

        .admin-header .logo-img {
            max-height: 42px;
            border-radius: 4px;
        }

        /* Navigation Styling */
        nav {
            display: flex;
            align-items: center;
        }

        nav ul.nav-list {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            transition: all 0.3s ease;
        }

        nav ul li {
            margin-left: 10px;
        }

        nav ul li a {
            color: white;
            text-decoration: none;
            font-size: 14px;
            padding: 10px 15px;
            border-radius: 4px;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        nav ul li a i {
            font-size: 16px;
        }

        nav ul li a:hover {
            background-color: rgba(255, 255, 255, 0.15);
            transform: translateY(-2px);
        }

        nav ul li a.active {
            background-color: rgba(255, 255, 255, 0.2);
            font-weight: 500;
        }

        /* Logout button special styling */
        nav ul li a.logout {
            background-color: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        nav ul li a.logout:hover {
            background-color: rgba(255, 0, 0, 0.2);
            border-color: rgba(255, 0, 0, 0.3);
        }

        /* Hamburger Menu Styling */
        .nav-toggle {
            display: none;
            cursor: pointer;
            background: transparent;
            border: none;
            width: 40px;
            height: 40px;
            padding: 5px;
            border-radius: 4px;
            transition: background-color 0.3s ease;
            z-index: 100;
        }

        .nav-toggle:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

        .hamburger {
            width: 25px;
            height: 2px;
            background-color: white;
            margin: 5px 0;
            border-radius: 1px;
            transition: 0.3s;
            display: block;
        }

        /* Main Content Wrapper */
        .main-content {
            padding: 20px;
            margin-top: 20px;
        }

        /* Responsive Design */
        @media (max-width: 992px) {
            nav ul li a {
                padding: 8px 12px;
                font-size: 13px;
            }
        }

        @media (max-width: 768px) {
            body {
                padding-top: 60px; /* Adjusted for smaller header height on mobile */
            }

            .admin-header {
                height: 60px;
                padding: 10px 15px;
            }

            .nav-toggle {
                display: block;
            }

            nav ul.nav-list {
                display: none;
                flex-direction: column;
                position: fixed;
                top: 60px; /* Align with header height */
                right: 0;
                background-color: #004080;
                width: 250px;
                padding: 10px 0;
                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
                z-index: 99;
                border-radius: 0 0 0 8px;
                max-height: calc(100vh - 60px);
                overflow-y: auto;
            }

            nav ul.nav-list.open {
                display: flex;
            }

            nav ul li {
                width: 100%;
                margin: 0;
            }

            nav ul li a {
                padding: 12px 20px;
                display: flex;
                justify-content: flex-start;
                width: 100%;
                border-radius: 0;
            }

            /* Animation for hamburger to X */
            .nav-toggle.active .hamburger:nth-child(1) {
                transform: translateY(7px) rotate(45deg);
            }

            .nav-toggle.active .hamburger:nth-child(2) {
                opacity: 0;
            }

            .nav-toggle.active .hamburger:nth-child(3) {
                transform: translateY(-7px) rotate(-45deg);
            }
        }

        /* Mobile Optimizations */
        @media (max-width: 480px) {
            .admin-header .logo h1 {
                font-size: 18px;
            }

            .admin-header .logo-img {
                max-height: 32px;
            }
        }
    </style>
</head>
<body>

<header class="admin-header">
    <div class="logo">
        <img src="../assets/images/logo.png" alt="GOBus Logo" class="logo-img">
        <h1>Admin Panel</h1>
    </div>
    <nav>
        <button class="nav-toggle" aria-label="Toggle navigation" aria-expanded="false">
            <span class="hamburger"></span>
            <span class="hamburger"></span>
            <span class="hamburger"></span>
        </button>
        <ul class="nav-list">
            <li><a href="dashboard.php" <?php echo (basename($_SERVER['PHP_SELF']) == 'dashboard.php') ? 'class="active"' : ''; ?>><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
            <li><a href="manage_buses.php" <?php echo (basename($_SERVER['PHP_SELF']) == 'manage_buses.php') ? 'class="active"' : ''; ?>><i class="fas fa-bus"></i> Buses</a></li>
            <li><a href="manage_routes.php" <?php echo (basename($_SERVER['PHP_SELF']) == 'manage_routes.php') ? 'class="active"' : ''; ?>><i class="fas fa-route"></i> Routes</a></li>
            <li><a href="manage_users.php" <?php echo (basename($_SERVER['PHP_SELF']) == 'manage_users.php') ? 'class="active"' : ''; ?>><i class="fas fa-users"></i> Users</a></li>
            <li><a href="manage_bookings.php" <?php echo (basename($_SERVER['PHP_SELF']) == 'manage_bookings.php') ? 'class="active"' : ''; ?>><i class="fas fa-ticket-alt"></i> Bookings</a></li>
            <li><a href="manage_balance.php" <?php echo (basename($_SERVER['PHP_SELF']) == 'manage_balance.php') ? 'class="active"' : ''; ?>><i class="fas fa-wallet"></i> Balance</a></li>
            <li><a href="transaction_history.php" <?php echo (basename($_SERVER['PHP_SELF']) == 'transaction_history.php') ? 'class="active"' : ''; ?>><i class="fas fa-exchange-alt"></i> Transactions</a></li>
            <li><a href="view_reports.php" <?php echo (basename($_SERVER['PHP_SELF']) == 'view_reports.php') ? 'class="active"' : ''; ?>><i class="fas fa-chart-bar"></i> Reports</a></li>
            <li><a href="admin_logout.php" class="logout"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        </ul>
    </nav>
</header>

<script>
    // Improved hamburger menu functionality
    document.addEventListener('DOMContentLoaded', function() {
        const navToggle = document.querySelector('.nav-toggle');
        const navList = document.querySelector('.nav-list');
        
        navToggle.addEventListener('click', function() {
            navList.classList.toggle('open');
            navToggle.classList.toggle('active');
            
            // Update aria-expanded attribute for accessibility
            const expanded = navToggle.getAttribute('aria-expanded') === 'true' || false;
            navToggle.setAttribute('aria-expanded', !expanded);
        });
        
        // Close menu when clicking outside
        document.addEventListener('click', function(event) {
            const isNavToggle = event.target.closest('.nav-toggle');
            const isNavList = event.target.closest('.nav-list');
            
            if (!isNavToggle && !isNavList && navList.classList.contains('open')) {
                navList.classList.remove('open');
                navToggle.classList.remove('active');
                navToggle.setAttribute('aria-expanded', 'false');
            }
        });
        
        // Close menu when window is resized to desktop size
        window.addEventListener('resize', function() {
            if (window.innerWidth > 768 && navList.classList.contains('open')) {
                navList.classList.remove('open');
                navToggle.classList.remove('active');
                navToggle.setAttribute('aria-expanded', 'false');
            }
        });
    });
</script>

</body>
</html>

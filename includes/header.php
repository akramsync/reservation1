<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Start the session only if it's not already started
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LAYELI DUBAI</title>
    
  
    <!-- Common CSS for header and shared elements -->
    <link rel="stylesheet" href="assets/css/common.css"> 
</head>
<body>
    <header class="main-header">
        <div class="container header-container">
            <div class="logo-container">
                <a href="index.php">
                    <img src="assets/images/10.png" alt="GOBus Logo" class="logo">
                </a>
            </div>
            <!-- Navigation Bar -->
            <nav>
                <div class="nav-toggle" aria-label="toggle navigation">
                    <span class="hamburger"></span>
                    <span class="hamburger"></span>
                    <span class="hamburger"></span>
                </div>
                <ul class="nav-list">
                    <li>
                        <a href="index.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>">
                            <svg width="20" height="20" viewBox="0 0 24 24">
                                <path d="M3 9.5L12 4L21 9.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path d="M19 13V19.4C19 19.7314 18.7314 20 18.4 20H5.6C5.26863 20 5 19.7314 5 19.4V13" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                            Home
                        </a>
                    </li>
                    <li>
                        <a href="about_us.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'about_us.php' ? 'active' : ''; ?>">
                            <svg width="20" height="20" viewBox="0 0 24 24">
                                <path d="M12 12C14.2091 12 16 10.2091 16 8C16 5.79086 14.2091 4 12 4C9.79086 4 8 5.79086 8 8C8 10.2091 9.79086 12 12 12Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path d="M6 20V19C6 16.7909 7.79086 15 10 15H14C16.2091 15 18 16.7909 18 19V20" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                            About Us
                        </a>
                    </li>
                    <li>
                        <a href="our_buses.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'our_buses.php' ? 'active' : ''; ?>">
                            <svg width="20" height="20" viewBox="0 0 24 24">
                                <path d="M7 16.01L7.01 15.9989" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path d="M17 16.01L17.01 15.9989" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path d="M3 12H21V18.4C21 18.7314 20.7314 19 20.4 19H3.6C3.26863 19 3 18.7314 3 18.4V12Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path d="M21 8V12H3V8" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path d="M7 8V5.6C7 5.26863 7.26863 5 7.6 5H16.4C16.7314 5 17 5.26863 17 5.6V8" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                            Ticket 
                        </a>
                    </li>
                    
                    <li>
                        <a href="contact_us.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'contact_us.php' ? 'active' : ''; ?>">
                            <svg width="20" height="20" viewBox="0 0 24 24">
                                <path d="M18.1181 14.702L14 15.5C11.2183 14.1038 9.5 12.5 8.5 10L9.26995 5.8699L7.81452 2L4.0636 2.80644C3.34564 2.97521 2.87261 3.65308 3.0314 4.37104C3.94284 8.65733 6.35063 12.1512 9.5 14.5C12.2329 16.5417 16.4705 18.6302 20.802 17.6837C21.5209 17.5249 21.9939 16.8471 21.8252 16.1291L21.0187 12.3855L18.1181 14.702Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                            Contact Us
                        </a>
                    </li>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li class="dropdown">
                            <a href="javascript:void(0);" class="dropdown-toggle">
                                <svg width="20" height="20" viewBox="0 0 24 24">
                                    <path d="M5 20V19C5 15.134 8.13401 12 12 12V12C15.866 12 19 15.134 19 19V20" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M12 12C14.2091 12 16 10.2091 16 8C16 5.79086 14.2091 4 12 4C9.79086 4 8 5.79086 8 8C8 10.2091 9.79086 12 12 12Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                                My Account
                            </a>
                            <div class="dropdown-menu">
                                <a href="booking_history.php" class="dropdown-item">
                                    <svg width="18" height="18" viewBox="0 0 24 24">
                                        <path d="M7 10L10 13L15 7" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                        <path d="M10 3H5.8C4.11984 3 3.27976 3 2.63803 3.32698C2.07354 3.6146 1.6146 4.07354 1.32698 4.63803C1 5.27976 1 6.11984 1 7.8V18.2C1 19.8802 1 20.7202 1.32698 21.362C1.6146 21.9265 2.07354 22.3854 2.63803 22.673C3.27976 23 4.11984 23 5.8 23H18.2C19.8802 23 20.7202 23 21.362 22.673C21.9265 22.3854 22.3854 21.9265 22.673 21.362C23 20.7202 23 19.8802 23 18.2V16" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>
                                    My Bookings
                                </a>
                                
                                <div class="dropdown-divider"></div>
                                <a href="logout.php" class="dropdown-item">
                                    <svg width="18" height="18" viewBox="0 0 24 24">
                                        <path d="M12 12H19M19 12L16 15M19 12L16 9" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                        <path d="M19 6V5C19 3.89543 18.1046 3 17 3H7C5.89543 3 5 3.89543 5 5V19C5 20.1046 5.89543 21 7 21H17C18.1046 21 19 20.1046 19 19V18" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>
                                    Logout
                                </a>
                            </div>
                        </li>
                    <?php else: ?>
                        <li>
                            <a href="login.php" class="btn btn-primary">
                                Login
                            </a>
                        </li>
                        <li>
                            <a href="signup.php" class="btn btn-outline">
                                Sign Up
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Main content container -->
    <div class="container">

    <!-- Add JavaScript for dropdown and mobile nav functionality -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Mobile Navigation Toggle
            const navToggle = document.querySelector('.nav-toggle');
            const navList = document.querySelector('.nav-list');
            const hamburgers = document.querySelectorAll('.hamburger');
            
            navToggle.addEventListener('click', function() {
                navList.classList.toggle('open');
                hamburgers.forEach(hamburger => {
                    hamburger.classList.toggle('open');
                });
            });

            // Dropdown Toggle
            const dropdownToggles = document.querySelectorAll('.dropdown-toggle');
            
            dropdownToggles.forEach(toggle => {
                toggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    const dropdownMenu = this.nextElementSibling;
                    dropdownMenu.classList.toggle('show');
                    
                    // Close other open dropdowns
                    document.querySelectorAll('.dropdown-menu.show').forEach(menu => {
                        if (menu !== dropdownMenu) {
                            menu.classList.remove('show');
                        }
                    });
                });
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', function(e) {
                if (!e.target.closest('.dropdown')) {
                    document.querySelectorAll('.dropdown-menu').forEach(menu => {
                        menu.classList.remove('show');
                    });
                }
            });
        });
    </script>
</body>
</html> 
<?php
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}
?>

<!-- Mobile Header - Only visible on smaller screens -->
<div class="mobile-header">
    <div class="mobile-logo">
        <img src="..assets/images/4.jpeg" alt="GOBus" class="mobile-logo-img">
        <h1>LAYELI DUBAI</h1>
    </div>
    <div class="mobile-hamburger" id="mobile-hamburger">&#9776;</div>
</div>

<!-- Mobile Navigation - Hidden by default on all screens -->
<div class="mobile-nav" id="mobile-nav">
    <div class="mobile-nav-header">
        <h2>Admin Menu</h2>
        <button class="mobile-close-btn" id="mobile-close-btn">
            &#10005;
        </button>
    </div>
    <ul>
        <li><a href="dashboard.php" <?php echo (basename($_SERVER['PHP_SELF']) == 'dashboard.php') ? 'class="active"' : ''; ?>>
            <svg class="nav-icon" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z" fill="currentColor"/>
            </svg> Dashboard
        </a></li>
        <li><a href="manage_buses.php" <?php echo (basename($_SERVER['PHP_SELF']) == 'manage_buses.php') ? 'class="active"' : ''; ?>>
            <svg class="nav-icon" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M4 16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2v-8c0-1.1-.9-2-2-2H6c-1.1 0-2 .9-2 2v8zm3-7c0-.55.45-1 1-1s1 .45 1 1-.45 1-1 1-1-.45-1-1zm3 0c0-.55.45-1 1-1s1 .45 1 1-.45 1-1 1-1-.45-1-1zm3 0c0-.55.45-1 1-1s1 .45 1 1-.45 1-1 1-1-.45-1-1zm3 0c0-.55.45-1 1-1s1 .45 1 1-.45 1-1 1-1-.45-1-1zm-8 7c-.55 0-1-.45-1-1s.45-1 1-1 1 .45 1 1-.45 1-1 1zm8 0c-.55 0-1-.45-1-1s.45-1 1-1 1 .45 1 1-.45 1-1 1z" fill="currentColor"/>
            </svg> Manage Buses
        </a></li>
        <li><a href="manage_routes.php" <?php echo (basename($_SERVER['PHP_SELF']) == 'manage_routes.php') ? 'class="active"' : ''; ?>>
            <svg class="nav-icon" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z" fill="currentColor"/>
            </svg> Manage Routes
        </a></li>
        <li><a href="manage_users.php" <?php echo (basename($_SERVER['PHP_SELF']) == 'manage_users.php') ? 'class="active"' : ''; ?>>
            <svg class="nav-icon" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z" fill="currentColor"/>
            </svg> Manage Users
        </a></li>
        <li><a href="manage_bookings.php" <?php echo (basename($_SERVER['PHP_SELF']) == 'manage_bookings.php') ? 'class="active"' : ''; ?>>
            <svg class="nav-icon" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M22 10V6c0-1.11-.9-2-2-2H4c-1.1 0-1.99.89-1.99 2v4c1.1 0 1.99.9 1.99 2s-.89 2-2 2v4c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2v-4c-1.1 0-2-.9-2-2s.9-2 2-2zm-9 7.5h-2v-2h2v2zm0-4.5h-2v-2h2v2zm0-4.5h-2v-2h2v2z" fill="currentColor"/>
            </svg> Manage Bookings
        </a></li>
        <li><a href="manage_balance.php" <?php echo (basename($_SERVER['PHP_SELF']) == 'manage_balance.php') ? 'class="active"' : ''; ?>>
            <svg class="nav-icon" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M21 18v1c0 1.1-.9 2-2 2H5c-1.11 0-2-.9-2-2V5c0-1.1.89-2 2-2h14c1.1 0 2 .9 2 2v1h-9c-1.11 0-2 .9-2 2v8c0 1.1.89 2 2 2h9zm-9-2h10V8H12v8z" fill="currentColor"/>
            </svg> Balance
        </a></li>
        <li><a href="transaction_history.php" <?php echo (basename($_SERVER['PHP_SELF']) == 'transaction_history.php') ? 'class="active"' : ''; ?>>
            <svg class="nav-icon" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M19 3h-4.18C14.4 1.84 13.3 1 12 1c-1.3 0-2.4.84-2.82 2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 0c.55 0 1 .45 1 1s-.45 1-1 1-1-.45-1-1 .45-1 1-1zm0 4c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm6 12H6v-1.4c0-2 4-3.1 6-3.1s6 1.1 6 3.1V19z" fill="currentColor"/>
            </svg> View Transactions
        </a></li>
        <li><a href="view_reports.php" <?php echo (basename($_SERVER['PHP_SELF']) == 'view_reports.php') ? 'class="active"' : ''; ?>>
            <svg class="nav-icon" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z" fill="currentColor"/>
            </svg> View Reports
        </a></li>
        <li><a href="admin_logout.php">
            <svg class="nav-icon" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M17 7l-1.41 1.41L18.17 11H8v2h10.17l-2.58 2.58L17 17l5-5zM4 5h8V3H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h8v-2H4V5z" fill="currentColor"/>
            </svg> Logout
        </a></li>
    </ul>
</div>

<!-- Overlay for mobile navigation -->
<div class="mobile-overlay" id="mobile-overlay"></div>

<style>
    /* Reset styles to prevent conflicts */
    .mobile-header *,
    .mobile-nav *,
    .mobile-overlay {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }
    
    /* Mobile Header - Only visible on smaller screens */
    .mobile-header {
        background: linear-gradient(to right, #004080, #0066cc);
        color: white;
        padding: 12px 16px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.15);
        display: none; /* Hidden by default */
        justify-content: space-between;
        align-items: center;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        z-index: 9998;
        height: 60px;
    }

    .mobile-logo {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .mobile-logo h1 {
        margin: 0;
        font-size: 20px;
        font-weight: 600;
        color: #fff;
        letter-spacing: 0.5px;
    }

    .mobile-logo-img {
        max-height: 36px;
        border-radius: 4px;
    }
    
    /* Hamburger Menu */
    .mobile-hamburger {
        font-size: 28px;
        cursor: pointer;
        color: white;
        display: flex;
        padding-right: 35px;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        border-radius: 4px;
        transition: background-color 0.2s;
        -webkit-tap-highlight-color: transparent;
    }
    
    .mobile-hamburger:hover {
        background-color: rgba(255, 255, 255, 0.1);
    }

    /* Mobile Navigation */
    .mobile-nav {
        position: fixed;
        top: 0;
        right: -280px; /* Hidden off-screen by default */
        width: 280px;
        height: 100%;
        background: linear-gradient(135deg, #004080, #0066cc);
        color: white;
        z-index: 9999;
        overflow-y: auto;
        transition: transform 0.3s ease;
        box-shadow: -5px 0 15px rgba(0, 0, 0, 0.2);
        transform: translateX(0);
    }
    
    .mobile-nav.open {
        transform: translateX(-280px);
    }
    
    .mobile-nav-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px;
        background: rgba(0, 0, 0, 0.1);
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        position: sticky;
        top: 0;
        z-index: 2;
    }
    
    .mobile-nav-header h2 {
        font-size: 18px;
        margin: 0;
        color: white;
    }
    
    .mobile-close-btn {
        background: transparent;
        border: none;
        color: white;
        font-size: 22px;
        cursor: pointer;
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        transition: background-color 0.2s;
        z-index: 10;
        outline: none;
    }
    
    .mobile-close-btn:hover {
        background-color: rgba(255, 255, 255, 0.1);
    }
    
    .mobile-nav ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    
    .mobile-nav ul li {
        border-bottom: 1px solid rgba(255, 255, 255, 0.07);
    }
    
    .mobile-nav ul li a {
        color: white;
        text-decoration: none;
        font-size: 15px;
        padding: 14px 20px;
        display: flex;
        align-items: center;
        gap: 12px;
        transition: all 0.2s ease;
    }
    
    /* SVG Icons */
    .nav-icon {
        width: 20px;
        height: 20px;
        fill: currentColor;
        flex-shrink: 0;
    }
    
    .mobile-nav ul li a:hover {
        background-color: rgba(255, 255, 255, 0.1);
        padding-left: 25px;
    }
    
    .mobile-nav ul li a.active {
        background-color: rgba(255, 255, 255, 0.15);
        font-weight: 500;
    }
    
    /* Overlay */
    .mobile-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 9997;
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.3s ease;
        -webkit-backdrop-filter: blur(2px);
        backdrop-filter: blur(2px);
    }
    
    .mobile-overlay.active {
        opacity: 1;
        visibility: visible;
    }
    
    /* Only show on mobile/tablet */
    @media (max-width: 768px) {
        .mobile-header {
            display: flex;
        }
        
        /* Add padding to body to prevent content from being hidden under fixed header */
        body {
            padding-top: 60px !important;
            overflow-x: hidden !important; /* Prevent horizontal scrolling */
            width: 100% !important;
        }
        
        /* Fix for jittering effect */
        html {
            overflow-x: hidden !important;
            max-width: 100vw !important;
        }
    }
    
    /* Smaller screens */
    @media (max-width: 480px) {
        .mobile-header {
            padding: 10px 12px;
        }
        
        .mobile-logo h1 {
            font-size: 18px;
        }
        
        .mobile-logo-img {
            max-height: 32px;
        }
        
        .mobile-nav {
            width: 85%;
            right: -85%;
        }
        
        .mobile-nav.open {
            transform: translateX(-100%);
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const mobileHamburger = document.getElementById('mobile-hamburger');
        const mobileNav = document.getElementById('mobile-nav');
        const mobileCloseBtn = document.getElementById('mobile-close-btn');
        const mobileOverlay = document.getElementById('mobile-overlay');
        
        // Function to check if we're on mobile view
        function isMobileView() {
            return window.innerWidth <= 768;
        }
        
        // Only initialize mobile header if we're on mobile
        if (mobileHamburger && mobileNav) {
            // Prevent scrollbar from causing layout shifts
            document.documentElement.style.overflow = 'hidden auto';
            document.documentElement.style.maxWidth = '100vw';
            
            // Open mobile nav
            mobileHamburger.addEventListener('click', function(e) {
                e.stopPropagation();
                mobileNav.classList.add('open');
                mobileOverlay.classList.add('active');
                document.body.style.overflow = 'hidden';
            });
            
            // Close mobile nav
            if (mobileCloseBtn) {
                mobileCloseBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    mobileNav.classList.remove('open');
                    mobileOverlay.classList.remove('active');
                    document.body.style.overflow = '';
                });
            }
            
            // Close mobile nav when clicking overlay
            if (mobileOverlay) {
                mobileOverlay.addEventListener('click', function() {
                    mobileNav.classList.remove('open');
                    mobileOverlay.classList.remove('active');
                    document.body.style.overflow = '';
                });
            }
            
            // Add event listener to prevent touchmove on mobile menu when open (prevents background scrolling)
            document.addEventListener('touchmove', function(e) {
                if (mobileNav.classList.contains('open') && !mobileNav.contains(e.target)) {
                    e.preventDefault();
                }
            }, { passive: false });
        }
        
        // Add escape key listener
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && mobileNav && mobileNav.classList.contains('open')) {
                mobileNav.classList.remove('open');
                if (mobileOverlay) {
                    mobileOverlay.classList.remove('active');
                }
                document.body.style.overflow = '';
            }
        });
        
        // Handle screen resize
        window.addEventListener('resize', function() {
            if (!isMobileView()) {
                // Reset mobile nav on desktop
                if (mobileNav && mobileNav.classList.contains('open')) {
                    mobileNav.classList.remove('open');
                    if (mobileOverlay) {
                        mobileOverlay.classList.remove('active');
                    }
                    document.body.style.overflow = '';
                }
            }
        });
    });
</script>

<footer class="admin-footer">
    <div class="footer-content">
        <div class="footer-logo">
            <img src="../assets/images/logo.png" alt="GOBus" class="footer-logo-img">
        </div>
        <div class="footer-info">
            <p>&copy; <?php echo date("Y"); ?> GOBus Booking System</p>
            <p class="version">Version 1.0.0</p>
        </div>
        <div class="footer-links">
            <a href="#">Privacy Policy</a>
            <a href="#">Terms of Service</a>
            <a href="#">Contact</a>
        </div>
    </div>
</footer>

<style>
/* Footer Styling */
.admin-footer {
    background: linear-gradient(to right, #004080, #0066cc);
    color: rgba(255, 255, 255, 0.9);
    padding: 15px 0;
    position: fixed;
    width: 100%;
    bottom: 0;
    left: 0;
    z-index: 1000;
    box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.1);
}

.footer-content {
    max-width: 1200px;
    margin: 0 auto;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0 20px;
}

.footer-logo {
    display: flex;
    align-items: center;
}

.footer-logo-img {
    height: 30px;
    width: auto;
    margin-right: 10px;
}

.footer-info {
    text-align: center;
    color: white;
}

.footer-info p {
    margin: 0;
    font-size: 14px;
    font-weight: 400;
    color: white;
}

.footer-info .version {
    font-size: 12px;
    opacity: 0.8;
    margin-top: 2px;
    color: white;
}

.footer-links {
    display: flex;
    gap: 20px;
}

.footer-links a {
    color: white;
    text-decoration: none;
    font-size: 13px;
    transition: opacity 0.2s ease;
}

.footer-links a:hover {
    opacity: 0.8;
    text-decoration: underline;
}

/* Add padding to body to prevent content from being hidden behind fixed footer */
body {
    padding-bottom: 60px; /* Adjust based on your footer height */
}

/* Make sure the content container fills available space but doesn't extend under footer */
.main-content {
    min-height: calc(100vh - 120px); /* Adjust based on header + footer height */
    padding-bottom: 20px;
}

/* Responsive design */
@media (max-width: 768px) {
    .footer-content {
        flex-direction: column;
        gap: 10px;
        text-align: center;
        padding: 10px 15px;
    }
    
    .footer-links {
        gap: 15px;
        justify-content: center;
        flex-wrap: wrap;
    }
    
    .admin-footer {
        padding: 12px 0;
    }
    
    body {
        padding-bottom: 100px; /* Increase padding for stacked footer elements */
    }
}

@media (max-width: 480px) {
    .footer-links {
        gap: 10px;
    }
    
    .footer-logo-img {
        height: 25px;
    }
    
    .footer-info p {
        font-size: 12px;
    }
    
    .footer-links a {
        font-size: 12px;
    }
}
</style>

<!-- JavaScript to adjust body padding based on actual footer height -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    function adjustBodyPadding() {
        const footerHeight = document.querySelector('.admin-footer').offsetHeight;
        document.body.style.paddingBottom = footerHeight + 'px';
    }
    
    // Run on load
    adjustBodyPadding();
    
    // Run on window resize
    window.addEventListener('resize', adjustBodyPadding);
});
</script>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Canberra Bus</title>
    <link rel="stylesheet" href="assets/css/contact_us.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <!-- Hero Section -->
    <section class="contact-hero">
        <div class="contact-hero-overlay"></div>
        <div class="container contact-hero-content">
            <h1>Contact Us</h1>
            <p>We're here to help! Reach out for bookings, support, or any questions about GOBus. Reach out and our team will respond promptly.</p>
        </div>
    </section>

    <!-- Main Contact Section -->
    <section class="contact-section">
        <div class="container contact-cards-flex">
            <!-- Contact Form Card -->
            <div class="contact-card contact-form-card">
                <h2>Send Us a Message</h2>
                <form class="contact-form" action="#" method="post">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" id="name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="subject">Subject</label>
                        <input type="text" id="subject" name="subject" required>
                    </div>
                    <div class="form-group">
                        <label for="message">Message</label>
                        <textarea id="message" name="message" rows="5" required></textarea>
                    </div>
                    <button type="submit" class="btn-submit">Send Message</button>
                    <div class="form-success" style="display:none;">Thank you for contacting us! We'll get back to you soon.</div>
                </form>
            </div>
            <!-- Contact Info Card -->
            <div class="contact-card contact-info-card">
                <h2>Contact Information</h2>
                <div class="info-list">
                    <div class="info-item">
                        <div class="info-icon"><i class="fas fa-envelope"></i></div>
                        <div class="info-content">
                            <div class="info-title">Email</div>
                            <div class="info-detail">support@gobus.com.au</div>
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="info-icon"><i class="fas fa-phone"></i></div>
                        <div class="info-content">
                            <div class="info-title">Phone</div>
                            <div class="info-detail">+61 1234 5678</div>
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="info-icon"><i class="fas fa-map-marker-alt"></i></div>
                        <div class="info-content">
                            <div class="info-title">Address</div>
                            <div class="info-detail">123 Main St, Canberra, ACT, Australia</div>
                        </div>
                    </div>
                </div>
                <div class="contact-map">
                    <!-- Google Maps Embed (optional, can be commented out) -->
                    <iframe src="https://www.google.com/maps?q=Canberra,+Australia&output=embed" width="100%" height="180" style="border:0; border-radius:8px;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </div>
    </section>

    <?php include 'includes/footer.php'; ?>
</body>
</html>

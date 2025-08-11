<?php include 'includes/header.php'; ?>
<link rel="stylesheet" href="assets/css/home.css">
<script src="assets/js/home.js" defer></script>

<!-- Hero Banner Section -->
<section class="hero-section">
    <div class="hero-background"></div>

    <div class="hero-content">
        <h1>Welcome to <span>Layeli Dubai Event</span></h1>
        <p>Secure your spot now for an exclusive night with <strong>Drake</strong> in the heart of Dubai.</p>

        <!-- Nouveau bouton stylisé de réservation -->
        <div class="booking-button-wrapper">
    <a href="#tickets" class="booking-button">
        🎟️ Book Your Tickets Now
    </a>
</div>

    </div>
</section>


<style>
    .booking-button-wrapper {
    display: flex;
    justify-content: center;
    margin-top: 40px;
    padding: 0 20px;
}

.booking-button {
    background: linear-gradient(135deg, #ff3366, #cc00ff);
    color: #fff;
    padding: 18px 40px;
    font-size: 20px;
    font-weight: 600;
    border-radius: 50px;
    text-decoration: none;
    box-shadow: 0 8px 20px rgba(204, 0, 255, 0.3);
    transition: all 0.3s ease;
    text-align: center;
    white-space: nowrap;
}

.booking-button:hover {
    transform: scale(1.05);
    box-shadow: 0 12px 25px rgba(204, 0, 255, 0.4);
}

@media screen and (max-width: 768px) {
    .booking-button {
        font-size: 18px;
        padding: 16px 30px;
    }
}

@media screen and (max-width: 480px) {
    .booking-button {
        font-size: 16px;
        padding: 14px 24px;
    }
}

    .booking-ticket-section {
        display: flex;
        align-items: center;
        gap: 30px;
        padding: 20px;
        border: 1px solid #ddd;
        border-radius: 8px;
        background-color: #f9f9f9;
        max-width: 800px;
        margin: 20px auto;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        flex-wrap: wrap;
    }

    .ticket-image-container {
        flex-shrink: 0;
        text-align: center;
        width: 100%;
        max-width: 200px;
    }

    .ticket-image {
        width: 100%;
        height: auto;
        border-radius: 5px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .booking-inputs-ticket {
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        gap: 15px;
        min-width: 250px;
        flex: 1;
    }

    .form-group label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
        color: #333;
    }

    .form-group input[type="number"],
    .form-group select {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
    }

    .btn-search {
        background-color: #333;
        color: #fff;
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
        font-size: 14px;
    }

    .btn-search:hover {
        background-color: #555;
    }

    @media (max-width: 768px) {
        .booking-ticket-section {
            flex-direction: column;
            align-items: flex-start;
            text-align: left;
        }

        .ticket-image-container,
        .booking-inputs-ticket {
            width: 100%;
        }

        .ticket-image-container {
            max-width: 100%;
        }
    }
</style>


<!-- Services Section -->
<section class="features-section section-padding">
    <div class="container">
        <div class="section-title">
            <h2>Why Book with LayeliDubai</h2>
            <p>Discover a seamless event booking experience with smart features that make planning easy and enjoyable</p>
        </div>
        <div class="features-container">
            <div class="feature-card">
                <div class="feature-icon">
                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 15C13.6569 15 15 13.6569 15 12C15 10.3431 13.6569 9 12 9C10.3431 9 9 10.3431 9 12C9 13.6569 10.3431 15 12 15Z" stroke="#0055aa" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M19.4 15C19.2669 15.3016 19.2272 15.6362 19.286 15.9606C19.3448 16.285 19.4995 16.5843 19.73 16.82L19.79 16.88C19.976 17.0657 20.1235 17.2863 20.2241 17.5291C20.3248 17.7719 20.3766 18.0322 20.3766 18.295C20.3766 18.5578 20.3248 18.8181 20.2241 19.0609C20.1235 19.3037 19.976 19.5243 19.79 19.71C19.6043 19.896 19.3837 20.0435 19.1409 20.1441C18.8981 20.2448 18.6378 20.2966 18.375 20.2966C18.1122 20.2966 17.8519 20.2448 17.6091 20.1441C17.3663 20.0435 17.1457 19.896 16.96 19.71L16.9 19.65C16.6643 19.4195 16.365 19.2648 16.0406 19.206C15.7162 19.1472 15.3816 19.1869 15.08 19.32C14.7842 19.4468 14.532 19.6572 14.3543 19.9255C14.1766 20.1938 14.0813 20.5082 14.08 20.83V21C14.08 21.5304 13.8693 22.0391 13.4942 22.4142C13.1191 22.7893 12.6104 23 12.08 23C11.5496 23 11.0409 22.7893 10.6658 22.4142C10.2907 22.0391 10.08 21.5304 10.08 21V20.91C10.0723 20.579 9.96512 20.258 9.77251 19.9887C9.5799 19.7194 9.31074 19.5143 9 19.4C8.69838 19.2669 8.36381 19.2272 8.03941 19.286C7.71502 19.3448 7.41568 19.4995 7.18 19.73L7.12 19.79C6.93425 19.976 6.71368 20.1235 6.47088 20.2241C6.22808 20.3248 5.96783 20.3766 5.705 20.3766C5.44217 20.3766 5.18192 20.3248 4.93912 20.2241C4.69632 20.1235 4.47575 19.976 4.29 19.79C4.10405 19.6043 3.95653 19.3837 3.85588 19.1409C3.75523 18.8981 3.70343 18.6378 3.70343 18.375C3.70343 18.1122 3.75523 17.8519 3.85588 17.6091C3.95653 17.3663 4.10405 17.1457 4.29 16.96L4.35 16.9C4.58054 16.6643 4.73519 16.365 4.794 16.0406C4.85282 15.7162 4.81312 15.3816 4.68 15.08C4.55324 14.7842 4.34276 14.532 4.07447 14.3543C3.80618 14.1766 3.49179 14.0813 3.17 14.08H3C2.46957 14.08 1.96086 13.8693 1.58579 13.4942C1.21071 13.1191 1 12.6104 1 12.08C1 11.5496 1.21071 11.0409 1.58579 10.6658C1.96086 10.2907 2.46957 10.08 3 10.08H3.09C3.42099 10.0723 3.742 9.96512 4.0113 9.77251C4.28059 9.5799 4.48572 9.31074 4.6 9C4.73312 8.69838 4.77282 8.36381 4.714 8.03941C4.65519 7.71502 4.50054 7.41568 4.27 7.18L4.21 7.12C4.02405 6.93425 3.87653 6.71368 3.77588 6.47088C3.67523 6.22808 3.62343 5.96783 3.62343 5.705C3.62343 5.44217 3.67523 5.18192 3.77588 4.93912C3.87653 4.69632 4.02405 4.47575 4.21 4.29C4.39575 4.10405 4.61632 3.95653 4.85912 3.85588C5.10192 3.75523 5.36217 3.70343 5.625 3.70343C5.88783 3.70343 6.14808 3.75523 6.39088 3.85588C6.63368 3.95653 6.85425 4.10405 7.04 4.29L7.1 4.35C7.33568 4.58054 7.63502 4.73519 7.95941 4.794C8.28381 4.85282 8.61838 4.81312 8.92 4.68H9C9.29577 4.55324 9.54802 4.34276 9.72569 4.07447C9.90337 3.80618 9.99872 3.49179 10 3.17V3C10 2.46957 10.2107 1.96086 10.5858 1.58579C10.9609 1.21071 11.4696 1 12 1C12.5304 1 13.0391 1.21071 13.4142 1.58579C13.7893 1.96086 14 2.46957 14 3V3.09C14.0013 3.41179 14.0966 3.72618 14.2743 3.99447C14.452 4.26276 14.7042 4.47324 15 4.6C15.3016 4.73312 15.6362 4.77282 15.9606 4.714C16.285 4.65519 16.5843 4.50054 16.82 4.27L16.88 4.21C17.0657 4.02405 17.2863 3.87653 17.5291 3.77588C17.7719 3.67523 18.0322 3.62343 18.295 3.62343C18.5578 3.62343 18.8181 3.67523 19.0609 3.77588C19.3037 3.87653 19.5243 4.02405 19.71 4.21C19.896 4.39575 20.0435 4.61632 20.1441 4.85912C20.2448 5.10192 20.2966 5.36217 20.2966 5.625C20.2966 5.88783 20.2448 6.14808 20.1441 6.39088C20.0435 6.63368 19.896 6.85425 19.71 7.04L19.65 7.1C19.4195 7.33568 19.2648 7.63502 19.206 7.95941C19.1472 8.28381 19.1869 8.61838 19.32 8.92V9C19.4468 9.29577 19.6572 9.54802 19.9255 9.72569C20.1938 9.90337 20.5082 9.99872 20.83 10H21C21.5304 10 22.0391 10.2107 22.4142 10.5858C22.7893 10.9609 23 11.4696 23 12C23 12.5304 22.7893 13.0391 22.4142 13.4142C22.0391 13.7893 21.5304 14 21 14H20.91C20.5882 14.0013 20.2738 14.0966 20.0055 14.2743C19.7372 14.452 19.5268 14.7042 19.4 15Z" stroke="#0055aa" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <h3>Instant Event Booking</h3>
                <p>Secure your spot in seconds with our easy-to-use platform. Browse events, choose your seats, and pay—all in just a few clicks.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" stroke="#0055aa" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M12 6V12L16 14" stroke="#0055aa" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <h3>Real-Time Updates</h3>
                <p>Get live notifications on event changes, reminders, and exclusive offers. Stay informed and never miss an update.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M9 11L12 14L22 4" stroke="#0055aa" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M21 12V19C21 19.5304 20.7893 20.0391 20.4142 20.4142C20.0391 20.7893 19.5304 21 19 21H5C4.46957 21 3.96086 20.7893 3.58579 20.4142C3.21071 20.0391 3 19.5304 3 19V5C3 4.46957 3.21071 3.96086 3.58579 3.58579C3.96086 3.21071 4.46957 3 5 3H16" stroke="#0055aa" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <h3>Secure & Verified Tickets</h3>
                <p>Enjoy peace of mind with secure payments and verified e-tickets. Our system ensures safe, reliable access to every event.</p>
            </div>
        </div>
    </div>
</section>

<!-- About Us Section -->
<section class="about-section section-padding">
    <div class="container">
        <div class="about-container">
            <div class="about-image">
                <img src="assets/images/3.jpeg" al  t="About GOBus">
            </div>
            <div class="about-content">
                <h2>Your Gateway to Unforgettable Events</h2>
                <p>Our platform makes it easy to book events across Tunisia. Whether it’s a concert, conference, wedding, or festival, we connect you with the best experiences available.</p>
                
                <div class="about-features">
                    <div class="about-feature">
                        <div class="about-feature-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path d="M22 11.0801V12.0001C21.9988 14.1565 21.3005 16.2548 20.0093 17.9819C18.7182 19.7091 16.9033 20.9726 14.8354 21.5839C12.7674 22.1952 10.5573 22.1219 8.53447 21.3746C6.51168 20.6273 4.78465 19.2462 3.61096 17.4372C2.43727 15.6281 1.87979 13.4882 2.02168 11.3364C2.16356 9.18467 2.99721 7.13643 4.39828 5.49718C5.79935 3.85793 7.69279 2.71549 9.79619 2.24025C11.8996 1.76502 14.1003 1.98245 16.07 2.86011" stroke="#0055aa" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M22 4L12 14.01L9 11.01" stroke="#0055aa" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <div class="about-feature-content">
                            <h4>New Concept</h4>
                            <p>Trusted experience in managing and organizing events</p>
                        </div>
                    </div>
                    <div class="about-feature">
                        <div class="about-feature-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path d="M19.5 3.75H4.5C4.08579 3.75 3.75 4.08579 3.75 4.5V19.5C3.75 19.9142 4.08579 20.25 4.5 20.25H19.5C19.9142 20.25 20.25 19.9142 20.25 19.5V4.5C20.25 4.08579 19.9142 3.75 19.5 3.75Z" stroke="#0055aa" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M16.5 2.25V5.25" stroke="#0055aa" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M7.5 2.25V5.25" stroke="#0055aa" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M3.75 8.25H20.25" stroke="#0055aa" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M7.5 11.25H8.25V12H7.5V11.25Z" stroke="#0055aa" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M11.25 11.25H12V12H11.25V11.25Z" stroke="#0055aa" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M15 11.25H15.75V12H15V11.25Z" stroke="#0055aa" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M7.5 15H8.25V15.75H7.5V15Z" stroke="#0055aa" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M11.25 15H12V15.75H11.25V15Z" stroke="#0055aa" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M15 15H15.75V15.75H15V15Z" stroke="#0055aa" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <div class="about-feature-content">
                           <h4>20 Juillet </h4>
                            <p>Ski Dubai</p>
                        </div>
                    </div>
                    <div class="about-feature">
                        <div class="about-feature-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <path d="M17 21V19C17 17.9391 16.5786 16.9217 15.8284 16.1716C15.0783 15.4214 14.0609 15 13 15H5C3.93913 15 2.92172 15.4214 2.17157 16.1716C1.42143 16.9217 1 17.9391 1 19V21" stroke="#0055aa" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M9 11C11.2091 11 13 9.20914 13 7C13 4.79086 11.2091 3 9 3C6.79086 3 5 4.79086 5 7C5 9.20914 6.79086 11 9 11Z" stroke="#0055aa" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M23 21V19C22.9993 18.1137 22.7044 17.2528 22.1614 16.5523C21.6184 15.8519 20.8581 15.3516 20 15.13" stroke="#0055aa" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M16 3.13C16.8604 3.35031 17.623 3.85071 18.1676 4.55232C18.7122 5.25392 19.0078 6.11683 19.0078 7.005C19.0078 7.89318 18.7122 8.75608 18.1676 9.45769C17.623 10.1593 16.8604 10.6597 16 10.88" stroke="#0055aa" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <div class="about-feature-content">
                             <h4>3000 Bookings</h4>
                            <p>Thousands trust us for secure and seamless ticketing</p>
                        </div>
                    </div>
                </div>
                
                <div class="about-action">
                    <a href="about_us.php" class="btn-about">
                        Learn More About Us
                        <svg width="18" height="18" viewBox="0 0 24 24">
                            <path d="M5 12H19M19 12L12 5M19 12L12 19" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Ticket Types Section -->
<section class="fleet-section section-padding" id="tickets">
    <div class="container">
        <div class="section-title">
            <h2>Choose Your Experience</h2>
            <p>Secure your spot for the Layeli Dubai Event – an unforgettable night with Drake!</p>
        </div>

        <div class="fleet-tabs">
            <div class="fleet-tab active" data-tab="general">General</div>
            <div class="fleet-tab" data-tab="floor">Floor</div>
            <div class="fleet-tab" data-tab="golden">Golden Circle</div>
            <div class="fleet-tab" data-tab="vip">VIP Seated</div>
            <div class="fleet-tab" data-tab="meet">Meet & Greet</div>
        </div>

        <!-- General Admission -->
        <div class="fleet-container active" id="general-fleet">
            <div class="fleet-card">
                <div class="fleet-image">
                    <img src="assets/images/5.JPG" alt="General Admission">
                </div>
                <div class="fleet-info">
                    <h3>General Admission</h3>
                    <p>Enjoy the concert from the main area with great vibes and access to all standard facilities.</p>
                    <div class="fleet-details">
                        <div class="fleet-amenities">
                            <span>Standing Area</span>
                            <span>Food & Drink Access</span>
                        </div>
                        <div class="fleet-price">300 AED</div>
                    </div>
                    <a href="GeneralAdmission.php?type=luxury" class="fleet-btn">Book Now
                        <svg width="18" height="18"><path d="M5 12H19M19 12L12 5M19 12L12 19" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </a>
                </div>
            </div>
        </div>

        <!-- Floor Standing -->
        <div class="fleet-container" id="floor-fleet">
            <div class="fleet-card">
                <div class="fleet-image">
                    <img src="assets/images/6.JPG" alt="Floor Standing">
                </div>
                <div class="fleet-info">
                    <h3>Floor Standing</h3>
                    <p>Get closer to the stage in a high-energy floor section with immersive sound and lighting.</p>
                    <div class="fleet-details">
                        <div class="fleet-amenities">
                            <span>Front Zone</span>
                            <span>Dedicated Access</span>
                        </div>
                        <div class="fleet-price">450 AED</div>
                    </div>
                    <a href="FloorStanding.php?type=standard" class="fleet-btn">Book Now
                        <svg width="18" height="18"><path d="M5 12H19M19 12L12 5M19 12L12 19" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </a>
                </div>
            </div>
        </div>

        <!-- Golden Circle -->
        <div class="fleet-container" id="golden-fleet">
            <div class="fleet-card">
                <div class="fleet-image">
                    <img src="assets/images/7.JPG" alt="Golden Circle">
                </div>
                <div class="fleet-info">
                    <h3>Golden Circle</h3>
                    <p>Premium standing area closest to the stage – limited capacity, best views, fast entry.</p>
                    <div class="fleet-details">
                        <div class="fleet-amenities">
                            <span>Closest to Stage</span>
                            <span>Exclusive Zone</span>
                        </div>
                        <div class="fleet-price">1000 AED</div>
                    </div>
                    <a href="GoldenCircle.php?type=economy" class="fleet-btn">Book Now
                        <svg width="18" height="18"><path d="M5 12H19M19 12L12 5M19 12L12 19" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </a>
                </div>
            </div>
        </div>

        <!-- VIP Seated -->
        <div class="fleet-container" id="vip-fleet">
            <div class="fleet-card">
                <div class="fleet-image">
                    <img src="assets/images/8.JPG" alt="VIP Seated">
                </div>
                <div class="fleet-info">
                    <h3>VIP Seated</h3>
                    <p>Enjoy the show in luxury with premium seating, excellent views, and VIP amenities.</p>
                    <div class="fleet-details">
                        <div class="fleet-amenities">
                            <span>Reserved Seats</span>
                            <span>VIP Lounge Access</span>
                            <span>Fast Track</span>
                        </div>
                        <div class="fleet-price">1600 AED</div>
                    </div>
                    <a href="VIPSeated.php?type=economy" class="fleet-btn">Book Now
                        <svg width="18" height="18"><path d="M5 12H19M19 12L12 5M19 12L12 19" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </a>
                </div>
            </div>
        </div>

        <!-- Meet & Greet -->
        <div class="fleet-container" id="meet-fleet">
            <div class="fleet-card">
                <div class="fleet-image">
                    <img src="assets/images/9.JPG" alt="Meet and Greet">
                </div>
                <div class="fleet-info">
                    <h3>Meet & Greet</h3>
                    <p>Get the ultimate experience: meet Drake in person, photos, VIP treatment and exclusive goodies.</p>
                    <div class="fleet-details">
                        <div class="fleet-amenities">
                            <span>Artist Meet</span>
                            <span>Signed Merch</span>
                            <span>Front Row Seat</span>
                        </div>
                        <div class="fleet-price">9000 AED</div>
                    </div>
                    <a href="Meet&Greet.php?type=economy" class="fleet-btn">Book Now
                        <svg width="18" height="18"><path d="M5 12H19M19 12L12 5M19 12L12 19" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>




<!-- FAQ Section -->
<section class="faq-section section-padding">
    <div class="container">
        <div class="section-title">
            <h2>Frequently Asked Questions</h2>
            <p>Find answers to common questions about the Layeli Dubai event</p>
        </div>
        
        <div class="faq-container">
            <div class="faq-item">
                <div class="faq-header">
                    <h3>How can I book a ticket for the event?</h3>
                    <span class="faq-toggle"></span>
                </div>
                <div class="faq-content">
                    <div class="faq-content-inner">
                        <p>You can book tickets directly on our website by selecting the number of tickets and ticket type on the homepage or the Book Tickets page. After choosing, proceed to secure payment to confirm your booking.</p>
                    </div>
                </div>
            </div>
            
            <div class="faq-item">
                <div class="faq-header">
                    <h3>What types of tickets are available?</h3>
                    <span class="faq-toggle"></span>
                </div>
                <div class="faq-content">
                    <div class="faq-content-inner">
                        <p>We offer several ticket types: General Admission, Floor Standing, Golden Circle, VIP Seated, and Meet & Greet. Each offers a different experience and level of access, so choose the one that suits you best!</p>
                    </div>
                </div>
            </div>
            
            <div class="faq-item">
                <div class="faq-header">
                    <h3>Are payments secure on your site?</h3>
                    <span class="faq-toggle"></span>
                </div>
                <div class="faq-content">
                    <div class="faq-content-inner">
                        <p>Yes, our site uses secure payment gateways with encryption protocols to protect your data. All transactions are encrypted and processed through trusted PCI-compliant providers.</p>
                    </div>
                </div>
            </div>
            
            <div class="faq-item">
                <div class="faq-header">
                    <h3>Can I get a refund if I cancel?</h3>
                    <span class="faq-toggle"></span>
                </div>
                <div class="faq-content">
                    <div class="faq-content-inner">
                        <p>Tickets are non-refundable except in case of event cancellation. However, you may transfer your ticket to someone else. Make sure to contact our support team for transfer requests.</p>
                    </div>
                </div>
            </div>
            
            <div class="faq-item">
                <div class="faq-header">
                    <h3>What should I bring to the event?</h3>
                    <span class="faq-toggle"></span>
                </div>
                <div class="faq-content">
                    <div class="faq-content-inner">
                        <p>Please bring a valid ID that matches your ticket name, your digital or printed ticket QR code, and any personal items permitted by the venue. Check our full list of allowed/prohibited items beforehand.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- Call to Action Section -->
<section class="cta-section">
    <div class="cta-background"></div>
    <div class="container">
        <div class="cta-container">
            <h2>Ready to Experience Layeli Dubai with Drake?</h2>
            <p>Book your tickets now for an unforgettable night filled with music, energy, and exclusive moments.</p>
            <div class="cta-buttons">
                <a href="book_tickets.php" class="btn-cta primary">
                    Book Your Tickets
                    <svg width="18" height="18" viewBox="0 0 24 24">
                        <path d="M5 12H19M19 12L12 5M19 12L12 19" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </a>
                <a href="contact_us.php" class="btn-cta secondary">
                    Contact Support
                    <svg width="18" height="18" viewBox="0 0 24 24">
                        <path d="M21 10C21 17 12 23 12 23C12 23 3 17 3 10C3 7.61305 3.94821 5.32387 5.63604 3.63604C7.32387 1.94821 9.61305 1 12 1C14.3869 1 16.6761 1.94821 18.364 3.63604C20.0518 5.32387 21 7.61305 21 10Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M12 13C13.6569 13 15 11.6569 15 10C15 8.34315 13.6569 7 12 7C10.3431 7 9 8.34315 9 10C9 11.6569 10.3431 13 12 13Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</section>


<!-- Add JavaScript for route validation at the end of the file before the footer -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('quickBookingForm');
    const fromSelect = document.getElementById('from');
    const toSelect = document.getElementById('to');
    const errorDiv = document.getElementById('routeError');
    
    // Define available routes
    const availableRoutes = [
        {from: 'Canberra', to: 'Sydney'},
        {from: 'Sydney', to: 'Canberra'},
        {from: 'Canberra', to: 'Melbourne'},
        {from: 'Melbourne', to: 'Canberra'},
        {from: 'Sydney', to: 'Melbourne'},
        {from: 'Melbourne', to: 'Sydney'},
        {from: 'Sydney', to: 'Brisbane'},
        {from: 'Brisbane', to: 'Sydney'}
    ];
    
    // Prevent selecting same origin and destination
    toSelect.addEventListener('change', function() {
        if (fromSelect.value === toSelect.value) {
            errorDiv.textContent = 'Origin and destination cannot be the same';
            errorDiv.style.display = 'block';
            toSelect.value = '';
        } else {
            errorDiv.style.display = 'none';
        }
    });
    
    // Form submission validation
    form.addEventListener('submit', function(e) {
        const from = fromSelect.value;
        const to = toSelect.value;
        
        // Validate that from and to are not the same
        if (from === to) {
            e.preventDefault();
            errorDiv.textContent = 'Origin and destination cannot be the same';
            errorDiv.style.display = 'block';
            return;
        }
        
        // Check if the route exists
        const routeExists = availableRoutes.some(route => 
            route.from === from && route.to === to
        );
        
        if (!routeExists) {
            e.preventDefault();
            errorDiv.textContent = 'Sorry, this route is not available';
            errorDiv.style.display = 'block';
        } else {
            errorDiv.style.display = 'none';
        }
    });
});
</script>

<?php include 'includes/footer.php'; ?>

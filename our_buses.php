<!DOCTYPE html> 
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Buses - GOBus</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="assets/css/our_buses.css">
    <style>
        .hero-bus {
  background: url('assets/images/4.jpeg') no-repeat center center/cover;
  position: relative;
  height: 500px;
  display: flex;
  align-items: center;
  justify-content: center;
  color: white;
}
    </style>
</head>
<body>
<?php include 'includes/header.php'; ?>

<!-- Hero Section -->
<section class="hero-bus">
    <div class="hero-bus-content">
    <div class="hero-overlay"></div>
       <h1>LayeliDubai - Drake Live</h1>
        <p>Experience the iconic concert event in the heart of Dubai</p>
     <a href="book_tickets.php" class="btn-hero">Get Your Tickets</a>
    </div>
</section>

<!-- Why Travel With Us Section -->
<section class="why-section">
    <div class="container">
        <div class="section-title" style="margin-bottom:30px;">
            <h2 style="margin-bottom:6px;">Why Attend LayeliDubai?</h2>
             <p>Join thousands of fans in an unforgettable live music experience.</p>
    </div>
        <div class="why-grid">
            <div class="why-item">
                <i class="fas fa-shield-alt"></i>
                 <h4>Unmatched Performance</h4>
                <p>Drake delivers a dynamic set with exclusive tracks and hits.</p>
              </div>
            <div class="why-item">
                <i class="fas fa-clock"></i>
                  <h4>Massive Crowd Energy</h4>
                <p>Join thousands of passionate fans for an electric atmosphere.</p>
            </div>
            <div class="why-item">
                <i class="fas fa-wifi"></i>
              <h4>Innovative Production</h4>
                <p>State-of-the-art sound and visual effects make the show spectacular.</p>
              </div>
            <div class="why-item">
                <i class="fas fa-leaf"></i>
                   <h4>Prime Location</h4>
                <p>Held in Dubai's premier event venues with easy access and amenities.</p>
           </div>
        </div>
    </div>
</section>

<!-- Fleet Showcase -->
<section class="section">
    <div class="container">
        <div class="section-title">
           <h2>Ticket Packages</h2>
            <p>Choose the perfect experience for your concert night with Drake.</p>
           </div>
        <div class="fleet-grid">
            <!-- Luxury Coach -->
            <div class="fleet-card">
                <div class="fleet-image">
                    <img src="assets/images/5.JPG" alt="Luxury Coach">
                </div>
                <div class="fleet-info">
                      <h3>General Admission</h3>
                    <div class="fleet-subtitle"><i class="fas fa-star"></i> Premium Comfort</div>
                    <div class="fleet-details">
                        <div class="fleet-amenities">
                            <span><i class="fas fa-wifi"></i> WiFi</span>
                            <span><i class="fas fa-plug"></i> Power Outlets</span>
                            <span><i class="fas fa-couch"></i> Free seating</span>
                            <span><i class="fas fa-coffee"></i> Guaranteed lively atmosphere</span>
                            <span><i class="fas fa-restroom"></i> Bathroom</span>
                        </div>
                        <div class="fleet-price">300 AED</div>
                    </div>
                    <a href="GeneralAdmission.php?type=luxury" class="fleet-btn">Book Now</a>
                </div>
            </div>
            <!-- Standard Coach -->
            <div class="fleet-card">
                <div class="fleet-image">
                    <img src="assets/images/6.JPG" alt="Standard Coach">
                </div>
                <div class="fleet-info">
                     <h3>Floor Standing</h3>
                    <div class="fleet-subtitle"><i class="fas fa-thumbs-up"></i> Great Value</div>
                    <div class="fleet-details">
                        <div class="fleet-amenities">
                           <span><i class="fas fa-wifi"></i> WiFi</span>
                            <span><i class="fas fa-plug"></i>Access to the pit in front of the stage</span>
                            <span><i class="fas fa-couch"></i> Standing room only</span>
                            <span><i class="fas fa-coffee"></i> Close to the artist</span>
                            <span><i class="fas fa-restroom"></i> Bathroom</span>
                        </div>
                        <div class="fleet-price">450 AED</div>
                    </div>
                    <a href="FloorStanding.php?type=standard" class="fleet-btn">Book Now</a>
                </div>
            </div>
            <!-- Economy Coach -->
            <div class="fleet-card">
                <div class="fleet-image">
                    <img src="assets/images/7.JPG" alt="Economy Coach">
                </div>
                <div class="fleet-info">
                    <h3>Golden Circle</h3>
                    <div class="fleet-subtitle"><i class="fas fa-leaf"></i> Budget Friendly</div>
                    <div class="fleet-details">
                        <div class="fleet-amenities">
                           <span><i class="fas fa-wifi"></i> WiFi</span>
                            <span><i class="fas fa-plug"></i>Reserved area very close to the stage</span>
                            <span><i class="fas fa-couch"></i>  Priority entry</span>
                            <span><i class="fas fa-coffee"></i> VIP atmosphere</span>
                           
                        </div>
                        <div class="fleet-price">1000 AED</div>
                    </div>
                    <a href="GoldenCircle.php?type=economy" class="fleet-btn">Book Now</a>
                </div>
            </div>
             <div class="fleet-card">
                <div class="fleet-image">
                    <img src="assets/images/8.JPG" alt="Economy Coach">
                </div>
                <div class="fleet-info">
                      <h3>VIP Seated</h3>
                    <div class="fleet-subtitle"><i class="fas fa-leaf"></i> Budget Friendly</div>
                    <div class="fleet-details">
                        <div class="fleet-amenities">
                           <span><i class="fas fa-wifi"></i> WiFi</span>
                            <span><i class="fas fa-plug"></i>Centered seats with direct view</span>
                            <span><i class="fas fa-couch"></i>  Access to VIP Lounge</span>
                            <span><i class="fas fa-coffee"></i> Souvenir gift</span>
                           
                        </div>
                        <div class="fleet-price"> 1,600 AED</div>
                    </div>
                    <a href="VIPSeated.php?type=economy" class="fleet-btn">Book Now</a>
                </div>
            </div>
             <div class="fleet-card">
                <div class="fleet-image">
                    <img src="assets/images/9.JPG" alt="Economy Coach">
                </div>
                <div class="fleet-info">
                     <h3>Meet &amp; Greet Package</h3>
                    <div class="fleet-subtitle"><i class="fas fa-leaf"></i> Budget Friendly</div>
                    <div class="fleet-details">
                        <div class="fleet-amenities">
                           <span><i class="fas fa-wifi"></i> WiFi</span>
                            <span><i class="fas fa-plug"></i>VVIP access plus meet the artist </span>
                            <span><i class="fas fa-couch"></i>   professional photo</span>
                            <span><i class="fas fa-coffee"></i> exclusive souvenir</span>
                           
                        </div>
                        <div class="fleet-price">9,000 AED</div>
                    </div>
                    <a href="Meet&Greet.php?type=economy" class="fleet-btn">Book Now</a>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- FAQ Section -->
<section class="faq-section">
    <div class="faq-title">Frequently Asked Questions</div>
    <div class="faq-item">
        <div class="faq-question">Is WiFi available on all buses? <i class="fas fa-chevron-down"></i></div>
        <div class="faq-answer">Yes, WiFi is available on all Luxury and Standard coaches.</div>
    </div>
    <div class="faq-item">
        <div class="faq-question">Can I change my seat after booking? <i class="fas fa-chevron-down"></i></div>
        <div class="faq-answer">Yes, you can change your seat up to 1 hour before departure, subject to availability.</div>
    </div>
    <div class="faq-item">
        <div class="faq-question">Do your buses have wheelchair access? <i class="fas fa-chevron-down"></i></div>
        <div class="faq-answer">Yes, selected buses have wheelchair access. Please contact us for more details and to ensure availability.</div>
    </div>
    <div class="faq-item">
        <div class="faq-question">Are refreshments provided on all routes? <i class="fas fa-chevron-down"></i></div>
        <div class="faq-answer">Complimentary refreshments are available on Luxury coaches. Standard and Economy coaches offer refreshments for purchase.</div>
    </div>
</section>

<script>
// FAQ Accordion
const faqItems = document.querySelectorAll('.faq-item');
faqItems.forEach(item => {
    item.querySelector('.faq-question').addEventListener('click', () => {
        item.classList.toggle('active');
        // Close others
        faqItems.forEach(other => {
            if (other !== item) other.classList.remove('active');
        });
    });
});
</script>

<?php include 'includes/footer.php'; ?>
</body>
</html>

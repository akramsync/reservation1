// Placeholder for future interactivity or dynamic content

// Example: Smooth scroll for CTA button (optional)
document.querySelector('.btn-cta').addEventListener('click', function(e) {
    e.preventDefault();
    document.querySelector('#booking-section').scrollIntoView({
        behavior: 'smooth'
    });
});

document.addEventListener('DOMContentLoaded', function() {
    // Animate hero content on page load
    const heroContent = document.querySelector('.hero-content');
    setTimeout(() => {
        heroContent.classList.add('animate');
    }, 300);

    // Initialize fleet tabs
    const fleetTabs = document.querySelectorAll('.fleet-tab');
    const fleetContainers = document.querySelectorAll('.fleet-container');

    fleetTabs.forEach(tab => {
        tab.addEventListener('click', () => {
            // Remove active class from all tabs
            fleetTabs.forEach(t => t.classList.remove('active'));
            // Add active class to clicked tab
            tab.classList.add('active');
            
            // Hide all fleet containers
            fleetContainers.forEach(container => {
                container.classList.remove('active');
            });
            
            // Show the corresponding container
            const targetId = tab.getAttribute('data-tab');
            document.getElementById(`${targetId}-fleet`).classList.add('active');
        });
    });

    // Testimonials carousel
    const testimonials = document.querySelectorAll('.testimonial-item');
    const dots = document.querySelectorAll('.testimonial-dot');
    let currentTestimonial = 0;
    const totalTestimonials = testimonials.length;

    // Function to show a specific testimonial
    function showTestimonial(index) {
        // Hide all testimonials
        testimonials.forEach(testimonial => {
            testimonial.classList.remove('active');
        });
        
        // Hide all active dots
        dots.forEach(dot => {
            dot.classList.remove('active');
        });
        
        // Show the selected testimonial and dot
        testimonials[index].classList.add('active');
        dots[index].classList.add('active');
    }

    // Initialize testimonial carousel
    if (totalTestimonials > 0) {
        // Add click event to dots
        dots.forEach((dot, index) => {
            dot.addEventListener('click', () => {
                currentTestimonial = index;
                showTestimonial(currentTestimonial);
                resetAutoSlide();
            });
        });
        
        // Set the first testimonial as active
        showTestimonial(0);
        
        // Auto slide functionality
        let autoSlide;
        
        function startAutoSlide() {
            autoSlide = setInterval(() => {
                currentTestimonial = (currentTestimonial + 1) % totalTestimonials;
                showTestimonial(currentTestimonial);
            }, 5000);
        }
        
        function resetAutoSlide() {
            clearInterval(autoSlide);
            startAutoSlide();
        }
        
        // Start auto sliding
        startAutoSlide();
    }

    // FAQ accordion
    const faqItems = document.querySelectorAll('.faq-item');
    
    faqItems.forEach(item => {
        const header = item.querySelector('.faq-header');
        
        header.addEventListener('click', () => {
            // Close all other items
            faqItems.forEach(otherItem => {
                if (otherItem !== item && otherItem.classList.contains('open')) {
                    otherItem.classList.remove('open');
                }
            });
            
            // Toggle current item
            item.classList.toggle('open');
        });
    });

    // Animate sections when they come into view
    const animateSections = document.querySelectorAll('.features-section, .about-section, .fleet-section, .testimonials-section, .faq-section, .cta-section');
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate');
                observer.unobserve(entry.target);
            }
        });
    }, {
        threshold: 0.15
    });

    animateSections.forEach(section => {
        observer.observe(section);
        // Add animation class for CSS targeting
        section.classList.add('animate-section');
    });

    // Form validation for booking widget
    const bookingForm = document.querySelector('.booking-form');
    if (bookingForm) {
        bookingForm.addEventListener('submit', function(e) {
            const fromSelect = document.getElementById('from');
            const toSelect = document.getElementById('to');
            
            if (fromSelect.value === toSelect.value) {
                e.preventDefault();
                alert('Origin and destination cannot be the same. Please select different locations.');
            }
        });
    }

    // Add smooth scrolling for all anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                e.preventDefault();
                target.scrollIntoView({
                    behavior: 'smooth'
                });
            }
        });
    });
});

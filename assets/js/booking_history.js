document.addEventListener('DOMContentLoaded', function() {
    const cancelButtons = document.querySelectorAll('button[name="cancel_booking"]');

    cancelButtons.forEach(button => {
        button.addEventListener('click', function(event) {
            if (!confirm('Are you sure you want to cancel this booking? This action cannot be undone.')) {
                event.preventDefault(); // Prevent form submission if the user cancels
            }
        });
    });

    // FAQ Toggle Functionality
    const faqItems = document.querySelectorAll('.faq-item');
    
    faqItems.forEach(item => {
        const question = item.querySelector('.faq-question');
        
        question.addEventListener('click', () => {
            // Close other open items
            faqItems.forEach(otherItem => {
                if (otherItem !== item && otherItem.classList.contains('active')) {
                    otherItem.classList.remove('active');
                }
            });
            
            // Toggle current item
            item.classList.toggle('active');
        });
    });
});

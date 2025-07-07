document.addEventListener('DOMContentLoaded', function() {
    const busButtons = document.querySelectorAll('.select-bus');
    const seatSection = document.querySelector('.seat-selection');
    const seatLayout = document.querySelector('.seat-layout');
    const selectedSeatsInput = document.getElementById('selected_seats');
    const fareAmount = document.getElementById('fare-amount');
    const totalFareInput = document.getElementById('total_fare');
    let selectedSeats = [];
    let seatPrices = {}; // Stores the prices of the selected seats

    busButtons.forEach(button => {
        button.addEventListener('click', function() {
            const busId = button.dataset['busId'];
            document.getElementById('bus_id').value = busId;
            loadSeats(busId);
            seatSection.classList.remove('hidden');

            // Highlight the selected bus
            busButtons.forEach(btn => btn.closest('.bus-item').classList.remove('selected-bus'));
            button.closest('.bus-item').classList.add('selected-bus');
        });
    });

    // Load seats from server and update UI
    function loadSeats(busId) {
        fetch('fetch_reserved_seats.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `bus_id=${busId}`
        })
        .then(response => response.json())
        .then(data => {
            seatLayout.innerHTML = '';
            selectedSeats = [];
            seatPrices = {}; // Reset seat prices
            updateFareAndSeats();

            for (let i = 1; i <= 30; i++) {
                const seat = document.createElement('div');
                seat.className = 'seat available';
                seat.dataset.seatId = i;

                // Fetch the seat price from the data returned from the server
                const seatPrice = data.seatPrices[i] || 20; // Fallback to 20 AUD if not found in the data
                seat.dataset.price = seatPrice; 

                seat.textContent = i; 

                if (i === 1) seat.classList.add('driver');
                if (i === 2 || i === 3) seat.classList.add('staff');
                if (data.reserved.includes(i.toString())) seat.classList.add('reserved');

                seat.addEventListener('click', function() {
                    if (!seat.classList.contains('reserved') && !seat.classList.contains('driver') && !seat.classList.contains('staff')) {
                        seat.classList.toggle('selected');
                        updateSelectedSeats(seat.dataset.seatId, seat.dataset.price);
                    }
                });

                seatLayout.appendChild(seat);
            }
        });
    }

    function updateSelectedSeats(seatId, seatPrice) {
        const index = selectedSeats.indexOf(seatId);
        if (index > -1) {
            selectedSeats.splice(index, 1);
            delete seatPrices[seatId];
        } else {
            selectedSeats.push(seatId);
            seatPrices[seatId] = parseFloat(seatPrice);
        }
        updateFareAndSeats();
    }

    function updateFareAndSeats() {
        selectedSeatsInput.value = selectedSeats.join(',');
        const totalFare = Object.values(seatPrices).reduce((acc, price) => acc + price, 0);
        fareAmount.textContent = totalFare.toFixed(2); // Display fare with two decimals
        totalFareInput.value = totalFare.toFixed(2);
    }

    document.getElementById('booking-form').addEventListener('submit', function(event) {
        if (selectedSeats.length === 0) {
            event.preventDefault();
            alert('Please select at least one seat.');
        } else if (parseFloat(totalFareInput.value) > parseFloat(document.getElementById('user-balance').textContent)) {
            event.preventDefault();
            alert('Insufficient balance. Please recharge your account.');
        }
    });
});

// Slider functionality
const slider = document.querySelector('.slider');
const slides = document.querySelectorAll('.bus-slide');
let currentSlide = 0;

// Scroll Left
document.querySelector('.slider-arrow.left').addEventListener('click', () => {
    currentSlide = Math.max(currentSlide - 1, 0);
    updateSlider();
});

// Scroll Right
document.querySelector('.slider-arrow.right').addEventListener('click', () => {
    currentSlide = Math.min(currentSlide + 1, slides.length - 1);
    updateSlider();
});

function updateSlider() {
    const offset = -currentSlide * (slides[0].offsetWidth + 20); // 20 is the margin
    slider.style.transform = `translateX(${offset}px)`;
}

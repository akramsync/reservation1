<?php
require('includes/db_connect.php');
require('includes/fpdf/fpdf.php');
session_start();

// Redirect to login page if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Fetch user ID from session
$user_id = $_SESSION['user_id'];

// Handle cancellation request
if (isset($_POST['cancel_booking'])) {
    $booking_id = $_POST['booking_id'];
    
    // Fetch the booking details
    $query = "SELECT seat_numbers, bus_id FROM bookings WHERE id = '$booking_id' AND user_id = '$user_id'";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        $booking = $result->fetch_assoc();
        $seat_numbers = explode(',', $booking['seat_numbers']);
        $bus_id = $booking['bus_id'];

        // Update the seats as available in the database
        foreach ($seat_numbers as $seat_number) {
            $update_query = "UPDATE seats SET status = 'available' WHERE bus_id = '$bus_id' AND seat_number = '$seat_number'";
            $conn->query($update_query);
        }

        // Delete the booking record
        $delete_query = "DELETE FROM bookings WHERE id = '$booking_id'";
        $conn->query($delete_query);

        echo "<script>alert('Booking canceled successfully!');</script>";
    }
}

// Fetch booking history for the logged-in user
$query = "SELECT b.id, b.bus_id, b.seat_numbers, b.booking_time, b.status, 
          u.username, u.email, r.route_name, bu.bus_number, bu.date, bu.time,
          (SELECT price FROM seats s WHERE s.bus_id = b.bus_id AND FIND_IN_SET(s.seat_number, b.seat_numbers) LIMIT 1) as seat_price,
          (SELECT SUM(s.price) FROM seats s WHERE s.bus_id = b.bus_id AND FIND_IN_SET(s.seat_number, b.seat_numbers)) as total_price
          FROM bookings b
          JOIN users u ON b.user_id = u.id
          JOIN buses bu ON b.bus_id = bu.id
          JOIN routes r ON bu.route_id = r.id
          WHERE b.user_id = '$user_id'";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking History -  GOBus</title>
    <link rel="stylesheet" href="assets/css/booking_history.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>
    <main>
    <h2>My Booking History</h2>
    <div class="table-responsive">
        <?php if ($result->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Booking ID</th>
                        <th>Route</th>
                        <th>Bus Number</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Seat Numbers</th>
                        <th>Price/Seat</th>
                        <th>Total Price</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($booking = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $booking['id']; ?></td>
                            <td><?php echo $booking['route_name']; ?></td>
                            <td><?php echo $booking['bus_number']; ?></td>
                            <td><?php echo $booking['date']; ?></td>
                            <td><?php echo $booking['time']; ?></td>
                            <td><?php echo $booking['seat_numbers']; ?></td>
                            <td>$<?php echo number_format($booking['seat_price'], 2); ?></td>
                            <td>$<?php echo number_format($booking['total_price'], 2); ?></td>
                            <td><?php echo ucfirst($booking['status']); ?></td>
                            <td class="actions">
                                <form method="POST" style="display:inline;">
                                    <input type="hidden" name="booking_id" value="<?php echo $booking['id']; ?>">
                                    <button type="submit" name="cancel_booking" class="btn-cancel" onclick="return confirm('Are you sure you want to cancel this booking?');"><span class="btn-text">Cancel Booking</span><span class="btn-text-short">Cancel Booking</span></button>
                                </form>
                                <form method="POST" action="generate_booking_pdf.php" style="display:inline;">
                                    <input type="hidden" name="booking_id" value="<?php echo $booking['id']; ?>">
                                    <button type="submit" name="download_booking" class="btn-download"><span class="btn-text">Download Ticket</span><span class="btn-text-short">Download Ticket</span></button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>You have no bookings yet.</p>
        <?php endif; ?>
    </div>
</main>

<!-- Booking Tips Section -->
<section class="booking-tips">
    <h3>Booking Tips</h3>
    <div class="tips-container">
        <div class="tip-card">
            <i class="fas fa-clock"></i>
            <h4>Book in Advance</h4>
            <p>Reserve your seats at least 24 hours before departure to ensure availability and better rates.</p>
        </div>
        <div class="tip-card">
            <i class="fas fa-wallet"></i>
            <h4>Keep Balance Ready</h4>
            <p>Maintain sufficient balance in your account to avoid last-minute booking issues.</p>
        </div>
        <div class="tip-card">
            <i class="fas fa-calendar-check"></i>
            <h4>Check Schedule</h4>
            <p>Verify bus timings and routes before booking to plan your journey better.</p>
        </div>
        <div class="tip-card">
            <i class="fas fa-ticket-alt"></i>
            <h4>Download E-Ticket</h4>
            <p>Always download and save your e-ticket after booking for hassle-free travel.</p>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="faq-section">
    <h3>Frequently Asked Questions</h3>
    <div class="faq-container">
        <div class="faq-item">
            <div class="faq-question">
                <h4>How can I cancel my booking?</h4>
                <i class="fas fa-chevron-down"></i>
            </div>
            <div class="faq-answer">
                <p>You can cancel your booking by clicking the 'Cancel' button next to your booking in the booking history. Cancellations are allowed up to 2 hours before departure.</p>
            </div>
        </div>
        <div class="faq-item">
            <div class="faq-question">
                <h4>How do I download my ticket?</h4>
                <i class="fas fa-chevron-down"></i>
            </div>
            <div class="faq-answer">
                <p>Simply click the 'Download' button next to your booking to get your e-ticket in PDF format. Make sure to keep it handy during travel.</p>
            </div>
        </div>
        <div class="faq-item">
            <div class="faq-question">
                <h4>What happens if I miss my bus?</h4>
                <i class="fas fa-chevron-down"></i>
            </div>
            <div class="faq-answer">
                <p>If you miss your bus, the ticket becomes invalid. We recommend arriving at least 15 minutes before departure time.</p>
            </div>
        </div>
        <div class="faq-item">
            <div class="faq-question">
                <h4>Can I modify my seat selection?</h4>
                <i class="fas fa-chevron-down"></i>
            </div>
            <div class="faq-answer">
                <p>To change your seat, you'll need to cancel your current booking and make a new one with your preferred seat selection.</p>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>

<!-- Add Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<!-- Add JavaScript for FAQ functionality -->
<script src="assets/js/booking_history.js"></script>

</body>
</html>
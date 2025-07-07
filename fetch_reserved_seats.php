<?php
include 'includes/db_connect.php';

if (isset($_POST['bus_id'])) {
    $bus_id = $_POST['bus_id'];

    // Fetch reserved seats and their prices for the selected bus
    $booked_seats = [];
    $seat_prices = [];
    
    $seat_query = "SELECT seat_number, price, status FROM seats WHERE bus_id = '$bus_id'";
    $seat_result = $conn->query($seat_query);
    
    while ($row = $seat_result->fetch_assoc()) {
        $seat_number = $row['seat_number'];
        $seat_prices[$seat_number] = $row['price']; // Store seat prices
        if ($row['status'] == 'reserved') {
            $booked_seats[] = $seat_number; // Store reserved seats
        }
    }

    // Return the reserved seats and seat prices as a JSON response
    echo json_encode([
        'reserved' => $booked_seats,
        'seatPrices' => $seat_prices
    ]);
}
?>

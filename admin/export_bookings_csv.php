<?php
include '../includes/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $start_date = $_POST['start_date'] ?? null;
    $end_date = $_POST['end_date'] ?? null;
    $user_id = $_POST['user_id'] ?? null;

    // Create the CSV file
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=bookings_report.csv');
    
    $output = fopen('php://output', 'w');
    fputcsv($output, ['Booking ID', 'User ID', 'Bus ID', 'Seat Numbers', 'Seat Price (AUD)', 'Booking Time', 'Status']);

    // Query to fetch bookings
    $query = "SELECT * FROM bookings WHERE 1=1";
    if ($start_date && $end_date) {
        $query .= " AND DATE(booking_time) BETWEEN '$start_date' AND '$end_date'";
    }
    if ($user_id) {
        $query .= " AND user_id = '$user_id'";
    }
    $query .= " ORDER BY booking_time DESC";
    
    $result = $conn->query($query);

    while ($row = $result->fetch_assoc()) {
        fputcsv($output, [$row['id'], $row['user_id'], $row['bus_id'], $row['seat_numbers'], $row['seat_price'], $row['booking_time'], ucfirst($row['status'])]);
    }

    fclose($output);
}
exit();

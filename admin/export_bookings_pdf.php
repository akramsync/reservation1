<?php
require('../includes/ReportTemplate.php');
include '../includes/db_connect.php';
session_start();

if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php');
    exit();
}

// Get filter parameters from POST (since they're submitted via form)
$start_date = $_POST['start_date'] ?? null;
$end_date = $_POST['end_date'] ?? null;
$user_id = $_POST['user_id'] ?? null;

// Validate date inputs
if (!$start_date || !$end_date) {
    die('Please select both start and end dates');
}

// Prepare filter data for the report
$filters = [];
$filters['Date Range'] = date('Y-m-d', strtotime($start_date)) . ' to ' . date('Y-m-d', strtotime($end_date));
if ($user_id) {
    // Get username for the filter display
    $user_query = "SELECT username FROM users WHERE id = ?";
    $stmt = $conn->prepare($user_query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $user_result = $stmt->get_result();
    if ($user = $user_result->fetch_assoc()) {
        $filters['User'] = $user['username'] . ' (ID: ' . $user_id . ')';
    }
}

// Build the query with prepared statements
$query = "SELECT b.*, u.username, r.route_name, bu.bus_number 
          FROM bookings b 
          LEFT JOIN users u ON b.user_id = u.id
          LEFT JOIN buses bu ON b.bus_id = bu.id
          LEFT JOIN routes r ON bu.route_id = r.id
          WHERE DATE(b.booking_time) BETWEEN ? AND ?";

$params = [$start_date, $end_date];
$types = "ss";

if ($user_id) {
    $query .= " AND b.user_id = ?";
    $params[] = $user_id;
    $types .= "i";
}

$query .= " ORDER BY b.booking_time DESC";

// Prepare and execute the query
$stmt = $conn->prepare($query);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();

// Initialize PDF with the new template
$pdf = new ReportTemplate('L', 'mm', 'A4', 'Booking History Report', 'bookings', $filters);
$pdf->AliasNbPages();
$pdf->AddPage();

// Define table headers and their widths
$headers = array('Booking ID', 'User', 'Bus No.', 'Route', 'Seats', 'Price (AUD)', 'Date & Time', 'Status');
$widths = array(25, 40, 25, 45, 30, 30, 40, 30);

// Add table headers
$pdf->TableHeader($headers, $widths);

// Initialize summary data
$total_amount = 0;
$total_seats = 0;
$status_counts = array('confirmed' => 0, 'cancelled' => 0, 'pending' => 0);
$route_stats = array();
$row_count = 0;

// Add table rows
while ($row = $result->fetch_assoc()) {
    $fill = $row_count % 2 == 0;
    
    // Format data
    $data = array(
        $row['id'],
        $row['username'] ?? 'N/A',
        $row['bus_number'],
        $row['route_name'],
        $row['seat_numbers'],
        '$ ' . number_format($row['seat_price'], 2),
        date('d M Y, H:i', strtotime($row['booking_time'])),
        ucfirst($row['status'])
    );
    
    $pdf->TableRow($data, $widths, $fill);
    
    // Update summary data
    $total_amount += $row['seat_price'];
    $seats_count = count(explode(',', $row['seat_numbers']));
    $total_seats += $seats_count;
    $status_counts[strtolower($row['status'])]++;
    
    // Track route statistics
    $route = $row['route_name'];
    if (!isset($route_stats[$route])) {
        $route_stats[$route] = 0;
    }
    $route_stats[$route]++;
    
    $row_count++;
}

// Add summary section
$summaryData = array(
    'Total Bookings' => $row_count,
    'Total Revenue' => '$ ' . number_format($total_amount, 2),
    'Total Seats Booked' => $total_seats,
    'Average Booking Value' => '$ ' . number_format($total_amount / ($row_count ?: 1), 2),
    'Confirmed Bookings' => $status_counts['confirmed'],
    'Cancelled Bookings' => $status_counts['cancelled'],
    'Pending Bookings' => $status_counts['pending']
);

// Add route statistics if we have data
if (!empty($route_stats)) {
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->Cell(0, 10, 'Route Statistics', 0, 1, 'L');
    $pdf->Ln(5);
    
    // Create route statistics table
    $pdf->SetFont('Arial', 'B', 11);
    $pdf->SetFillColor(0, 64, 128);
    $pdf->SetTextColor(255);
    $pdf->Cell(100, 8, 'Route Name', 1, 0, 'C', true);
    $pdf->Cell(40, 8, 'Bookings', 1, 1, 'C', true);
    
    $pdf->SetTextColor(0);
    $pdf->SetFont('Arial', '', 10);
    
    foreach ($route_stats as $route => $count) {
        $fill = !$fill;
        $pdf->SetFillColor(245, 245, 245);
        $pdf->Cell(100, 8, $route, 1, 0, 'L', $fill);
        $pdf->Cell(40, 8, $count, 1, 1, 'C', $fill);
    }
}

// Add the main summary before outputting
$pdf->AddSummary($summaryData);

// Output the PDF
$pdf->Output('D', 'booking_history_' . date('Y-m-d') . '.pdf');

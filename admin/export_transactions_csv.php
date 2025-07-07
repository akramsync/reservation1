<?php
include '../includes/db_connect.php';
session_start();

if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php');
    exit();
}

// Get filter parameters
$start_date = $_POST['start_date'] ?? date('Y-m-d', strtotime('-30 days')); // Default to last 30 days
$end_date = $_POST['end_date'] ?? date('Y-m-d'); // Default to today
$status_filter = $_POST['status'] ?? 'all';
$sort_order = $_POST['sort_order'] ?? 'DESC';

// Build the query with prepared statements
$query = "SELECT t.*, u.username 
          FROM transactions t 
          LEFT JOIN users u ON t.user_id = u.id 
          WHERE DATE(t.transaction_date) BETWEEN ? AND ?";

$params = [$start_date, $end_date];
$types = "ss";

if ($status_filter !== 'all') {
    $query .= " AND t.status = ?";
    $params[] = $status_filter;
    $types .= "s";
}

$query .= " ORDER BY t.transaction_date " . $sort_order;

// Prepare and execute the query
$stmt = $conn->prepare($query);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();

// Set headers for CSV download
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="transaction_history_' . date('Y-m-d') . '.csv"');

// Create a file pointer connected to the output stream
$output = fopen('php://output', 'w');

// Add UTF-8 BOM for proper Excel display
fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));

// Output the column headings
fputcsv($output, array('Transaction ID', 'User', 'Amount (AUD)', 'Date & Time', 'Status'));

// Output each row of the data
while ($row = $result->fetch_assoc()) {
    fputcsv($output, array(
        $row['id'],
        $row['username'] ?? 'N/A',
        number_format($row['amount'], 2),
        date('d M Y, H:i', strtotime($row['transaction_date'])),
        ucfirst($row['status'])
    ));
}

// Close the file pointer
fclose($output);
exit();
?>

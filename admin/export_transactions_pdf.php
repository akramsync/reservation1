<?php
require('../includes/ReportTemplate.php');
include '../includes/db_connect.php';
session_start();

if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php');
    exit();
}

// Get filter parameters from POST
$start_date = $_POST['start_date'] ?? date('Y-m-d', strtotime('-30 days')); // Default to last 30 days
$end_date = $_POST['end_date'] ?? date('Y-m-d'); // Default to today
$status_filter = $_POST['status'] ?? 'all';
$sort_order = $_POST['sort_order'] ?? 'DESC';

// Prepare filter data for the report
$filters = [];
$filters['Date Range'] = date('Y-m-d', strtotime($start_date)) . ' to ' . date('Y-m-d', strtotime($end_date));
$filters['Status'] = ucfirst($status_filter);
$filters['Sort Order'] = $sort_order === 'DESC' ? 'Newest First' : 'Oldest First';

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

// Initialize PDF with the new template
$pdf = new ReportTemplate('L', 'mm', 'A4', 'Transaction History Report', 'transactions', $filters);
$pdf->AliasNbPages();
$pdf->AddPage();

// Define table headers and their widths
$headers = array('Trans. ID', 'User', 'Amount (AUD)', 'Date & Time', 'Status');
$widths = array(25, 50, 45, 55, 35);

// Add table headers
$pdf->TableHeader($headers, $widths);

// Initialize summary data
$total_amount = 0;
$status_counts = array('completed' => 0, 'failed' => 0, 'pending' => 0);
$row_count = 0;

// Add table rows
while ($row = $result->fetch_assoc()) {
    $fill = $row_count % 2 == 0;
    
    // Format data
    $data = array(
        $row['id'],
        $row['username'] ?? 'N/A',
        '$ ' . number_format($row['amount'], 2),
        date('d M Y, H:i', strtotime($row['transaction_date'])),
        ucfirst($row['status'])
    );
    
    $pdf->TableRow($data, $widths, $fill);
    
    // Update summary data
    $total_amount += $row['amount'];
    $status_counts[strtolower($row['status'])]++;
    $row_count++;
}

// Add summary section
$summaryData = array(
    'Total Transactions' => $row_count,
    'Total Amount' => '$ ' . number_format($total_amount, 2),
    'Completed Transactions' => $status_counts['completed'],
    'Failed Transactions' => $status_counts['failed'],
    'Pending Transactions' => $status_counts['pending'],
    'Average Transaction Amount' => '$ ' . number_format($total_amount / ($row_count ?: 1), 2)
);

$pdf->AddSummary($summaryData);

// Output the PDF
$pdf->Output('D', 'transaction_history_' . date('Y-m-d') . '.pdf');
?>

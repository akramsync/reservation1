<?php
session_start();
include '../includes/db_connect.php';
include '../includes/admin_functions.php';

check_admin_logged_in(); // Ensure admin is logged in

// Initialize variables
$report_type = $_POST['report_type'] ?? 'transactions'; // Default to transactions
$start_date = $_POST['start_date'] ?? '';
$end_date = $_POST['end_date'] ?? '';
$user_id = $_POST['user_id'] ?? '';
$filtered_data = [];

// Fetch data only if the form is submitted with date filters
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $start_date && $end_date) {
    if ($report_type === 'transactions') {
        $query = "SELECT t.*, u.username 
                 FROM transactions t 
                 LEFT JOIN users u ON t.user_id = u.id 
                 WHERE 1=1";
        
        if ($start_date && $end_date) {
            $query .= " AND DATE(t.transaction_date) BETWEEN ? AND ?";
        }
        if ($user_id) {
            $query .= " AND t.user_id = ?";
        }
        $query .= " ORDER BY t.transaction_date DESC";
    } elseif ($report_type === 'bookings') {
        $query = "SELECT b.*, u.username, r.route_name, bu.bus_number 
                 FROM bookings b 
                 LEFT JOIN users u ON b.user_id = u.id
                 LEFT JOIN buses bu ON b.bus_id = bu.id
                 LEFT JOIN routes r ON bu.route_id = r.id 
                 WHERE 1=1";
        
        if ($start_date && $end_date) {
            $query .= " AND DATE(b.booking_time) BETWEEN ? AND ?";
        }
        if ($user_id) {
            $query .= " AND b.user_id = ?";
        }
        $query .= " ORDER BY b.booking_time DESC";
    }

    // Prepare and execute the query with parameters
    $stmt = $conn->prepare($query);
    if ($user_id) {
        $stmt->bind_param("ssi", $start_date, $end_date, $user_id);
    } else {
        $stmt->bind_param("ss", $start_date, $end_date);
    }
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $filtered_data[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Reports</title>
    <link rel="stylesheet" href="../assets/css/view_reports.css">
</head>
<body>
<?php include '../includes/admin_header.php'; ?>

<h2>View Reports</h2>

<form action="view_reports.php" method="POST" class="filter-form">
    <div class="form-group">
        <label for="report_type">Report Type:</label>
        <select id="report_type" name="report_type" onchange="this.form.submit()">
            <option value="transactions" <?php echo $report_type === 'transactions' ? 'selected' : ''; ?>>Transactions</option>
            <option value="bookings" <?php echo $report_type === 'bookings' ? 'selected' : ''; ?>>Bookings</option>
        </select>
    </div>
    <div class="form-group">
        <label for="start_date">Start Date:</label>
        <input type="date" id="start_date" name="start_date" value="<?php echo htmlspecialchars($start_date); ?>" required>
    </div>
    <div class="form-group">
        <label for="end_date">End Date:</label>
        <input type="date" id="end_date" name="end_date" value="<?php echo htmlspecialchars($end_date); ?>" required>
    </div>
    <div class="form-group">
        <label for="user_id">User ID (Optional):</label>
        <input type="text" id="user_id" name="user_id" value="<?php echo htmlspecialchars($user_id); ?>" placeholder="Leave blank for all users">
    </div>
    <button type="submit">Filter</button>
</form>

<?php if (!empty($filtered_data)): ?>
    <div class="data-table-container">
        <div class="table-scroll">
            <table class="data-table">
                <thead>
                    <?php if ($report_type === 'transactions'): ?>
                        <tr>
                            <th>Transaction ID</th>
                            <th>User ID</th>
                            <th>Username</th>
                            <th>Amount (AUD)</th>
                            <th>Date & Time</th>
                            <th>Status</th>
                        </tr>
                    <?php elseif ($report_type === 'bookings'): ?>
                        <tr>
                            <th>Booking ID</th>
                            <th>User</th>
                            <th>Bus No.</th>
                            <th>Route</th>
                            <th>Seats</th>
                            <th>Price (AUD)</th>
                            <th>Date & Time</th>
                            <th>Status</th>
                        </tr>
                    <?php endif; ?>
                </thead>
                <tbody>
                    <?php foreach ($filtered_data as $row): ?>
                        <?php if ($report_type === 'transactions'): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['id']); ?></td>
                                <td><?php echo htmlspecialchars($row['user_id']); ?></td>
                                <td><?php echo htmlspecialchars($row['username'] ?? 'N/A'); ?></td>
                                <td><?php echo number_format($row['amount'], 2); ?></td>
                                <td><?php echo date('d M Y, H:i', strtotime($row['transaction_date'])); ?></td>
                                <td><?php echo ucfirst(htmlspecialchars($row['status'])); ?></td>
                            </tr>
                        <?php elseif ($report_type === 'bookings'): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['id']); ?></td>
                                <td><?php echo htmlspecialchars($row['username'] ?? 'N/A'); ?></td>
                                <td><?php echo htmlspecialchars($row['bus_number']); ?></td>
                                <td><?php echo htmlspecialchars($row['route_name']); ?></td>
                                <td><?php echo htmlspecialchars($row['seat_numbers']); ?></td>
                                <td><?php echo number_format($row['seat_price'], 2); ?></td>
                                <td><?php echo date('d M Y, H:i', strtotime($row['booking_time'])); ?></td>
                                <td><?php echo ucfirst(htmlspecialchars($row['status'])); ?></td>
                            </tr>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="export-section">
        <?php if ($report_type === 'transactions'): ?>
            <form action="export_transactions_pdf.php" method="POST">
                <input type="hidden" name="start_date" value="<?php echo htmlspecialchars($start_date); ?>">
                <input type="hidden" name="end_date" value="<?php echo htmlspecialchars($end_date); ?>">
                <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user_id); ?>">
                <button type="submit" class="export-btn">
                    <img src="../assets/images/icons/file-pdf.svg" alt="PDF">
                    Export as PDF
                </button>
            </form>

            <form action="export_transactions_csv.php" method="POST">
                <input type="hidden" name="start_date" value="<?php echo htmlspecialchars($start_date); ?>">
                <input type="hidden" name="end_date" value="<?php echo htmlspecialchars($end_date); ?>">
                <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user_id); ?>">
                <button type="submit" class="export-btn">
                    <img src="../assets/images/icons/file-csv.svg" alt="CSV">
                    Export as CSV
                </button>
            </form>
        <?php elseif ($report_type === 'bookings'): ?>
            <form action="export_bookings_pdf.php" method="POST">
                <input type="hidden" name="start_date" value="<?php echo htmlspecialchars($start_date); ?>">
                <input type="hidden" name="end_date" value="<?php echo htmlspecialchars($end_date); ?>">
                <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user_id); ?>">
                <button type="submit" class="export-btn">
                    <img src="../assets/images/icons/file-pdf.svg" alt="PDF">
                    Export as PDF
                </button>
            </form>

            <form action="export_bookings_csv.php" method="POST">
                <input type="hidden" name="start_date" value="<?php echo htmlspecialchars($start_date); ?>">
                <input type="hidden" name="end_date" value="<?php echo htmlspecialchars($end_date); ?>">
                <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user_id); ?>">
                <button type="submit" class="export-btn">
                    <img src="../assets/images/icons/file-csv.svg" alt="CSV">
                    Export as CSV
                </button>
            </form>
        <?php endif; ?>
    </div>
<?php elseif ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
    <p>No data found for the selected criteria.</p>
<?php endif; ?>

<?php include '../includes/admin_footer.php'; ?>
</body>
</html>

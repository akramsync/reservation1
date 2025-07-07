<?php
include '../includes/db_connect.php';
session_start();

if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php');  // Redirect to admin login if not logged in
    exit();
}

$user_id = $_SESSION['admin_id'];

// Handle search and filters
$start_date = $_POST['start_date'] ?? date('Y-m-d', strtotime('-30 days')); // Default to last 30 days
$end_date = $_POST['end_date'] ?? date('Y-m-d'); // Default to today
$status_filter = $_POST['status'] ?? 'all';
$sort_order = $_POST['sort_order'] ?? 'DESC';
$transactions = [];

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

while ($row = $result->fetch_assoc()) {
    $transactions[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction History - GOBus</title>
    <link rel="stylesheet" href="../assets/css/transaction_history.css">
</head>
<body>
    <?php include '../includes/admin_header.php'; ?>

    <main>
        <h2>Transaction History</h2>

        <form action="transaction_history.php" method="POST" class="filter-form">
            <div class="form-group">
                <label for="start_date">Start Date:</label>
                <input type="date" id="start_date" name="start_date" value="<?php echo htmlspecialchars($start_date); ?>">
            </div>
            <div class="form-group">
                <label for="end_date">End Date:</label>
                <input type="date" id="end_date" name="end_date" value="<?php echo htmlspecialchars($end_date); ?>">
            </div>
            <div class="form-group">
                <label for="status">Status:</label>
                <select id="status" name="status">
                    <option value="all" <?php echo $status_filter === 'all' ? 'selected' : ''; ?>>All</option>
                    <option value="completed" <?php echo $status_filter === 'completed' ? 'selected' : ''; ?>>Completed</option>
                    <option value="failed" <?php echo $status_filter === 'failed' ? 'selected' : ''; ?>>Failed</option>
                </select>
            </div>
            <div class="form-group">
                <label for="sort_order">Sort by:</label>
                <select id="sort_order" name="sort_order">
                    <option value="DESC" <?php echo $sort_order === 'DESC' ? 'selected' : ''; ?>>Newest First</option>
                    <option value="ASC" <?php echo $sort_order === 'ASC' ? 'selected' : ''; ?>>Oldest First</option>
                </select>
            </div>
            <button type="submit" class="export-btn">Search</button>
        </form>

        <div class="transaction-table">
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>Transaction ID</th>
                            <th>User</th>
                            <th>Amount (AUD)</th>
                            <th>Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($transactions)): ?>
                            <tr>
                                <td colspan="5">No transactions found.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($transactions as $transaction): ?>
                                <tr>
                                    <td><?php echo $transaction['id']; ?></td>
                                    <td><?php echo htmlspecialchars($transaction['username'] ?? 'N/A'); ?></td>
                                    <td><?php echo number_format($transaction['amount'], 2); ?> AUD</td>
                                    <td><?php echo date('d M Y, H:i', strtotime($transaction['transaction_date'])); ?></td>
                                    <td><?php echo ucfirst($transaction['status']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="export-section">
            <form action="export_transactions_pdf.php" method="POST" style="display: inline;">
                <input type="hidden" name="start_date" value="<?php echo htmlspecialchars($start_date); ?>">
                <input type="hidden" name="end_date" value="<?php echo htmlspecialchars($end_date); ?>">
                <input type="hidden" name="status" value="<?php echo htmlspecialchars($status_filter); ?>">
                <input type="hidden" name="sort_order" value="<?php echo htmlspecialchars($sort_order); ?>">
                <button type="submit" class="export-btn">Export as PDF</button>
            </form>

            <form action="export_transactions_csv.php" method="POST" style="display: inline;">
                <input type="hidden" name="start_date" value="<?php echo htmlspecialchars($start_date); ?>">
                <input type="hidden" name="end_date" value="<?php echo htmlspecialchars($end_date); ?>">
                <input type="hidden" name="status" value="<?php echo htmlspecialchars($status_filter); ?>">
                <input type="hidden" name="sort_order" value="<?php echo htmlspecialchars($sort_order); ?>">
                <button type="submit" class="export-btn">Export as CSV</button>
            </form>
        </div>
    </main>

    <?php include '../includes/admin_footer.php'; ?>
</body>
</html>

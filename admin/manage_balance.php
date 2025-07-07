<?php
session_start();
include '../includes/db_connect.php';
include '../includes/admin_functions.php';

check_admin_logged_in(); // Ensure admin is logged in

// Get the total amount received this month
$this_month_query = "SELECT SUM(amount) AS total_this_month 
                     FROM transactions 
                     WHERE MONTH(transaction_date) = MONTH(CURRENT_DATE()) 
                     AND YEAR(transaction_date) = YEAR(CURRENT_DATE())";
$this_month_result = $conn->query($this_month_query);
if (!$this_month_result) {
    die("Error fetching this month's transactions: " . $conn->error);
}
$this_month_total = $this_month_result->fetch_assoc()['total_this_month'] ?? 0;

// Get today's total amount
$today_query = "SELECT SUM(amount) AS total_today 
                FROM transactions 
                WHERE DATE(transaction_date) = CURDATE()";
$today_result = $conn->query($today_query);
if (!$today_result) {
    die("Error fetching today's transactions: " . $conn->error);
}
$today_total = $today_result->fetch_assoc()['total_today'] ?? 0;

// Handle search by date range
$start_date = $_POST['start_date'] ?? null;
$end_date = $_POST['end_date'] ?? null;
$filtered_transactions = [];

if (isset($_POST['search_transactions']) && $start_date && $end_date) {
    // Make sure dates are properly formatted for the query
    $history_query = "SELECT * FROM transactions 
                      WHERE DATE(transaction_date) BETWEEN '$start_date' AND '$end_date'
                      ORDER BY transaction_date DESC";
    $history_result = $conn->query($history_query);
    if (!$history_result) {
        die("Error fetching transaction history: " . $conn->error);
    }
    while ($row = $history_result->fetch_assoc()) {
        $filtered_transactions[] = $row;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Balance - Admin Dashboard</title>
    <link rel="stylesheet" href="../assets/css/manage_balance.css">
</head>
<body>
<?php include '../includes/admin_header.php'; ?>

    <div class="container">
        <h2>Manage Balance</h2>

        <!-- Display total amount this month and today's amount in cards -->
        <div class="balance-cards">
            <div class="card">
                <h3>Total Amount Received This Month</h3>
                <p><?php echo number_format($this_month_total, 2); ?> AUD</p>
            </div>
            <div class="card">
                <h3>Total Amount Received Today</h3>
                <p><?php echo number_format($today_total, 2); ?> AUD</p>
            </div>
        </div>

        <!-- Search Transaction History by Date Range -->
        <h3>Search Transaction History</h3>
        <form action="manage_balance.php" method="POST" class="search-form">
            <div class="form-group">
                <label for="start_date">Start Date:</label>
                <input type="date" id="start_date" name="start_date" required>
            </div>
            <div class="form-group">
                <label for="end_date">End Date:</label>
                <input type="date" id="end_date" name="end_date" required>
            </div>
            <button type="submit" name="search_transactions">Search</button>
        </form>

        <!-- Display filtered transactions -->
        <?php if (!empty($filtered_transactions)): ?>
            <h3>Transaction History</h3>
            <table class="history-table">
                <thead>
                    <tr>
                        <th>User ID</th>
                        <th>Amount (AUD)</th>
                        <th>Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($filtered_transactions as $transaction): ?>
                        <tr>
                            <td><?php echo $transaction['user_id']; ?></td>
                            <td><?php echo number_format($transaction['amount'], 2); ?></td>
                            <td><?php echo date('d M Y, H:i', strtotime($transaction['transaction_date'])); ?></td>
                            <td><?php echo ucfirst($transaction['status']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>

    </div>
    <?php include '../includes/admin_footer.php'; ?>

</body>
</html>

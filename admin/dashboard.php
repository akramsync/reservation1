<?php
session_start();
include '../includes/db_connect.php';
include '../includes/admin_functions.php';

check_admin_logged_in();

// Fetching the total counts from the database
$total_buses_query = "SELECT COUNT(*) AS total_buses FROM buses";
$total_buses_result = $conn->query($total_buses_query);
$total_buses = $total_buses_result->fetch_assoc()['total_buses'];

$total_routes_query = "SELECT COUNT(*) AS total_routes FROM routes";
$total_routes_result = $conn->query($total_routes_query);
$total_routes = $total_routes_result->fetch_assoc()['total_routes'];

$total_users_query = "SELECT COUNT(*) AS total_users FROM users";
$total_users_result = $conn->query($total_users_query);
$total_users = $total_users_result->fetch_assoc()['total_users'];

$total_transactions_query = "SELECT COUNT(*) AS total_transactions FROM bookings";
$total_transactions_result = $conn->query($total_transactions_query);
$total_transactions = $total_transactions_result->fetch_assoc()['total_transactions'];

// Fetching recent notifications
$notifications_query = "SELECT * FROM notifications ORDER BY created_at DESC LIMIT 5";
$notifications_result = $conn->query($notifications_query);

$notifications = [];
if ($notifications_result) {
    while ($row = $notifications_result->fetch_assoc()) {
        $notifications[] = $row;
    }
} else {
    die("Query failed: " . $conn->error);
}

// Output the notifications (optional)
foreach ($notifications as $notification) {
    echo "Notification: " . $notification['message'] . "<br>";
}


// Fetching total booking amount
$total_booking_amount_query = "SELECT SUM(
    (SELECT SUM(s.price) 
     FROM seats s 
     WHERE s.bus_id = b.bus_id 
     AND FIND_IN_SET(s.seat_number, b.seat_numbers)
    )
) AS total_amount
FROM bookings b
WHERE b.status = 'confirmed'";
$total_booking_amount_result = $conn->query($total_booking_amount_query);
$total_booking_amount = $total_booking_amount_result->fetch_assoc()['total_amount'] ?? 0;

// Fetching booking trends for the graph
$booking_trend_query = "SELECT DATE(booking_time) AS booking_date, COUNT(*) AS booking_count FROM bookings GROUP BY booking_date ORDER BY booking_date ASC";
$booking_trend_result = $conn->query($booking_trend_query);
$booking_dates = [];
$booking_counts = [];
while ($row = $booking_trend_result->fetch_assoc()) {
    $booking_dates[] = $row['booking_date'];
    $booking_counts[] = $row['booking_count'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard GOBus Booking System</title>
    <link rel="stylesheet" href="../assets/css/admin_dashboard.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!-- Chart.js for charts -->
</head>
<body>
<?php include '../includes/mobile_header.php'; ?>
    <div class="admin-container">
        <!-- Sidebar with Hamburger Menu -->
       <div class="sidebar" id="sidebar">
    <div class="logo-container">
        <!-- Placeholder for Logo -->
        <img src="../assets/images/logo.png" alt="Logo" class="logo">
        <h2>Admin Menu</h2>
    </div>
    <ul>
        <li><a href="dashboard.php">Dashboard</a></li>
        <li><a href="manage_buses.php">Manage Buses</a></li>
        <li><a href="manage_routes.php">Manage Routes</a></li>
        <li><a href="manage_users.php">Manage Users</a></li>
        <li><a href="manage_balance.php">Balance</a></li>
        <li><a href="manage_bookings.php">Manage Booking</a></li>
        <li><a href="view_reports.php">Reports</a></li>
        <li><a href="transaction_history.php">View Transactions</a></li>
        <li><a href="admin_logout.php">Logout</a></li>
    </ul>
    <div class="hamburger" id="hamburger">&#9776;</div> <!-- Hamburger icon for mobile -->
</div>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Thin Header -->
            <header class="admin-header">
                <h1>GOBus Booking System</h1>
            </header>

            <!-- Dashboard Cards -->
            <div class="dashboard">
                <h2>Dashboard</h2>
                <div class="dashboard-summary">
                    <div class="card">
                        <h3>Total Buses</h3>
                        <p><?php echo $total_buses; ?></p>
                    </div>
                    <div class="card">
                        <h3>Total Routes</h3>
                        <p><?php echo $total_routes; ?></p>
                    </div>
                    <div class="card">
                        <h3>Total Users</h3>
                        <p><?php echo $total_users; ?></p>
                    </div>
                    <div class="card">
                        <h3>Total Transactions</h3>
                        <p><?php echo $total_transactions; ?></p>
                    </div>
                    <div class="card">
                        <h3>Total Booking Amount</h3>
                        <p><?php echo number_format($total_booking_amount, 2); ?> AUD</p>
                    </div>
                </div>

              

                <!-- Charts Section -->
                <div class="charts">
                    <h3>Booking Trends</h3>
                    <canvas id="bookingChart" width="400" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Toggle Sidebar for mobile
        document.getElementById('hamburger').addEventListener('click', function() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('open');
        });

        // Chart.js Booking Trends
        const ctx = document.getElementById('bookingChart').getContext('2d');
        const bookingChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: <?php echo json_encode($booking_dates); ?>, // Dates from PHP
                datasets: [{
                    label: 'Bookings',
                    data: <?php echo json_encode($booking_counts); ?>, // Booking counts from PHP
                    borderColor: 'rgba(0, 128, 255, 1)',
                    backgroundColor: 'rgba(0, 128, 255, 0.2)',
                    fill: true
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
    
</body>

</html>


<?php
session_start();  // Start the session

// Include database connection and admin header
include '../includes/db_connect.php';
include '../includes/admin_header.php';

// Check if the admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php');  // Redirect to admin login if not logged in
    exit();
}

// Set up pagination
$records_per_page = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $records_per_page;

// Initialize search query
$search_query = isset($_POST['search_query']) ? trim($_POST['search_query']) : '';
$where_clause = "";
$params = [];

// Build the query based on search and filter conditions
if (!empty($search_query)) {
    $where_clause = "WHERE users.username LIKE ?";
    $params[] = "%$search_query%";
}

// Get total number of records for pagination
$count_query = "SELECT COUNT(*) as total FROM bookings 
                JOIN users ON bookings.user_id = users.id 
                JOIN buses ON bookings.bus_id = buses.id 
                $where_clause";
$stmt = $conn->prepare($count_query);
if (!empty($params)) {
    $stmt->bind_param(str_repeat('s', count($params)), ...$params);
}
$stmt->execute();
$total_records = $stmt->get_result()->fetch_assoc()['total'];
$total_pages = ceil($total_records / $records_per_page);

// Main query with pagination
$query = "SELECT bookings.id, users.username, buses.bus_number, routes.route_name,
          bookings.seat_numbers, bookings.booking_time, bookings.status, 
          bookings.seat_price,
          (bookings.seat_price * (LENGTH(bookings.seat_numbers) - LENGTH(REPLACE(bookings.seat_numbers, ',', '')) + 1)) as total_price
          FROM bookings 
          JOIN users ON bookings.user_id = users.id 
          JOIN buses ON bookings.bus_id = buses.id 
          JOIN routes ON buses.route_id = routes.id 
          $where_clause 
          ORDER BY bookings.booking_time DESC 
          LIMIT ? OFFSET ?";

$stmt = $conn->prepare($query);
if (!empty($params)) {
    $stmt->bind_param(str_repeat('s', count($params)) . 'ii', ...array_merge($params, [$records_per_page, $offset]));
} else {
    $stmt->bind_param('ii', $records_per_page, $offset);
}
$stmt->execute();
$result = $stmt->get_result();

// Handle cancellation of booking
if (isset($_GET['cancel_id'])) {
    $cancel_id = $_GET['cancel_id'];
    
    // Start transaction
    $conn->begin_transaction();
    
    try {
        // Update booking status to 'canceled'
        $cancel_query = "UPDATE bookings SET status = 'canceled' WHERE id = ?";
        $stmt = $conn->prepare($cancel_query);
        $stmt->bind_param('i', $cancel_id);
        $stmt->execute();

        // Free the seats
        $booking_info = "SELECT bus_id, seat_numbers FROM bookings WHERE id = ?";
        $stmt = $conn->prepare($booking_info);
        $stmt->bind_param('i', $cancel_id);
        $stmt->execute();
        $result_info = $stmt->get_result();
        
        if ($result_info->num_rows > 0) {
            $row_info = $result_info->fetch_assoc();
            $bus_id = $row_info['bus_id'];
            $seat_numbers = explode(',', $row_info['seat_numbers']);
            
            foreach ($seat_numbers as $seat) {
                $free_seat_query = "UPDATE seats SET status = 'available' WHERE bus_id = ? AND seat_number = ?";
                $stmt = $conn->prepare($free_seat_query);
                $stmt->bind_param('is', $bus_id, $seat);
                $stmt->execute();
            }
        }
        
        $conn->commit();
        echo "<script>alert('Booking canceled successfully.'); window.location.href = window.location.pathname;</script>";
    } catch (Exception $e) {
        $conn->rollback();
        echo "<script>alert('Error canceling booking. Please try again.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Bookings</title>
    <link rel="stylesheet" href="../assets/css/manage_bookings.css">
</head>
<body>
    <div class="admin-container">
        <h2>Manage Bookings</h2>

        <!-- Search Booking by User -->
        <form action="manage_bookings.php" method="POST" class="search-form">
            <input type="text" name="search_query" placeholder="Search by username" value="<?php echo htmlspecialchars($search_query); ?>">
            <button type="submit" name="search">Search</button>
            <?php if (!empty($search_query)): ?>
                <a href="manage_bookings.php" class="btn-clear">Clear Search</a>
            <?php endif; ?>
        </form>

        <!-- Bookings Summary -->
        <div class="bookings-summary">
            <p>Total Bookings: <?php echo $total_records; ?></p>
            <?php if (!empty($search_query)): ?>
                <p>Search Results for: "<?php echo htmlspecialchars($search_query); ?>"</p>
            <?php endif; ?>
        </div>

        <!-- Table to display bookings -->
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Booking ID</th>
                        <th>User</th>
                        <th>Bus</th>
                        <th>Route</th>
                        <th>Seats</th>
                        <th>Booking Time</th>
                        <th>Status</th>
                        <th>Price (AUD)</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result && $result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td data-label="Booking ID"><?php echo $row['id']; ?></td>
                                <td data-label="User"><?php echo htmlspecialchars($row['username']); ?></td>
                                <td data-label="Bus"><?php echo htmlspecialchars($row['bus_number']); ?></td>
                                <td data-label="Route"><?php echo htmlspecialchars($row['route_name']); ?></td>
                                <td data-label="Seats"><?php echo htmlspecialchars($row['seat_numbers']); ?></td>
                                <td data-label="Booking Time"><?php echo date('Y-m-d H:i', strtotime($row['booking_time'])); ?></td>
                                <td data-label="Status"><span class="status-<?php echo strtolower($row['status']); ?>"><?php echo ucfirst($row['status']); ?></span></td>
                                <td data-label="Price">
                                    <?php 
                                        echo '$' . number_format($row['total_price'], 2) . ' ($' . number_format($row['seat_price'], 2) . ' per seat)'; 
                                    ?>
                                </td>
                                <td data-label="Action">
                                    <?php if ($row['status'] == 'confirmed'): ?>
                                        <a href="manage_bookings.php?cancel_id=<?php echo $row['id']; ?>" 
                                           class="btn-cancel"
                                           onclick="return confirm('Are you sure you want to cancel this booking?');">
                                            Cancel
                                        </a>
                                    <?php else: ?>
                                        <span class="status-canceled">Canceled</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="9" class="no-records">
                                <?php echo $search_query ? "No bookings found for '$search_query'" : "No bookings found."; ?>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <?php if ($total_pages > 1): ?>
            <div class="pagination">
                <?php if ($page > 1): ?>
                    <a href="?page=1<?php echo !empty($search_query) ? '&search_query='.urlencode($search_query) : ''; ?>" class="page-link">&laquo; First</a>
                    <a href="?page=<?php echo ($page - 1); ?><?php echo !empty($search_query) ? '&search_query='.urlencode($search_query) : ''; ?>" class="page-link">&lsaquo; Previous</a>
                <?php endif; ?>

                <?php
                $start_page = max(1, $page - 2);
                $end_page = min($total_pages, $page + 2);

                for ($i = $start_page; $i <= $end_page; $i++): ?>
                    <a href="?page=<?php echo $i; ?><?php echo !empty($search_query) ? '&search_query='.urlencode($search_query) : ''; ?>" 
                       class="page-link <?php echo ($page == $i) ? 'active' : ''; ?>">
                        <?php echo $i; ?>
                    </a>
                <?php endfor; ?>

                <?php if ($page < $total_pages): ?>
                    <a href="?page=<?php echo ($page + 1); ?><?php echo !empty($search_query) ? '&search_query='.urlencode($search_query) : ''; ?>" class="page-link">Next &rsaquo;</a>
                    <a href="?page=<?php echo $total_pages; ?><?php echo !empty($search_query) ? '&search_query='.urlencode($search_query) : ''; ?>" class="page-link">Last &raquo;</a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</body>
<?php include '../includes/admin_footer.php'; ?>
</html>

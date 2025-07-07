<?php
session_start();
include '../includes/db_connect.php';
include '../includes/admin_functions.php';

check_admin_logged_in(); // Ensure admin is logged in

// Handle User Deletion
if (isset($_POST['delete_user'])) {
    $user_id = $_POST['user_id'];
    
    // Delete the user from users table using prepared statement
    $delete_user_query = "DELETE FROM users WHERE id = ?";
    $stmt = $conn->prepare($delete_user_query);
    $stmt->bind_param("i", $user_id);
    if ($stmt->execute()) {
        $success_message = "User deleted successfully!";
    } else {
        $error_message = "Error deleting user: " . $conn->error;
    }
}

// Handle User Balance Update
if (isset($_POST['update_user_balance'])) {
    $user_id = $_POST['user_id'];
    $new_balance = $_POST['new_balance'];

    // Update user's balance using prepared statement
    $update_balance_query = "UPDATE users SET balance = ? WHERE id = ?";
    $stmt = $conn->prepare($update_balance_query);
    $stmt->bind_param("di", $new_balance, $user_id);
    if ($stmt->execute()) {
        $success_message = "User balance updated successfully!";
    } else {
        $error_message = "Error updating balance: " . $conn->error;
    }
}

// Handle User Status Update
if (isset($_POST['update_user_status'])) {
    $user_id = $_POST['user_id'];
    $new_status = $_POST['new_status'];

    // Update user's status using prepared statement
    $update_status_query = "UPDATE users SET status = ? WHERE id = ?";
    $stmt = $conn->prepare($update_status_query);
    $stmt->bind_param("si", $new_status, $user_id);
    if ($stmt->execute()) {
        $success_message = "User status updated successfully!";
    } else {
        $error_message = "Error updating status: " . $conn->error;
    }
}

// Handle Search
$search_query = isset($_GET['search_query']) ? trim($_GET['search_query']) : '';
$users_query = "SELECT * FROM users";
$params = [];
$types = "";

if (!empty($search_query)) {
    $users_query .= " WHERE username LIKE ? OR email LIKE ?";
    $search_param = "%{$search_query}%";
    $params = [$search_param, $search_param];
    $types = "ss";
}

$users_query .= " ORDER BY username ASC";

// Prepare and execute the query
$stmt = $conn->prepare($users_query);
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$users_result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users - Admin Dashboard</title>
    <link rel="stylesheet" href="../assets/css/manage_users.css">
</head>
<body>
<?php include '../includes/admin_header.php'; ?>

    <div class="container">
        <h2>Manage Users</h2>

        <?php if (isset($success_message)): ?>
            <div class="success-message"><?php echo $success_message; ?></div>
        <?php endif; ?>
        
        <?php if (isset($error_message)): ?>
            <div class="error-message"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <!-- Search Users Form -->
        <form action="manage_users.php" method="GET" class="search-form">
            <input type="text" name="search_query" placeholder="Search by username or email" value="<?php echo htmlspecialchars($search_query); ?>">
            <button type="submit">Search</button>
            <?php if (!empty($search_query)): ?>
                <a href="manage_users.php" class="clear-search">Clear Search</a>
            <?php endif; ?>
        </form>

        <!-- Display Users Table with Horizontal Scrolling -->
        <div class="table-wrapper">
            <table class="users-table">
                <thead>
                    <tr>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Recharge Code</th>
                        <th>Balance (AUD)</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($users_result->num_rows > 0): ?>
                        <?php while ($user = $users_result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($user['username']); ?></td>
                                <td><?php echo htmlspecialchars($user['email']); ?></td>
                                <td><?php echo htmlspecialchars($user['recharge_code']); ?></td>
                                <td><?php echo number_format($user['balance'], 2); ?></td>
                                <td><?php echo htmlspecialchars($user['status']); ?></td>
                                <td>
                                    <!-- Edit User Balance -->
                                    <form action="manage_users.php" method="POST" style="display:inline;">
                                        <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                                        <input type="number" name="new_balance" value="<?php echo $user['balance']; ?>" step="0.01" min="0">
                                        <button type="submit" name="update_user_balance" class="update-btn">Update Balance</button>
                                    </form>

                                    <!-- Update User Status -->
                                    <form action="manage_users.php" method="POST" style="display:inline;">
                                        <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                                        <select name="new_status" required>
                                            <option value="active" <?php echo $user['status'] == 'active' ? 'selected' : ''; ?>>Active</option>
                                            <option value="inactive" <?php echo $user['status'] == 'inactive' ? 'selected' : ''; ?>>Inactive</option>
                                        </select>
                                        <button type="submit" name="update_user_status" class="update-btn">Update Status</button>
                                    </form>

                                    <!-- Delete User -->
                                    <form action="manage_users.php" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                        <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                                        <button type="submit" name="delete_user" class="delete-btn">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="no-records">No users found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    
    <?php include '../includes/admin_footer.php'; ?>
</body>
</html>

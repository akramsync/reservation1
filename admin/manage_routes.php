<?php
session_start();
include '../includes/db_connect.php';
include '../includes/admin_functions.php';

check_admin_logged_in(); // Ensure admin is logged in

// Handle Add Route Form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_route'])) {
    $route_name = $_POST['route_name'];

    if (!empty($route_name)) {
        // Insert new route into the database
        $add_route_query = "INSERT INTO routes (route_name) VALUES ('$route_name')";
        if ($conn->query($add_route_query) === TRUE) {
            $success_message = "Route added successfully!";
        } else {
            $error_message = "Error adding route: " . $conn->error;
        }
    } else {
        $error_message = "Route name cannot be empty.";
    }
}

// Handle Delete Route
if (isset($_POST['delete_route'])) {
    $route_id = $_POST['route_id'];
    
    // Delete the route
    $delete_route_query = "DELETE FROM routes WHERE id = '$route_id'";
    if ($conn->query($delete_route_query) === TRUE) {
        $success_message = "Route deleted successfully!";
    } else {
        $error_message = "Error deleting route: " . $conn->error;
    }
}

// Handle Update Route
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_route'])) {
    $route_id = $_POST['route_id'];
    $updated_route_name = $_POST['updated_route_name'];

    // Update route name
    $update_route_query = "UPDATE routes SET route_name = '$updated_route_name' WHERE id = '$route_id'";
    if ($conn->query($update_route_query) === TRUE) {
        $success_message = "Route updated successfully!";
    } else {
        $error_message = "Error updating route: " . $conn->error;
    }
}

// Fetch all routes to display in table
$routes_query = "SELECT * FROM routes ORDER BY route_name ASC";
$routes_result = $conn->query($routes_query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Routes - Admin Dashboard</title>
    <link rel="stylesheet" href="../assets/css/manage_routes.css">
</head>
<body>
<?php include '../includes/admin_header.php'; ?>



    <div class="container">
        <h2>Manage Routes</h2>

        <?php if (isset($success_message)): ?>
            <div class="success-message"><?php echo $success_message; ?></div>
        <?php endif; ?>
        
        <?php if (isset($error_message)): ?>
            <div class="error-message"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <!-- Add Route Form -->
        <form action="manage_routes.php" method="POST" class="add-route-form">
            <h3>Add New Route</h3>
            <div class="form-group">
                <label for="route_name">Route Name:</label>
                <input type="text" name="route_name" required>
            </div>
            <button type="submit" name="add_route">Add Route</button>
        </form>

        <!-- Display Existing Routes -->
        <h3>Existing Routes</h3>
        <table class="routes-table">
            <thead>
                <tr>
                    <th>Route Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($route = $routes_result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $route['route_name']; ?></td>
                        <td>
                            <!-- Update Route -->
                            <form action="manage_routes.php" method="POST" style="display:inline;">
                                <input type="hidden" name="route_id" value="<?php echo $route['id']; ?>">
                                <input type="text" name="updated_route_name" placeholder="New Route Name" required>
                                <button type="submit" name="update_route" class="update-btn">Update</button>
                            </form>

                            <!-- Delete Route -->
                            <form action="manage_routes.php" method="POST" style="display:inline;">
                                <input type="hidden" name="route_id" value="<?php echo $route['id']; ?>">
                                <button type="submit" name="delete_route" class="delete-btn">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    <?php include '../includes/admin_footer.php'; ?>
</body>
</html>

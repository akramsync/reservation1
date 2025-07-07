<?php
session_start();
include '../includes/db_connect.php';
include '../includes/admin_functions.php';

check_admin_logged_in(); // Ensure admin is logged in

// Automatically inactivate past buses without deleting booking data
$current_date = date('Y-m-d');
$current_time = date('H:i:s');

// Query to inactivate past buses
$inactivate_buses_query = "UPDATE buses SET status = 'inactive' 
                           WHERE (date < '$current_date' OR (date = '$current_date' AND time < '$current_time')) 
                           AND status = 'active'";
$conn->query($inactivate_buses_query);

// Fetch routes to display in the dropdown
$route_query = "SELECT * FROM routes";
$routes_result = $conn->query($route_query);

// Handle Add Bus Form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_bus'])) {
    $route_id = $_POST['route_id'];
    $bus_number = $_POST['bus_number'];
    $seat_fare = $_POST['seat_fare'];
    $bus_date = $_POST['bus_date'];
    $bus_hour = $_POST['bus_hour'];
    $auto_next_hours = isset($_POST['auto_next_hours']) ? true : false;
    $next_hours_duration = isset($_POST['next_hours_duration']) ? $_POST['next_hours_duration'] : null;

    // Validate form fields and limit buses to only the next 3 days
    $current_date_plus_three = date('Y-m-d', strtotime('+3 days'));
    if (empty($route_id) || empty($bus_number) || empty($seat_fare) || empty($bus_date) || empty($bus_hour)) {
        $error_message = "All fields are required.";
    } elseif ($bus_date > $current_date_plus_three) {
        $error_message = "Buses can only be added for the next three days.";
    } else {
        // Add the bus to the buses table
        $insert_bus_query = "INSERT INTO buses (route_id, bus_number, date, time, status) 
                             VALUES ('$route_id', '$bus_number', '$bus_date', '$bus_hour', 'active')";
        if ($conn->query($insert_bus_query) === TRUE) {
            $new_bus_id = $conn->insert_id;

            // Add seats to the seats table for the newly added bus
            for ($seat_number = 1; $seat_number <= 30; $seat_number++) {
                $status = ($seat_number == 1 || $seat_number == 2 || $seat_number == 3) ? 'default_booked' : 'available';
                $insert_seat_query = "INSERT INTO seats (bus_id, seat_number, price, status) 
                                      VALUES ('$new_bus_id', '$seat_number', '$seat_fare', '$status')";
                $conn->query($insert_seat_query);
            }

            // If checkbox for auto-adding next hour buses is ticked
            if ($auto_next_hours && $next_hours_duration) {
                $max_hours = ($next_hours_duration == '24') ? 24 : (($next_hours_duration == '48') ? 48 : 72);
                for ($i = 1; $i <= $max_hours; $i++) {
                    $next_hour_time = date('H:i:s', strtotime("+$i hour", strtotime($bus_hour)));
                    $next_bus_date = date('Y-m-d', strtotime("+$i hour", strtotime("$bus_date $bus_hour")));

                    if ($next_bus_date > $current_date_plus_three) {
                        break; // Ensure buses beyond 3 days aren't added
                    }

                    $insert_next_bus_query = "INSERT INTO buses (route_id, bus_number, date, time, status) 
                                              VALUES ('$route_id', '$bus_number - $i', '$next_bus_date', '$next_hour_time', 'active')";
                    if ($conn->query($insert_next_bus_query)) {
                        $next_bus_id = $conn->insert_id;

                        // Add seats for the next buses
                        for ($seat_number = 1; $seat_number <= 30; $seat_number++) {
                            $status = ($seat_number == 1 || $seat_number == 2 || $seat_number == 3) ? 'default_booked' : 'available';
                            $insert_next_seat_query = "INSERT INTO seats (bus_id, seat_number, price, status) 
                                                       VALUES ('$next_bus_id', '$seat_number', '$seat_fare', '$status')";
                            $conn->query($insert_next_seat_query);
                        }
                    }
                }
            }

            $success_message = "Bus and seats successfully added!";
        } else {
            $error_message = "Error adding bus: " . $conn->error;
        }
    }
}

// Handle Bus Soft Delete or Permanent Delete
if (isset($_POST['bulk_action']) && isset($_POST['bus_ids'])) {
    $bus_ids = $_POST['bus_ids']; // Array of selected bus IDs
    $action = $_POST['bulk_action']; // bulk action (soft_delete or permanent_delete)

    $bus_ids_str = implode(",", $bus_ids); // Convert array to comma-separated values
    if ($action == 'soft_delete') {
        // Soft delete (mark as inactive)
        $update_buses_query = "UPDATE buses SET status = 'inactive' WHERE id IN ($bus_ids_str)";
        if ($conn->query($update_buses_query)) {
            $success_message = "Selected buses have been inactivated.";
        } else {
            $error_message = "Error inactivating buses: " . $conn->error;
        }
    } elseif ($action == 'permanent_delete') {
        // Permanent delete
        $delete_seats_query = "DELETE FROM seats WHERE bus_id IN ($bus_ids_str)";
        if ($conn->query($delete_seats_query)) {
            $delete_buses_query = "DELETE FROM buses WHERE id IN ($bus_ids_str)";
            if ($conn->query($delete_buses_query)) {
                $success_message = "Selected buses and their seats successfully removed!";
            } else {
                $error_message = "Error removing buses: " . $conn->error;
            }
        } else {
            $error_message = "Error removing seats: " . $conn->error;
        }
    }
}

// Fetch active and inactive buses for display
$active_buses_query = "SELECT buses.id, buses.bus_number, buses.date, buses.time, routes.route_name 
                       FROM buses
                       JOIN routes ON buses.route_id = routes.id
                       WHERE buses.status = 'active'
                       AND (buses.date > '$current_date' 
                           OR (buses.date = '$current_date' AND buses.time > '$current_time'))
                       ORDER BY buses.date ASC, buses.time ASC";
$active_buses_result = $conn->query($active_buses_query);

$inactive_buses_query = "SELECT buses.id, buses.bus_number, buses.date, buses.time, routes.route_name 
                         FROM buses
                         JOIN routes ON buses.route_id = routes.id
                         WHERE buses.status = 'inactive'
                         OR (buses.date < '$current_date' 
                             OR (buses.date = '$current_date' AND buses.time <= '$current_time'))
                         ORDER BY buses.date DESC, buses.time ASC";
$inactive_buses_result = $conn->query($inactive_buses_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Buses - Admin Dashboard</title>
    <link rel="stylesheet" href="../assets/css/manage_buses.css">
</head>
<body>
<?php include '../includes/admin_header.php'; ?>

<div class="container">
    <h2>Manage Buses</h2>

    <!-- Display Current Time -->
    <div class="current-time">
        <p>Current Time: <span id="currentTime"></span></p>
    </div>

    <?php if (isset($success_message)): ?>
        <div class="success-message"><?php echo $success_message; ?></div>
    <?php endif; ?>
    
    <?php if (isset($error_message)): ?>
        <div class="error-message"><?php echo $error_message; ?></div>
    <?php endif; ?>

    <!-- Add Bus Form -->
    <form action="manage_buses.php" method="POST" class="add-bus-form" id="addBusForm">
        <h3>Add New Bus</h3>

        <div class="form-group">
            <label for="route_id">Route:</label>
            <select name="route_id" required>
                <?php while ($route = $routes_result->fetch_assoc()): ?>
                    <option value="<?php echo $route['id']; ?>"><?php echo $route['route_name']; ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="bus_number">Bus Number:</label>
            <input type="text" name="bus_number" required>
        </div>

        <div class="form-group">
            <label for="seat_fare">Seat Fare (AUD):</label>
            <input type="number" name="seat_fare" value="20" min="0" step="0.01" required>
        </div>

        <div class="form-group">
            <label for="bus_date">Date:</label>
            <input type="date" name="bus_date" min="<?php echo date('Y-m-d'); ?>" max="<?php echo date('Y-m-d', strtotime('+3 days')); ?>" required>
        </div>

        <div class="form-group">
            <label for="bus_hour">Hour:</label>
            <input type="time" name="bus_hour" required>
        </div>

        <div class="form-group">
            <label for="auto_next_hours">Auto-add buses for the next hours:</label>
            <input type="checkbox" id="autoNextHoursCheckbox" name="auto_next_hours" value="1">
        </div>

        <!-- Select Duration of Auto Buses -->
        <div id="nextHoursDuration" style="display:none;">
            <label>Select duration for auto-added buses:</label>
            <div>
                <input type="radio" id="24hours" name="next_hours_duration" value="24">
                <label for="24hours">24 Hours</label>
            </div>
            <div>
                <input type="radio" id="48hours" name="next_hours_duration" value="48">
                <label for="48hours">48 Hours</label>
            </div>
            <div>
                <input type="radio" id="72hours" name="next_hours_duration" value="72">
                <label for="72hours">72 Hours</label>
            </div>
        </div>

        <button type="submit" name="add_bus">Add Bus</button>
    </form>

    <!-- Toggle to show active buses -->
    <h3><a href="javascript:void(0)" id="toggleActiveBuses">Show Active Buses</a></h3>

    <!-- Display Active Buses -->
    <div id="activeBusesSection" style="display:none;">
        <form action="manage_buses.php" method="POST">
            <input type="hidden" name="bulk_action" value="soft_delete">
            <table class="buses-table">
                <thead>
                    <tr>
                        <th><input type="checkbox" id="select_all_active"></th>
                        <th>Bus Number</th>
                        <th>Route</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($bus = $active_buses_result->fetch_assoc()): ?>
                        <tr>
                            <td><input type="checkbox" name="bus_ids[]" value="<?php echo $bus['id']; ?>"></td>
                            <td><?php echo $bus['bus_number']; ?></td>
                            <td><?php echo $bus['route_name']; ?></td>
                            <td><?php echo $bus['date']; ?></td>
                            <td><?php echo $bus['time']; ?></td>
                            <td>
                                <button type="submit" name="remove_bus" class="remove-btn">Inactivate</button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            <button type="submit">Inactivate Selected Buses</button>
        </form>
    </div>

    <!-- Toggle to show inactive buses -->
    <h3><a href="javascript:void(0)" id="toggleInactiveBuses">Show Inactive Buses</a></h3>

    <!-- Display Inactive Buses -->
    <div id="inactiveBusesSection" style="display:none;">
        <form action="manage_buses.php" method="POST">
            <input type="hidden" name="bulk_action" value="permanent_delete">
            <table class="buses-table">
                <thead>
                    <tr>
                        <th><input type="checkbox" id="select_all_inactive"></th>
                        <th>Bus Number</th>
                        <th>Route</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($bus = $inactive_buses_result->fetch_assoc()): ?>
                        <tr>
                            <td><input type="checkbox" name="bus_ids[]" value="<?php echo $bus['id']; ?>"></td>
                            <td><?php echo $bus['bus_number']; ?></td>
                            <td><?php echo $bus['route_name']; ?></td>
                            <td><?php echo $bus['date']; ?></td>
                            <td><?php echo $bus['time']; ?></td>
                            <td>
                                <button type="submit" name="remove_bus" class="remove-btn">Delete</button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            <button type="submit">Delete Selected Buses</button>
        </form>
    </div>
</div>

<!-- JavaScript for Current Time Display, Toggle Buses, and Auto-add Buses -->
<script>
    function updateCurrentTime() {
        const now = new Date();
        const hours = now.getHours().toString().padStart(2, '0');
        const minutes = now.getMinutes().toString().padStart(2, '0');
        const seconds = now.getSeconds().toString().padStart(2, '0');
        const timeString = `${hours}:${minutes}:${seconds}`;
        document.getElementById('currentTime').textContent = timeString;
        
        // Check active buses and move to inactive if past departure time
        checkAndUpdateBusStatus();
    }

    function checkAndUpdateBusStatus() {
        const now = new Date();
        const activeBusesRows = document.querySelectorAll('#activeBusesSection tbody tr');
        const inactiveBusesTable = document.querySelector('#inactiveBusesSection tbody');

        activeBusesRows.forEach(row => {
            const dateCell = row.cells[3].textContent;
            const timeCell = row.cells[4].textContent;
            const busDateTime = new Date(dateCell + ' ' + timeCell);

            if (now >= busDateTime) {
                // Move the bus to inactive section
                const busId = row.querySelector('input[name="bus_ids[]"]').value;
                
                // Send AJAX request to update status in database
                fetch('manage_buses.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `bulk_action=soft_delete&bus_ids[]=${busId}`
                })
                .then(response => {
                    if (response.ok) {
                        // Move row to inactive section
                        const newRow = row.cloneNode(true);
                        // Change the button text from "Inactivate" to "Delete"
                        const actionButton = newRow.querySelector('.remove-btn');
                        actionButton.textContent = 'Delete';
                        
                        // Update the form action for permanent delete
                        const checkbox = newRow.querySelector('input[name="bus_ids[]"]');
                        checkbox.checked = false;
                        
                        inactiveBusesTable.appendChild(newRow);
                        row.remove();
                    }
                });
            }
        });
    }

    // Run the time update and status check every second
    setInterval(updateCurrentTime, 1000);

    // Toggle Active Buses Section
    document.getElementById('toggleActiveBuses').addEventListener('click', function() {
        const section = document.getElementById('activeBusesSection');
        if (section.style.display === 'none') {
            section.style.display = 'block';
            this.textContent = 'Hide Active Buses';
        } else {
            section.style.display = 'none';
            this.textContent = 'Show Active Buses';
        }
    });

    // Toggle Inactive Buses Section
    document.getElementById('toggleInactiveBuses').addEventListener('click', function() {
        const section = document.getElementById('inactiveBusesSection');
        if (section.style.display === 'none') {
            section.style.display = 'block';
            this.textContent = 'Hide Inactive Buses';
        } else {
            section.style.display = 'none';
            this.textContent = 'Show Inactive Buses';
        }
    });

    // Select all checkboxes for active buses
    document.getElementById('select_all_active').addEventListener('click', function() {
        const checkboxes = document.querySelectorAll('#activeBusesSection tbody input[name="bus_ids[]"]');
        checkboxes.forEach(checkbox => checkbox.checked = this.checked);
    });

    // Select all checkboxes for inactive buses
    document.getElementById('select_all_inactive').addEventListener('click', function() {
        const checkboxes = document.querySelectorAll('#inactiveBusesSection tbody input[name="bus_ids[]"]');
        checkboxes.forEach(checkbox => checkbox.checked = this.checked);
    });

    // Show the duration options only if auto-add buses is checked
    document.getElementById('autoNextHoursCheckbox').addEventListener('change', function() {
        const nextHoursDurationSection = document.getElementById('nextHoursDuration');
        if (this.checked) {
            nextHoursDurationSection.style.display = 'block';
        } else {
            nextHoursDurationSection.style.display = 'none';
        }
    });
</script>
<?php include '../includes/admin_footer.php'; ?>
</body>
</html>

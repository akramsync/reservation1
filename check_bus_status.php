<?php
include 'includes/db_connect.php';

// Update bus status based on date and time
$current_date = date('Y-m-d');
$current_time = date('H:i:s');

// Update status to 'inactive' for buses where date has passed or time has passed on current date
$update_query = "UPDATE buses SET status = 'inactive' 
                WHERE (date < '$current_date') 
                OR (date = '$current_date' AND time < '$current_time')";
$conn->query($update_query);

// Log the update
$log_file = fopen("logs/bus_status_updates.log", "a");
fwrite($log_file, date('Y-m-d H:i:s') . " - Bus status check completed\n");
fclose($log_file);

$conn->close();
?> 
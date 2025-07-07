<?php
include 'includes/db_connect.php';

header('Content-Type: application/json');

if (!isset($_GET['bus_id'])) {
    echo json_encode(['error' => 'Bus ID not provided']);
    exit;
}

$bus_id = $_GET['bus_id'];

// Get all seats for the bus
$seats_query = "SELECT seat_number, status FROM seats WHERE bus_id = ?";
$stmt = $conn->prepare($seats_query);
$stmt->bind_param("i", $bus_id);
$stmt->execute();
$result = $stmt->get_result();

$seats = [];
while ($row = $result->fetch_assoc()) {
    $seats[$row['seat_number']] = $row['status'];
}

echo json_encode($seats);

$stmt->close();
$conn->close();
?> 
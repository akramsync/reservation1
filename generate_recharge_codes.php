<?php
include 'includes/db_connect.php';

function generateUniqueCode() {
    return 'RCG' . strtoupper(bin2hex(random_bytes(5)));
}

for ($i = 0; $i < 100; $i++) {
    $code = generateUniqueCode();
    $query = "INSERT INTO recharge_codes (code) VALUES ('$code')";
    $conn->query($query);
}

echo "100 recharge codes generated successfully!";
?>

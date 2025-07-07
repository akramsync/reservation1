<?php
require_once 'NowPaymentsIPN.php';

// Initialize with your IPN secret
$ipn_secret = "5ipxrtYf6X3IGE4TFClbMTpIZASmf81c"; 
$ipn = new NowPaymentsIPN($ipn_secret);

// Process the IPN
$result = $ipn->process_ipn();

// Log the result (optional)
file_put_contents('ipn_log.txt', date('Y-m-d H:i:s') . " - " . $result . "\n", FILE_APPEND);

echo $result;
?>
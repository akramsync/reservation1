<?php
session_start(); // Start the session

// Destroy all session variables
session_unset();

// Destroy the session itself
session_destroy();

// Redirect to the admin login page after logout
header("Location: admin_login.php");
exit();
?>

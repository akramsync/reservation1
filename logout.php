<?php
session_start(); // Start or resume the session

// Destroy the session
session_unset(); // Unset all session variables
session_destroy(); // Destroy the session

// Redirect to the login page (or you can redirect to the home page if preferred)
header('Location: login.php');
exit();

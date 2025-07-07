<?php
// Function to check if admin is logged in
function check_admin_logged_in() {
    if (!isset($_SESSION['admin_id'])) {
        header('Location: admin_login.php');
        exit();
    }
}
?>

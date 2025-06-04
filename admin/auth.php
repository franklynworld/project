<?php
// Start session
session_start();

// Function to check if user is logged in and is an admin
function isAdmin() {
    // Check if the user is logged in and the user role is admin
    return isset($_SESSION['user_id']) && isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1;
}
?>

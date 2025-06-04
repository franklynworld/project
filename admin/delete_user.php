<?php
// Include authentication file
include('auth.php');
include('db_connection.php');

// Check if the user is not an admin, redirect to login page
if (!isAdmin()) {
    header("Location: admin_login.php");
    exit();
}

// Check if 'id' is set in the URL
if (!isset($_GET['id'])) {
    echo "No user ID provided.";
    exit();
}

$user_id = $_GET['id'];

// Delete the user from the database
$stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
$stmt->execute([$user_id]);

// Redirect to the manage users page
header("Location: manage_users.php");
exit();
?>

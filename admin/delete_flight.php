<?php
// Include authentication file
include('auth.php');
include('db_connection.php');

// Check if the user is not an admin, redirect to login page
if (!isAdmin()) {
    header("Location: admin_login.php");
    exit();
}

// Check if the 'id' is set in the URL
if (!isset($_GET['id'])) {
    echo "No flight ID provided.";
    exit();
}

$flight_id = $_GET['id'];

// Delete the flight from the database
$stmt = $conn->prepare("DELETE FROM flights WHERE id = ?");
$stmt->execute([$flight_id]);

// Redirect to the manage flights page
header("Location: manage_flights.php");
exit();
?>

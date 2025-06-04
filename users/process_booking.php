<?php
session_start();
include('db_connection.php');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php'); // Redirect to login page if not logged in
    exit();
}

// Check if the required POST parameters are set
if (!isset($_POST['user_id'], $_POST['flight_id'], $_POST['passengers'], $_POST['total_price'], $_POST['payment_status'])) {
    echo "Error: Missing required information.";
    exit();
}

// Sanitize and validate inputs
$user_id = $_POST['user_id'];
$flight_id = $_POST['flight_id'];
$passengers = (int) $_POST['passengers'];
$total_price = (float) $_POST['total_price'];
$payment_status = $_POST['payment_status'];

// Check if the user_id is valid and exists in the database
try {
    $stmt = $conn->prepare("SELECT id FROM users WHERE id = ?");
    $stmt->execute([$user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        echo "Error: User not found.";
        exit();
    }
} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage();
    exit();
}

// Check if the flight_id is valid and exists in the flights table
try {
    $stmt = $conn->prepare(query: "SELECT id FROM flights WHERE id = ?");
    $stmt->execute([$flight_id]);
    $flight = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$flight) {
        echo "Error: Flight not found.";
        exit();
    }
} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage();
    exit();
}

// Begin a transaction
$conn->beginTransaction();

try {
    // Insert the booking details into the bookings table
    $stmt = $conn->prepare("INSERT INTO bookings (user_id, flight_id, passengers, total_price, payment_status) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$user_id, $flight_id, $passengers, $total_price, $payment_status]);

    // Commit the transaction
    $conn->commit();

    // Redirect to a confirmation page or display a success message
    echo "Booking successful! <a href='user_bookings.php'>View your bookings</a>";

} catch (PDOException $e) {
    // If an error occurs, rollback the transaction
    $conn->rollBack();
    echo "Error: Could not process the booking. Please try again later.";
    error_log("Database error while processing booking: " . $e->getMessage());
}

?>

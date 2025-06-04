<?php
// Include authentication file
include('auth.php');

// Check if the user is not an admin, redirect to login page
if (!isAdmin()) {
    header("Location: admin_login.php");
    exit();
}

include('db_connection.php');

// Fetch all bookings from the database
$stmt = $conn->query("SELECT bookings.id, users.name AS user_name, flights.flight_number, bookings.booking_date 
                      FROM bookings
                      JOIN users ON bookings.user_id = users.id
                      JOIN flights ON bookings.flight_id = flights.id");
$bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Bookings</title>
    <link rel="stylesheet" href="css/view_bookings.css">
</head>
<body>
    <div class="container">
        <h1>View Bookings</h1>
        <table>
            <thead>
                <tr>
                    <th>Booking ID</th>
                    <th>User</th>
                    <th>Flight Number</th>
                    <th>Booking Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($bookings as $booking): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($booking['id']); ?></td>
                        <td><?php echo htmlspecialchars($booking['user_name']); ?></td>
                        <td><?php echo htmlspecialchars($booking['flight_number']); ?></td>
                        <td><?php echo htmlspecialchars($booking['booking_date']); ?></td>
                        <td>
                            <!-- Actions for viewing booking details or deleting -->
                            <a href="view_booking_details.php?id=<?php echo $booking['id']; ?>">View Details</a> |
                            <a href="delete_booking.php?id=<?php echo $booking['id']; ?>" onclick="return confirm('Are you sure you want to delete this booking?')">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
<style>
    /* view_bookings_style.css */
body {
    font-family: 'Arial', sans-serif;
    background-color: #f8f8f8;
    margin: 0;
    padding: 0;
}

.container {
    width: 85%;
    margin: 30px auto;
    background: #fff;
    border-radius: 15px;
    padding: 25px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

h1 {
    text-align: center;
    color: #333;
    margin-bottom: 20px;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

table th, table td {
    padding: 15px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

table th {
    background-color: #00796b;
    color: white;
}

table tr:hover {
    background-color: #e0f2f1;
}

button {
    padding: 10px 20px;
    background-color: #0288d1;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

button:hover {
    background-color: #0277bd;
}

/* Responsive Design */
@media (max-width: 768px) {
    table {
        font-size: 14px;
    }

    button {
        font-size: 14px;
    }
}

</style>
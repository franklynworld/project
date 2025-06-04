<?php
// Include authentication file
include('auth.php');

// Check if the user is not an admin, redirect to login page
if (!isAdmin()) {
    header("Location: admin_login.php");
    exit();
}

include('db_connection.php');

// Fetch all flights from the database
$stmt = $conn->query("SELECT * FROM flights ORDER BY departureDate");
$flights = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Flights</title>
    <link rel="stylesheet" href="css/manage_flights.css">
</head>
<body>
    <div class="container">
        <h1>Manage Flights</h1>
        <table>
            <thead>
                <tr>
                    <th>Flight Number</th>
                    <th>Departure Location</th>
                    <th>Arrival Location</th>
                    <th>Price</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($flights as $flight): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($flight['flight_number']); ?></td>
                        <td><?php echo htmlspecialchars($flight['departure_location']); ?></td>
                        <td><?php echo htmlspecialchars($flight['arrival_location']); ?></td>
                        <td><?php echo "$" . htmlspecialchars($flight['price']); ?></td>
                        <td>
                            <a href="edit_flight.php?id=<?php echo $flight['id']; ?>">Edit</a> |
                            <a href="delete_flight.php?id=<?php echo $flight['id']; ?>" onclick="return confirm('Are you sure you want to delete this flight?')">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
<style>
    /* manage_flights_style.css */
body {
    font-family: 'Arial', sans-serif;
    background-color: #333;
    color: #fff;
    margin: 0;
    padding: 0;
}
a{
    text-decoration: none;
}
.container {
    width: 80%;
    margin: 40px auto;
    background: #444;
    border-radius: 10px;
    padding: 30px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
}

h1 {
    text-align: center;
    color: #fff;
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
    border-bottom: 1px solid #555;
}

table th {
    background-color: #0072ff;
}

table tr:hover {
    background-color: #575757;
}

button {
    padding: 12px 25px;
    background-color: #ff5722;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

button:hover {
    background-color: #e64a19;
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
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

// Fetch the flight details from the database
$stmt = $conn->prepare("SELECT * FROM flights WHERE id = ?");
$stmt->execute([$flight_id]);
$flight = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$flight) {
    echo "Flight not found.";
    exit();
}

// Handle form submission to update the flight details
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $flight_number = $_POST['flight_number'];
    $departure_location = $_POST['departure_location'];
    $arrival_location = $_POST['arrival_location'];
    $price = $_POST['price'];

    $updateStmt = $conn->prepare("UPDATE flights SET flight_number = ?, departure_location = ?, arrival_location = ?, price = ? WHERE id = ?");
    $updateStmt->execute([$flight_number, $departure_location, $arrival_location, $price, $flight_id]);

    // Redirect to the manage flights page
    header("Location: manage_flights.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Flight</title>
</head>
<body>
    <h1>Edit Flight</h1>
    <form action="edit_flight.php?id=<?php echo $flight['id']; ?>" method="POST">
        <label for="flight_number">Flight Number:</label>
        <input type="text" name="flight_number" value="<?php echo htmlspecialchars($flight['flight_number']); ?>" required><br>

        <label for="departure_location">Departure Location:</label>
        <input type="text" name="departure_location" value="<?php echo htmlspecialchars($flight['departure_location']); ?>" required><br>

        <label for="arrival_location">Arrival Location:</label>
        <input type="text" name="arrival_location" value="<?php echo htmlspecialchars($flight['arrival_location']); ?>" required><br>

        <label for="price">Price:</label>
        <input type="number" name="price" value="<?php echo htmlspecialchars($flight['price']); ?>" required><br>

        <button type="submit">Update Flight</button>
    </form>
</body>
</html>
<style>
    /* edit_flight.css */
body {
    font-family: 'Arial', sans-serif;
    background-color: #f1f1f1;
    margin: 0;
    padding: 0;
}

.container {
    width: 70%;
    margin: 50px auto;
    background: #fff;
    border-radius: 10px;
    padding: 30px;
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
}

h1 {
    text-align: center;
    color: #444;
    margin-bottom: 20px;
}

form {
    display: grid;
    gap: 25px;
}

label {
    font-weight: bold;
    color: #444;
}

input[type="text"],
input[type="number"],
input[type="date"],
select {
    padding: 12px;
    font-size: 16px;
    border: 1px solid #ddd;
    border-radius: 5px;
    width: 100%;
}

button {
    padding: 12px 20px;
    background-color: #0072ff;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
}

button:hover {
    background-color: #0056b3;
}

.error-message {
    color: red;
    font-weight: bold;
    margin-bottom: 15px;
}

@media (max-width: 768px) {
    .container {
        width: 90%;
    }

    h1 {
        font-size: 24px;
    }

    input[type="text"],
    input[type="number"],
    input[type="date"],
    select {
        font-size: 14px;
    }

    button {
        font-size: 14px;
    }
}

</style>
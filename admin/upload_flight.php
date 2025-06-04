<?php
// Include authentication file
include('auth.php');

// Check if the user is not an admin, redirect to login page
if (!isAdmin()) {
    header("Location: admin_login.php");
    exit();
}

include('db_connection.php');

// Handle form submission (uploading flight data)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $flight_number = $_POST['flight_number'];
    $departure_location = $_POST['departure_location'];
    $departure_date = $_POST['departure_date'];
    $arrival_location = $_POST['arrival_location'];
    $arrival_date = $_POST['arrival_date'];
    $price = $_POST['price'];

    // Generate a unique code based on the departure location
    $unique_code = md5($departure_location); // This will generate a constant unique code for each departure location

    try {
        // Prepare and execute the SQL query
        $stmt = $conn->prepare("INSERT INTO flights (flight_number, departure_location, unique_code, arrival_location, departureDate, arrival_date, price) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$flight_number, $departure_location, $unique_code, $arrival_location, $departure_date, $arrival_date, $price]);

        echo "Flight uploaded successfully!";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Flight</title>
    <link rel="stylesheet" href="css/upload.css">
</head>
<body>
    <h1>Upload Flight Details</h1>

    <!-- Form to upload flight details -->
    <form action="upload_flight.php" method="POST">
        <label for="flight_number">Flight Number:</label>
        <input type="text" id="flight_number" name="flight_number" required><br><br>

        <label for="departure_location">Departure Location:</label>
        <input type="text" id="departure_location" name="departure_location" required><br><br>

        <label for="departure_date">Departure Date:</label>
        <input type="date" id="departure_date" name="departure_date" required><br><br>

        <label for="arrival_location">Arrival Location:</label>
        <input type="text" id="arrival_location" name="arrival_location" required><br><br>

        <label for="arrival_date">Arrival Date:</label>
        <input type="date" id="arrival_date" name="arrival_date" required><br><br>

        <label for="price">Price:</label>
        <input type="number" step="0.01" id="price" name="price" required><br><br>

        <button type="submit">Upload Flight</button>
    </form>
</body>
</html>
<style>
    /* upload_flight_style.css */
body {
    font-family: 'Arial', sans-serif;
    background-color: #f0f2f5;
    margin: 0;
    padding: 0;
}

.container {
    width: 75%;
    margin: 30px auto;
    background: #fff;
    border-radius: 12px;
    padding: 30px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

h1 {
    text-align: center;
    font-size: 2em;
    color: #333;
}

form {
    display: flex;
    flex-direction: column;
}

form label {
    font-weight: bold;
    margin-bottom: 8px;
}

form input {
    padding: 10px;
    margin-bottom: 20px;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 16px;
}

form input:focus {
    border-color: #007bff;
    box-shadow: 0 0 8px rgba(0, 123, 255, 0.3);
}

button {
    padding: 12px 25px;
    background-color: #4CAF50;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

button:hover {
    background-color: #45a049;
}

/* Responsive Design */
@media (max-width: 768px) {
    form input {
        font-size: 14px;
        padding: 8px;
    }

    button {
        font-size: 14px;
    }
}

</style>
<?php
session_start();
include('db_connection.php');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php'); // Redirect to the login page if not logged in
    exit();
}

// Get logged-in user's details
$user_id = $_SESSION['user_id'];
try {
    $stmt = $conn->prepare("SELECT name, email FROM users WHERE id = ?");
    $stmt->execute([$user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        // Log the error and redirect to an error page
        error_log("Error: User with ID $user_id not found.");
        header('Location: error_page.php');
        exit();
    }
} catch (PDOException $e) {
    error_log("Database error while fetching user details: " . $e->getMessage());
    header('Location: error_page.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book a Flight</title>
    <style>
        /* General Styles */
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(to bottom right, #d4d8dd, #b0b7c1);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .container {
            width: 100%;
            max-width: 700px;
            padding: 20px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        h1 {
            text-align: center;
            color: #444;
            margin-bottom: 20px;
        }

        form {
            display: grid;
            gap: 15px;
        }

        label {
            font-weight: bold;
            color: #555;
        }

        input,
        select,
        button {
            padding: 12px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        button {
            background: linear-gradient(to right, #4caf50, #388e3c);
            color: white;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s ease-in-out;
        }

        button:hover {
            background: linear-gradient(to right, #388e3c, #4caf50);
        }

        .total-price {
            font-weight: bold;
            color: #333;
            text-align: right;
            font-size: 18px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Book a Flight</h1>
        <form id="bookingForm" action="process_booking.php" method="POST">

            <label for="user_id">User:</label>
            <input type="text" id="user_id" name="user_id" value="<?php echo htmlspecialchars($user['name']); ?>" readonly>

            <label for="arrival_city">Select Arrival City:</label>
            <select id="arrival_city" name="arrival_location" required>
                <option value="">-- Select Arrival City --</option>
                <?php
                try {
                    $arrivalCities = $conn->query("SELECT DISTINCT arrival_location FROM flights");
                    while ($row = $arrivalCities->fetch(PDO::FETCH_ASSOC)) {
                        echo "<option value='{$row['arrival_location']}'>{$row['arrival_location']}</option>";
                    }
                } catch (PDOException $e) {
                    error_log("Database error while loading arrival cities: " . $e->getMessage());
                    echo "<option disabled>Error loading cities</option>";
                }
                ?>
            </select>

            <label for="flight_id">Select Flight:</label>
            <select id="flight_id" name="flight_id" onchange="updatePrice()" required>
                <option value="">-- Select Flight --</option>
                <?php
                try {
                    $flights = $conn->query("SELECT id, departure_location, arrival_location, departureDate, price FROM flights");
                    while ($row = $flights->fetch(PDO::FETCH_ASSOC)) {
                        $flight_info = "From {$row['departure_location']} to {$row['arrival_location']} on {$row['departureDate']} - $" . number_format($row['price'], 2);
                        echo "<option value='{$row['id']}' data-price='{$row['price']}'>$flight_info</option>";
                    }
                } catch (PDOException $e) {
                    error_log("Database error while loading flights: " . $e->getMessage());
                    echo "<option disabled>Error loading flights</option>";
                }
                ?>
            </select>

            <label for="passengers">Number of Passengers:</label>
            <input type="number" id="passengers" name="passengers" min="1" onchange="updatePrice()" required>

            <label for="total_price">Total Price:</label>
            <input type="text" id="total_price" name="total_price" readonly placeholder="Calculated automatically">

            <label for="payment_status">Payment Status:</label>
            <select id="payment_status" name="payment_status" required>
                <option value="Pending">Pending</option>
                <option value="Paid">Paid</option>
                <option value="Cancelled">Cancelled</option>
            </select>

            <div class="total-price" id="calculatedPrice"></div>
            <button type="submit">Book Flight</button>
        </form>
    </div>

    <script>
        function updatePrice() {
            const flightDropdown = document.getElementById('flight_id');
            const passengersInput = document.getElementById('passengers');
            const totalPriceInput = document.getElementById('total_price');

            const selectedFlight = flightDropdown.options[flightDropdown.selectedIndex];
            const flightPrice = parseFloat(selectedFlight.getAttribute('data-price')) || 0;
            const passengers = parseInt(passengersInput.value) || 1;

            const totalPrice = flightPrice * passengers;
            totalPriceInput.value = totalPrice.toFixed(2);

            document.getElementById('calculatedPrice').innerText = `Total: $${totalPrice.toFixed(2)}`;
        }
    </script>
</body>

</html>

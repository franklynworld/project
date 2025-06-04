<?php
// Include authentication file
include('auth.php');

// Check if the user is not an admin, redirect to login page
if (!isAdmin()) {
    header("Location: admin_login.php");
    exit();
}

include('db_connection.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="css/admin_dashboard.css">
</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <h2>Admin Panel</h2>
                <p>Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?></p>
            </div>
            <nav>
                <ul>
                    <li><a href="manage_users.php">Manage Users</a></li>
                    <li><a href="upload_flight.php">Upload Flight</a></li>
                    <li><a href="manage_flights.php">Manage Flights</a></li>
                    <li><a href="view_bookings.php">View Bookings</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <header class="main-header">
                <h1>Manage Flights</h1>
            </header>

            <section class="recent-activity">
                <h2>Flight List</h2>
                <table class="flights-table">
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
                        <?php
                        $stmt = $conn->query("SELECT * FROM flights ORDER BY departureDate DESC");
                        while ($flight = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo "<tr>";
                            echo "<td>{$flight['flight_number']}</td>";
                            echo "<td>{$flight['departure_location']}</td>";
                            echo "<td>{$flight['arrival_location']}</td>";
                            echo "<td>\${$flight['price']}</td>";
                            echo "<td><a href='edit_flight.php?id={$flight['id']}'>Edit</a> | <a href='delete_flight.php?id={$flight['id']}'>Delete</a></td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </section>
        </main>
    </div>
</body>
</html>

<style>
    /* Basic Reset and Layout */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: Arial, sans-serif;
    background-color: #f9f9f9;
}

.dashboard-container {
    display: flex;
}

.sidebar {
    width: 250px;
    background-color: #2c3e50;
    color: white;
    padding: 20px;
    height: 100vh;
}

.sidebar h2 {
    margin-bottom: 20px;
}

.sidebar nav ul {
    list-style: none;
}

.sidebar nav ul li {
    margin: 15px 0;
}

.sidebar nav ul li a {
    color: white;
    text-decoration: none;
    font-size: 16px;
}

.sidebar nav ul li a:hover {
    color: #3498db;
}

.main-content {
    width: 100%;
    padding: 20px;
}

.main-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background-color: #fff;
    padding: 15px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

.main-header h1 {
    color: #2c3e50;
}

.logout-container a {
    color: #e74c3c;
    text-decoration: none;
}

.logout-container a:hover {
    text-decoration: underline;
}

.overview {
    display: flex;
    justify-content: space-between;
    margin-bottom: 30px;
}

.overview-item {
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    width: 30%;
    text-align: center;
}

.overview-item h3 {
    margin-bottom: 10px;
    color: #3498db;
}

.overview-item p {
    font-size: 24px;
    font-weight: bold;
}

.recent-activity {
    margin-top: 20px;
}

.recent-activity h2 {
    margin-bottom: 20px;
    color: #2c3e50;
}

.flights-table {
    width: 100%;
    border-collapse: collapse;
}

.flights-table th, .flights-table td {
    padding: 12px;
    text-align: left;
    border: 1px solid #ddd;
}

.flights-table th {
    background-color: #3498db;
    color: white;
}

.flights-table a {
    color: #e74c3c;
    text-decoration: none;
}

.flights-table a:hover {
    text-decoration: underline;
}

</style>
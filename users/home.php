<?php
// Start the session to check if the user is logged in
session_start();

// Include the database connection
include('db_connection.php');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit();
}

// Get the logged-in user's details
$user_id = $_SESSION['user_id'];
$query = "SELECT name FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Skylink</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* General Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to bottom right, #f0f4f8, #dfe6ec);
            color: #333;
            line-height: 1.6;
        }

        header {
            background: #0056b3;
            color: white;
            padding: 15px 0;
        }

        .container {
            width: 90%;
            max-width: 1200px;
            margin: auto;
        }

        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        nav a {
            text-decoration: none;
            color: white;
            font-weight: bold;
            padding: 8px 15px;
            border-radius: 5px;
            transition: background 0.3s;
        }

        nav a:hover {
            background: #004494;
        }

        .welcome-section {
            text-align: center;
            margin: 50px 0;
        }

        .welcome-section h1 {
            font-size: 2.5rem;
            margin-bottom: 10px;
        }

        .welcome-section p {
            font-size: 1.2rem;
            color: #555;
        }

        .nav-links {
            display: flex;
            gap: 20px;
        }

        .content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin: 30px 0;
        }

        .card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            text-align: center;
        }

        .card h2 {
            margin-bottom: 10px;
            color: #0056b3;
        }

        .card p {
            margin-bottom: 15px;
            color: #555;
        }

        .card a {
            display: inline-block;
            background: #0056b3;
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 5px;
            transition: background 0.3s;
        }

        .card a:hover {
            background: #004494;
        }

        footer {
            text-align: center;
            padding: 15px;
            background: #0056b3;
            color: white;
            margin-top: 30px;
        }
    </style>
</head>

<body>

    <header>
        <div class="container">
            <nav>
                <h1>Skylink</h1>
                <div class="nav-links">
                    <a href="book_flight.php">Booking</a>
                    <a href="logout.php">Logout</a>
                </div>
            </nav>
        </div>
    </header>

    <section class="welcome-section">
        <div class="container">
            <h1>Welcome, <?php echo htmlspecialchars($user['name']); ?>!</h1>
            <p>Explore your Skylink account and manage your flights with ease.</p>
        </div>
    </section>

    <section class="content">
        <div class="container">
            <div class="card">
                <h2>Book a Flight</h2>
                <p>Find the perfect flight for your next journey.</p>
                <a href="book_flight.php">Book Now</a>
            </div>
        </div>
    </section>

    <footer>
        <p>&copy; 2024 Skylink. All rights reserved.</p>
    </footer>

</body>

</html>
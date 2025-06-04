<?php
// Database credentials
define('DB_SERVER', 'localhost');       // Database server (e.g., 'localhost')
define('DB_USERNAME', 'root');          // Your database username
define('DB_PASSWORD', '');              // Your database password
define('DB_NAME', 'skylink');           // Your database name

// Stripe API keys
define('STRIPE_SECRET_KEY', 'your_stripe_secret_key_here'); // Secret key (replace with actual)
define('STRIPE_PUBLISHABLE_KEY', 'your_stripe_publishable_key_here'); // Publishable key (replace with actual)

// Database connection
try {
    $conn = new PDO("mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME, DB_USERNAME, DB_PASSWORD);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("ERROR: Could not connect. " . $e->getMessage());
}
?>

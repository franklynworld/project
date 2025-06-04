<?php
// Start the session
session_start();

// Include the database connection
include('db_connection.php');  // Ensure this is correct path to your db_connection.php

// Handle the login process
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare the query to fetch user data by email
    $stmt = $conn->prepare("SELECT id, email, password FROM users WHERE email = ?");
    $stmt->execute([$email]);

    // Fetch the user data (no need for PDO::FETCH_ASSOC)
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        // Store user ID in session
        $_SESSION['user_id'] = $user['id'];
    
        // Redirect to the User Dashboard
        header("Location: home.php");
        exit();
    } else {
        $error = "Invalid email or password!";
    }
    
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../css/login.css">
</head>
<body>
    <div class="container">
        <h1>Login</h1>
        <form action="login.php" method="POST">
            <?php
            if (isset($error)) {
                echo "<div class='error-message'>{$error}</div>";
            }
            ?>
            <label for="email">Email:</label>
            <input type="email" name="email" required placeholder="Enter your email">

            <label for="password">Password:</label>
            <input type="password" name="password" required placeholder="Enter your password">

            <button type="submit">Login</button>
        </form>
        <a href="register.php">Don't have an account? Register</a>
    </div>
</body>
</html>

<?php
// Start the session to keep track of the login state
session_start();

// Include the database connection
include('db_connection.php');

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if the user exists and is an admin
    $stmt = $conn->prepare("SELECT id, name, email, password, is_admin FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password']) && $user['is_admin'] == 1) {
        // If user exists and password is correct, store user info in session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['is_admin'] = $user['is_admin'];

        // Redirect to the admin dashboard or homepage
        header("Location: dashboard.php");
        exit();
    } else {
        // If credentials are incorrect, show an error message
        $error = "Invalid email or password. Make sure you're an admin.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
    <div class="container">
        <h1>Admin Login</h1>
        <form action="admin_login.php" method="POST">
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
        <a href="admin_register.php">Don't have an account? Register</a>
    </div>
</body>
</html>

<style>
    /* Basic styles */
body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
}

.container {
    background-color: white;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    width: 100%;
    max-width: 400px;
}

h1 {
    text-align: center;
    margin-bottom: 20px;
}

label {
    font-weight: bold;
    display: block;
    margin-bottom: 5px;
}

input[type="email"], input[type="password"] {
    width: 100%;
    padding: 10px;
    margin: 10px 0 20px 0;
    border: 1px solid #ddd;
    border-radius: 5px;
}

button {
    width: 100%;
    padding: 12px;
    background-color: #4caf50;
    color: white;
    border: none;
    border-radius: 5px;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

button:hover {
    background-color: #45a049;
}

.error-message {
    color: red;
    text-align: center;
    margin-bottom: 15px;
}

a {
    text-align: center;
    display: block;
    margin-top: 10px;
    text-decoration: none;
    color: #007bff;
}

</style>
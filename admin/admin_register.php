<?php
// Include the database connection
include('db_connection.php');

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if email already exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);

    // Use fetch() without any argument
    $existing_user = $stmt->fetch();

    if ($existing_user) {
        $error = "Email is already registered.";
    } else {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert new admin user into the database with is_admin = 1
        $stmt = $conn->prepare("INSERT INTO users (name, email, password, is_admin) VALUES (?, ?, ?, ?)");
        $stmt->execute([$name, $email, $hashed_password, 1]);

        // Redirect to login page after successful registration
        header("Location: admin_login.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Register</title>
</head>
<body>
    <div class="container">
        <h1>Create an Admin Account</h1>
        <form action="admin_register.php" method="POST">
            <?php
            if (isset($error)) {
                echo "<div class='error-message'>{$error}</div>";
            }
            ?>
            <label for="name">Full Name:</label>
            <input type="text" name="name" required placeholder="Enter your full name">

            <label for="email">Email:</label>
            <input type="email" name="email" required placeholder="Enter your email">

            <label for="password">Password:</label>
            <input type="password" name="password" required placeholder="Enter your password">

            <button type="submit">Register</button>
        </form>
        <a href="admin_login.php">Already have an account? Login</a>
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

input[type="text"], input[type="email"], input[type="password"] {
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

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

        // Insert new user into the database
        $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        $stmt->execute([$name, $email, $hashed_password]);

        // Redirect to login page after successful registration
        header("Location: home.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="../css/register.css">
</head>
<body>
    <div class="container">
        <h1>Create an Account</h1>
        <form action="register.php" method="POST">
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
        <a href="login.php">Already have an account? Login</a>
    </div>
</body>
</html>

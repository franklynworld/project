<?php
// Include authentication file
include('auth.php');
include('db_connection.php');

// Check if the user is not an admin, redirect to login page
if (!isAdmin()) {
    header("Location: admin_login.php");
    exit();
}

// Check if 'id' is set in the URL
if (!isset($_GET['id'])) {
    echo "No user ID provided.";
    exit();
}

$user_id = $_GET['id'];

// Fetch user details from the database
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo "User not found.";
    exit();
}

// Handle form submission to update user details
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];

    $updateStmt = $conn->prepare("UPDATE users SET name = ?, email = ? WHERE id = ?");
    $updateStmt->execute([$name, $email, $user_id]);

    // Redirect to the manage users page
    header("Location: manage_users.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
</head>
<body>
    <h1>Edit User</h1>
    <form action="edit_user.php?id=<?php echo $user['id']; ?>" method="POST">
        <label for="name">Name:</label>
        <input type="text" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required><br>

        <label for="email">Email:</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required><br>

        <button type="submit">Update User</button>
    </form>
</body>
</html>
<style>
    /* edit_user.css */
body {
    font-family: 'Arial', sans-serif;
    background-color: #f4f4f9;
    margin: 0;
    padding: 0;
}

.container {
    width: 60%;
    margin: 50px auto;
    background: #fff;
    border-radius: 10px;
    padding: 30px;
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
}

h1 {
    text-align: center;
    color: #333;
    margin-bottom: 20px;
}

form {
    display: grid;
    gap: 20px;
}

label {
    font-weight: bold;
    color: #333;
}

input[type="text"],
input[type="email"] {
    padding: 12px;
    font-size: 16px;
    border: 1px solid #ddd;
    border-radius: 5px;
    width: 100%;
}

button {
    padding: 12px 20px;
    background-color: #4caf50;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
}

button:hover {
    background-color: #45a049;
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
    input[type="email"] {
        font-size: 14px;
    }

    button {
        font-size: 14px;
    }
}

</style>
<?php
// Include authentication file
include('auth.php');

// Check if the user is not an admin, redirect to login page
if (!isAdmin()) {
    header("Location: admin_login.php");
    exit();
}

include('db_connection.php');

// Fetch all users from the database
$stmt = $conn->query("SELECT * FROM users ORDER BY name");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <link rel="stylesheet" href="css/manage_users.css">
</head>
<body>
    <div class="container">
        <h1>Manage Users</h1>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($user['name']); ?></td>
                        <td><?php echo htmlspecialchars($user['email']); ?></td>
                        <td>
                            <a href="edit_user.php?id=<?php echo $user['id']; ?>">Edit</a> |
                            <a href="delete_user.php?id=<?php echo $user['id']; ?>" onclick="return confirm('Are you sure you want to delete this user?')">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
<style>
    /* manage_users_style.css */
body {
    font-family: 'Arial', sans-serif;
    background-color: #f1f3f5;
    margin: 0;
    padding: 0;
}

.container {
    width: 80%;
    margin: 30px auto;
    background: #fff;
    border-radius: 10px;
    padding: 20px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

h1 {
    text-align: center;
    color: #333;
    margin-bottom: 20px;
}

table {
    width: 100%;
    margin-top: 20px;
    border-collapse: collapse;
}

table th, table td {
    padding: 15px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

table th {
    background-color: #4CAF50;
    color: white;
}

table tr:hover {
    background-color: #f1f1f1;
}

button {
    padding: 10px 15px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

button:hover {
    background-color: #0056b3;
}

.error-message {
    color: red;
    font-weight: bold;
    margin-bottom: 15px;
}

/* Responsive Design */
@media (max-width: 768px) {
    table {
        font-size: 14px;
    }

    button {
        font-size: 14px;
    }
}

</style>
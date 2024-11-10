<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            header("Location: dashboard.php");
        } else {
            echo "<p style='color: red;'>Invalid password!</p>";
        }
    } else {
        echo "<p style='color: red;'>User not found!</p>";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #121212; /* Dark background */
            color: #e0e0e0; /* Light text */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh; /* Full height */
            margin: 0;
        }
        .container {
            background-color: #1e1e1e; /* Slightly lighter dark background */
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
            width: 300px; /* Fixed width for the form */
        }
        h1 {
            text-align: center;
            color: #76ff03; /* Bright green */
            margin-bottom: 20px;
        }
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #76ff03; /* Green border */
            border-radius: 5px;
            background-color: #2c2c2c; /* Dark input background */
            color: #e0e0e0; /* Light text */
        }
        input[type="text"]:focus,
        input[type="password"]:focus {
            border-color: #66bb03; /* Darker green on focus */
            outline: none; /* Remove outline */
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #76ff03; /* Bright green */
            border: none;
            border-radius: 5px;
            color: #121212; /* Dark text */
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #66bb03; /* Darker green on hover */
        }
        .register-link {
            display: block;
            text-align: center;
            margin-top: 10px;
            color: #76ff03; /* Bright green */
            text-decoration: none;
        }
        .register-link:hover {
            text-decoration: underline; /* Underline on hover */
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Login</h1>
        <form method="POST" action="">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
        <a href="register.php" class="register-link">Don't have an account? Register here</a>
    </div>
</body>
</html>

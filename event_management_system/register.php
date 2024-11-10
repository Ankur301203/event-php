<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $email = $_POST['email'];

    $stmt = $conn->prepare("INSERT INTO users (username, password, email) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $password, $email);

    if ($stmt->execute()) {
        echo "<p style='color: green;'>Registration successful! Redirecting to login...</p>";
        header("Refresh: 2; url=login.php"); // Redirect after 2 seconds
    } else {
        echo "<p style='color: red;'>Error: " . $stmt->error . "</p>";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
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
        input[type="password"],
        input[type="email"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #76ff03; /* Green border */
            border-radius: 5px;
            background-color: #2c2c2c; /* Dark input background */
            color: #e0e0e0; /* Light text */
        }
        input[type="text"]:focus,
        input[type="password"]:focus,
        input[type="email"]:focus {
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
    </style>
</head>
<body>
    <div class="container">
        <h1>Register</h1>
        <form method="POST" action="">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="email" name="email" placeholder="Email" required>
            <button type="submit">Register</button>
        </form>
    </div>
</body>
</html>

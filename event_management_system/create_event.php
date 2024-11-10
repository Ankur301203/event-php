<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $event_date = $_POST['event_date'];
    $user_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("INSERT INTO events (user_id, title, description, event_date) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $user_id, $title, $description, $event_date);

    if ($stmt->execute()) {
        header("Location: dashboard.php");
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Event</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #121212; /* Dark background */
            color: #e0e0e0; /* Light text */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh; /* Full viewport height */
            margin: 0;
        }
        .container {
            background-color: #1e1e1e; /* Slightly lighter dark background */
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
            width: 100%;
            max-width: 400px; /* Set a max width for the form */
        }
        h1 {
            text-align: center;
            color: #76ff03; /* Bright green for the heading */
            margin-bottom: 20px;
        }
        input[type="text"],
        input[type="datetime-local"],
        textarea {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #76ff03; /* Bright green border */
            border-radius: 5px;
            background-color: #2c2c2c; /* Darker background for inputs */
            color: #e0e0e0; /* Light text */
        }
        input[type="text"]:focus,
        input[type="datetime-local"]:focus,
        textarea:focus {
            outline: none;
            border-color: #76ff03; /* Highlight border on focus */
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #76ff03; /* Bright green */
            color: #121212; /* Dark text for contrast */
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #66bb03; /* Slightly darker green on hover */
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Create Event</h1>
        <form method="POST" action="">
            <input type="text" name="title" placeholder="Event Title" required>
            <textarea name="description" placeholder="Event Description" required></textarea>
            <input type="datetime-local" name="event_date" required>
            <button type="submit">Create Event</button>
        </form>
    </div>
</body>
</html>

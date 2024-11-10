<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$event_id = $_GET['id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $event_date = $_POST['event_date'];

    $stmt = $conn->prepare("UPDATE events SET title = ?, description = ?, event_date = ? WHERE id = ?");
    $stmt->bind_param("sssi", $title, $description, $event_date, $event_id);

    if ($stmt->execute()) {
        header("Location: dashboard.php");
    } else {
        echo "<p style='color: red;'>Error: " . $stmt->error . "</p>";
    }

    $stmt->close();
} else {
    $stmt = $conn->prepare("SELECT * FROM events WHERE id = ?");
    $stmt->bind_param("i", $event_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $event = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Event</title>
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
        input[type="datetime-local"],
        textarea {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #76ff03; /* Green border */
            border-radius: 5px;
            background-color: #2c2c2c; /* Dark input background */
            color: #e0e0e0; /* Light text */
        }
        input[type="text"]:focus,
        input[type="datetime-local"]:focus,
        textarea:focus {
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
        <h1>Edit Event</h1>
        <form method="POST" action="">
            <input type="text" name="title" value="<?= htmlspecialchars($event['title']) ?>" required>
            <textarea name="description" required><?= htmlspecialchars($event['description']) ?></textarea>
            <input type="datetime-local" name="event_date" value="<?= htmlspecialchars($event['event_date']) ?>" required>
            <button type="submit">Update Event</button>
        </form>
    </div>
</body>
</html>

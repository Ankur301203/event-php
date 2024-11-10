<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT * FROM events WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #121212; /* Dark background */
            color: #e0e0e0; /* Light text */
            display: flex;
            justify-content: center;
            padding: 20px;
        }
        .container {
            width: 100%;
            max-width: 600px;
            background-color: #1e1e1e; /* Slightly lighter dark background */
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
        }
        h1 {
            text-align: center;
            color: #76ff03; /* Bright green */
            margin-bottom: 20px;
        }
        .create-button {
            display: block;
            width: 100%;
            max-width: 200px;
            margin: 0 auto 20px;
            padding: 10px;
            background-color: #76ff03; /* Bright green */
            color: #121212; /* Dark text */
            text-align: center;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .create-button:hover {
            background-color: #66bb03; /* Darker green on hover */
        }
        ul {
            list-style-type: none;
            padding: 0;
        }
        li {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #2c2c2c; /* Darker background for list items */
            padding: 10px;
            margin: 8px 0;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }
        li a {
            color: #76ff03; /* Bright green for links */
            text-decoration: none;
            margin: 0 5px;
        }
        li a:hover {
            text-decoration: underline;
        }
        .actions {
            display: flex;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Your Events</h1>
        <a href="create_event.php" class="create-button">Create Event</a>
        <ul>
            <?php while ($event = $result->fetch_assoc()): ?>
                <li>
                    <span>
                        <a href="event_details.php?id=<?= $event['id'] ?>"><?= htmlspecialchars($event['title']) ?></a>
                    </span>
                    <span class="actions">
                        <a href="edit_event.php?id=<?= $event['id'] ?>">Edit</a>
                        <a href="delete_event.php?id=<?= $event['id'] ?>" onclick="return confirm('Are you sure you want to delete this event?')">Delete</a>
                    </span>
                </li>
            <?php endwhile; ?>
        </ul>
    </div>
</body>
</html>

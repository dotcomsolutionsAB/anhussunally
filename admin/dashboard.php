<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit;
}

$loggedInId = $_SESSION['id'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #e6e6fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .dashboard-container {
            background-color: #fff;
            padding: 30px 40px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 400px;
        }
        h2 {
            color: #333;
            margin-bottom: 15px;
        }
        p {
            color: #555;
            margin-bottom: 20px;
        }
        a {
            text-decoration: none;
            color: white;
            background-color: #007BFF;
            padding: 10px 15px;
            border-radius: 4px;
            font-weight: bold;
        }
        a:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <h2>Welcome to the Dashboard!</h2>
        <p>You are successfully logged in as: <strong><?php echo htmlspecialchars($loggedInId); ?></strong></p>
        <a href="logout.php">Logout</a>
    </div>
</body>
</html>

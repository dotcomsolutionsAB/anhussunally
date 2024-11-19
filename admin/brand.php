<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit;
}

include("../api/db_connection.php");

// Establish database connection
$conn = mysqli_connect($host, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch all brands from the brand table
$query = "SELECT * FROM brand";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Brands</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f8f8;
            padding: 20px;
            margin: 0;
        }
        .brand-container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .brand-item {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }
        .brand-item:last-child {
            border-bottom: none;
        }
        .brand-name {
            font-weight: bold;
            font-size: 18px;
            color: #333;
        }
        .brand-image {
            display: block;
            margin-top: 5px;
            width: 100px;
            height: auto;
        }
        .back-btn {
            display: inline-block;
            margin-top: 20px;
            padding: 8px 15px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            font-weight: bold;
        }
        .back-btn:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="brand-container">
        <h2>All Brands</h2>
        <?php
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<div class="brand-item">';
                echo '<div class="brand-name">' . htmlspecialchars($row['name']) . '</div>';
                if (!empty($row['image'])) {
                    echo '<img class="brand-image" src="' . htmlspecialchars($row['image']) . '" alt="' . htmlspecialchars($row['name']) . '">';
                }
                echo '</div>';
            }
        } else {
            echo "<p>No brands found.</p>";
        }
        ?>
        <a href="dashboard.php" class="back-btn">Back to Dashboard</a>
    </div>
</body>
</html>

<?php
// Close the connection
$conn->close();
?>

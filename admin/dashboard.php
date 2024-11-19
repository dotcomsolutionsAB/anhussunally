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
            margin: 0;
            padding: 0;
            display: flex;
            height: 100vh;
        }
        /* Sidebar styles */
        .sidebar {
            width: 250px;
            background-color: #333;
            color: white;
            padding-top: 20px;
            display: flex;
            flex-direction: column;
            height: 100vh;
        }
        .sidebar a {
            padding: 15px;
            text-decoration: none;
            color: white;
            display: block;
            font-size: 16px;
        }
        .sidebar a:hover {
            background-color: #575757;
        }
        /* Navbar styles */
        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
        }
        .navbar {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .navbar h2 {
            margin: 0;
        }
        .logout-btn {
            background-color: #ff4d4d;
            color: white;
            padding: 8px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
            text-decoration: none;
        }
        .logout-btn:hover {
            background-color: #e60000;
        }
        /* Content styles */
        .content {
            padding: 20px;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <a href="product.php">Products</a>
        <a href="brand.php">Brands</a>
        <a href="category.php">Category</a>
        <a href="">Edit</a>
    </div>

    <!-- Main content area -->
    <div class="main-content">
        <!-- Navbar -->
        <div class="navbar">
            <h2>Dashboard</h2>
            <a href="logout.php" class="logout-btn">Logout</a>
        </div>

        <!-- Content area -->
        <div class="content">
            <p>Welcome, <strong><?php echo htmlspecialchars($loggedInId); ?></strong>!</p>
            <p>Select an option from the sidebar to manage your items.</p>
        </div>
    </div>
</body>
</html>

<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: index.php');
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
    <?php include("admin_inc/sidebar.php"); ?>

    <!-- Main content area -->
    <div class="main-content">
        <!-- Navbar -->
        <?php include("admin_inc/header.php"); ?>

        <?php
            // Get the current script name
            $currentPage = basename($_SERVER['PHP_SELF']);

            // Check if the current page is 'dashboard.php'
            if ($currentPage === 'dashboard.php') {
        ?>
                <!-- Content area -->
                <div class="content">
                    <p>Welcome, <strong><?php echo htmlspecialchars($loggedInId); ?></strong>!</p>
                    <p>Select an option from the sidebar to manage your items.</p>
                </div>
        <?php
        }
        ?>

    </div>
</body>
</html>

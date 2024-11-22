<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: index.php');
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
            margin: 0;
            padding: 0;
            display: flex;
            height: 100vh;
        }
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
        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            padding: 20px;
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
            text-decoration: none;
            font-weight: bold;
        }
        .logout-btn:hover {
            background-color: #e60000;
        }
        .table-container {
            overflow-y: auto;
            max-height: 500px; /* Adjust the height as needed */
            margin-top: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        .logo-image {
            width: 100px;
            height: auto;
        }
        .action-btn {
            padding: 8px 12px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            font-size: 14px;
        }
        .action-btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <a href="dashboard.php">Dashboard</a>
        <a href="product.php">Products</a>
        <a href="brand.php">Brands</a>
        <a href="#">Category</a>
        <a href="#">Edit</a>
    </div>
    </div> <a href="add_brand.php">Add Brand</a></div>
    <div class="main-content">
        <div class="navbar">
            <h2>Brands</h2>
            <a href="logout.php" class="logout-btn">Logout</a>
        </div>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Logo</th>
                        <th>Created At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result && $result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                            echo "<td>";
                            if (!empty($row['logo'])) {
                                // Assuming the file path is in 'uploads' folder and 'logo' stores the unique ID
                                $logo_path = "../uploads/assets/logos/" . htmlspecialchars($row['logo']) .".". htmlspecialchars($row['extension']); // Modify the extension if needed
                                if (file_exists($logo_path)) {
                                    echo '<img class="logo-image" src="' . $logo_path . '" alt="Logo of ' . htmlspecialchars($row['name']) . '">';
                                } else {
                                    echo "No Logo";
                                }
                            } else {
                                echo "No Logo";
                            }
                            echo "</td>";
                            echo "<td>" . htmlspecialchars($row['created_at']) . "</td>";
                            echo '<td> 
                                    <form action="update_logo.php" method="POST" enctype="multipart/form-data" style="display: inline;">
                                        <input type="hidden" name="brand_id" value="' . htmlspecialchars($row['id']) . '">
                                        <input type="file" name="logo" accept="image/*" required style="margin-bottom: 5px;">
                                        <button type="submit" class="action-btn">Up Logo</button>
                                    </form>
                                 </td>';
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>No brands found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>

<?php
// Close the connection
$conn->close();
?>

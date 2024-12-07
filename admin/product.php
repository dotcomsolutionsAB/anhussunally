<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: index.php');
    exit;
}

include("../connection/db_connect.php");

// Establish database connection
$conn = mysqli_connect($host, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch all products with their brand names from the products and brand tables
$query = "SELECT products.*, brand.name AS brand_name 
          FROM products 
          LEFT JOIN brand ON products.brand_id = brand.id";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Products</title>
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
        .image-preview {
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
        <a href="upload_files.php">Uploads</a>
    </div>
    <div class="main-content">
        <div class="navbar">
            <h2>Products</h2>
            <a href="logout.php" class="logout-btn">Logout</a>
        </div>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>SKU</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Brand Name</th>
                        <th>Category</th>
                        <th>Image</th>
                        <th>Weight (Kgs)</th>
                        <th>Dimensions (L x B x H cm)</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result && $result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['sku']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['description']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['brand_name']) . "</td>"; // Display brand name
                            echo "<td>" . htmlspecialchars($row['category']) . "</td>";
                            echo "<td>";
                            if (!empty($row['image_url'])) {
                                echo '<img class="image-preview" src="' . htmlspecialchars($row['image_url']) . '" alt="' . htmlspecialchars($row['name']) . '">';
                            } else {
                                echo "No Image";
                            }
                            echo "</td>";
                            echo "<td>" . htmlspecialchars($row['weight']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['length']) . " x " . htmlspecialchars($row['breadth']) . " x " . htmlspecialchars($row['height']) . "</td>";
                            echo '<td><a href="#" class="action-btn">Action</a></td>';
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='10'>No products found.</td></tr>";
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

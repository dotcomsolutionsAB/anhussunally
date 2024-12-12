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

    // Fetch all products with their associated brand, category names, and images
    $query = "
        SELECT 
            products.*, 
            brand.name AS brand_name, 
            categories.name AS category_name 
        FROM products 
        LEFT JOIN brand ON products.brand_id = brand.id 
        LEFT JOIN categories ON products.category_id = categories.id";
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
            margin-top: 20px;
        }
    </style>
    <style>
        .table-container {
            overflow-y: auto;
            margin-top: 20px;
        }
        table {
            width: 85vw; /* Ensure table width is 100% of the viewport width */
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
		.name{
            width: 60px; /* Limit image width to match column */
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
        .delete-btn {
            background-color: #FF0000;
        }
        .delete-btn:hover {
            background-color: #CC0000;
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
        
    <div class="search-bar">
        <input type="text" id="searchInput" placeholder="Search by Name, SKU, or Brand">
    </div>
    <div id="searchResults" class="table-container">
        <!-- Search results will be displayed here -->
    </div>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Brand Name / Category</th>
                        <th>Images</th>
                        <th>Weight (Kgs) / Dimensions (L x B x H cm)</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result && $result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            // Fetch image URLs
                            $images = [];
                            if (!empty($row['images'])) {
                                $imageIds = array_filter(explode(',', $row['images']));
                                foreach ($imageIds as $imageId) {
                                    $imageQuery = "SELECT file_original_name FROM upload WHERE id = $imageId";
                                    $imageResult = $conn->query($imageQuery);
                                    if ($imageResult && $imageResult->num_rows > 0) {
                                        $imageRow = $imageResult->fetch_assoc();
                                        $images[] = "../uploads/assets/" . htmlspecialchars($imageRow['file_original_name']);
                                    }
                                }
                            }

                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                            echo "<td class='name'>" . htmlspecialchars($row['name']) ."<br> SKU : ". htmlspecialchars($row['sku']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['short_description'] ?? '') . "</td>";
                            echo "<td>" . htmlspecialchars($row['brand_name']) ."<br> / ". htmlspecialchars($row['category_name']) . "</td>";
                            echo "<td>";
                            if (!empty($images)) {
                                foreach ($images as $image) {
                                    echo '<img class="image-preview" src="' . htmlspecialchars($image) . '" alt="' . htmlspecialchars($row['name']) . '">';
                                }
                            } else {
                                echo "No Image";
                            }
                            echo "</td>";
                            echo "<td>" . htmlspecialchars($row['weight']) ."kg"."<br> / ". htmlspecialchars($row['length']) . " x " . htmlspecialchars($row['breadth']) . " x " . htmlspecialchars($row['height']) . "</td>";
                            echo '<td style=" display: flex; justify-content: space-between; flex-direction: column; align-items: center;">
                                    <a href="update_product.php?id=' . htmlspecialchars($row['id']) . '" class="action-btn">Update</a>
                                    <br>
                                    <a href="delete_product.php?id=' . htmlspecialchars($row['id']) . '" class="action-btn delete-btn" onclick="return confirm(\'Are you sure you want to delete this product?\')">Delete</a>
                                  </td>';
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
<script>
    document.getElementById("searchInput").addEventListener("input", function () {
            const query = this.value.trim();
            const resultsContainer = document.getElementById("searchResults");

            // Clear previous results if query length is less than 2
            if (query.length < 2) {
                resultsContainer.innerHTML = "";
                return;
            }

            // Fetch results from the server
            fetch(`search_products.php?query=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(data => {
                    // Clear existing results
                    resultsContainer.innerHTML = "";

                    // Build table if there are results
                    if (data.length > 0) {
                        const table = document.createElement("table");
                        table.innerHTML = `
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Brand Name / Category</th>
                                    <th>Images</th>
                                    <th>Weight (Kgs) / Dimensions (L x B x H cm)</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${data
                                    .map(
                                        product => `
                                    <tr>
                                        <td>${product.id}</td>
                                        <td>${product.name}<br>SKU: ${product.sku}</td>
                                        <td>${product.short_description || ""}</td>
                                        <td>${product.brand_name}<br>/ ${product.category_name}</td>
                                        <td>
                                            ${
                                                product.images
                                                    ? product.images
                                                        .split(",")
                                                        .map(
                                                            image =>
                                                                `<img class="image-preview" src="../uploads/assets/${image.trim()}" alt="${product.name}">`
                                                        )
                                                        .join("")
                                                    : "No Image"
                                            }
                                        </td>
                                        <td>${product.weight || ""}kg<br>/ ${product.length || ""} x ${product.breadth || ""} x ${product.height || ""}</td>
                                        <td>
                                            <a href="update_product.php?id=${product.id}" class="action-btn">Update</a><br>
                                            <a href="delete_product.php?id=${product.id}" class="action-btn delete-btn" onclick="return confirm('Are you sure you want to delete this product?')">Delete</a>
                                        </td>
                                    </tr>`
                                    )
                                    .join("")}
                            </tbody>
                        `;
                        resultsContainer.appendChild(table);
                    } else {
                        resultsContainer.innerHTML = "<p>No results found.</p>";
                    }
                })
                .catch(error => console.error("Error fetching search results:", error));
        });

</script>
</body>
</html>

<?php
// Close the connection
$conn->close();
?>

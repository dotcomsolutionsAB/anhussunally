<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Database configuration
$host = 'localhost';
$dbname = 'anhuszzw_html';
$username = 'anhuszzw_html';
$password = '9kCuzrb5tO53$xQtf';

// Connect to the database
$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle file upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image'])) {
    $uploadDir = "../uploads/assets/";
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    foreach ($_FILES['image']['tmp_name'] as $key => $tmpName) {
        $originalName = $_FILES['image']['name'][$key];
        $uniqueName = uniqid() . "_" . basename($originalName);
        $originalName=$uniqueName;
        $targetFile = $uploadDir . $uniqueName;

        if (move_uploaded_file($tmpName, $targetFile)) {
            $fileSize = $_FILES['image']['size'][$key];
            $extension = pathinfo($originalName, PATHINFO_EXTENSION);
            $type = mime_content_type($targetFile);
            $userId = 1; // Replace with the current user's ID if available

            // Insert file metadata into the database
            $stmt = $conn->prepare("INSERT INTO upload (file_original_name, image_link, user_id, file_size, extension, type, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, NOW(), NOW())");
            $stmt->bind_param("ssisss", $originalName, $targetFile, $userId, $fileSize, $extension, $type);
            $stmt->execute();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Image Gallery</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            height: 100vh;
            background-color: #f9f9f9;
        }
        /* Sidebar styles */
        .sidebar {
            width: 140px;
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
        /* Main content styles */
        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            padding: 5px 10px;
        }
        .navbar {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
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
    </style>
    <style>
        /* Dashboard Info */
        .dashboard-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .dashboard-card {
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 15px;
            width: 30%;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .dashboard-card h3 {
            margin: 0;
            font-size: 18px;
        }
        .dashboard-card input {
            width: 60%;
            padding: 8px;
            margin-top: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .upload-area {
            border: 2px dashed #ccc;
            border-radius: 5px;
            padding: 20px;
            text-align: center;
            cursor: pointer;
            background-color: #fff;
            margin-bottom: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .upload-area.dragover {
            background-color: #f0f8ff;
        }
        .upload-form button {
            padding: 10px 20px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .upload-form button:hover {
            background-color: #0056b3;
        }
        /* Gallery styles */
        .gallery {
            display: flex;
            flex-wrap: wrap;
            gap: 0px;
            margin-top: 20px;
            background: wheat;
            overflow: scroll;
        }
        .gallery-item {
            width: 200px;
            border: 1px solid #ddd;
            border-radius: 5px;
            overflow: hidden;
            background-color: #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 9px;
        }
        .gallery-item img {
            width: 100%;
            height: 150px;
            object-fit: cover;
        }
        .gallery-item .gallery-buttons {
            display: flex;
            justify-content: space-around;
            padding: 10px;
            width: 100%;
        }
        .gallery-item button {
            padding: 5px 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }
        .gallery-item button.delete-btn {
            background-color: #ff4d4d;
        }
        .gallery-item button:hover {
            opacity: 0.9;
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

    <!-- Dashboard Info -->
    <div class="dashboard-info">
        <div class="dashboard-card" style="width: 10%;">
            <h3>Total Images</h3>
            <p>
                <?php
                $imageCount = $conn->query("SELECT COUNT(*) AS count FROM upload WHERE deleted_at IS NULL")->fetch_assoc()['count'];
                echo $imageCount;
                ?>
            </p>
        </div>
        <div class="dashboard-card" style="width: 10%;">
            <h3>Duplicate Names</h3>
            <p>
                <?php
                $duplicateCountQuery = $conn->query("SELECT file_original_name, COUNT(*) AS count FROM upload GROUP BY file_original_name HAVING COUNT(file_original_name) > 1");
                $duplicateCount = $duplicateCountQuery->num_rows;
                echo $duplicateCount;
                ?>
            </p>
            <button onclick="showDuplicates()">Show Duplicates</button>
        </div>
        <div class="dashboard-card">
            <h3>Set Upload Path</h3>
            <form method="POST">
                <input type="text" name="upload_path" placeholder="Default is ../uploads/assets/" value="../uploads/assets/" required>
                <button type="submit">Set Path</button>
            </form>
        </div>
        <div class="drag-drop">
            <!-- Upload Form -->
            <div class="upload-area" id="uploadArea" style=" width: 25vw;">
                Drag & Drop Images Here or Click to Upload
            </div>
            <form class="upload-form" method="POST" enctype="multipart/form-data">
                <input type="file" name="image[]" id="fileInput" multiple>
                <button type="submit">Upload Images</button>
            </form>
        </div>
    </div>
    <!-- Search Bar -->
    <div class="search-bar">
        <form method="GET">
            <input type="text" name="search_query" placeholder="Search file name..." value="<?php echo isset($_GET['search_query']) ? $_GET['search_query'] : ''; ?>" required>
            <button type="submit">Search</button>
        </form>
    </div>
    <!-- Search Results -->
    <!-- Search Results -->
<div class="search-results">
    <?php
    if (isset($_GET['search_query'])) {
        $searchQuery = $conn->real_escape_string($_GET['search_query']);
        $searchResults = $conn->query("SELECT * FROM upload WHERE file_original_name LIKE '%$searchQuery%' AND deleted_at IS NULL");

        if ($searchResults->num_rows > 0) {
            echo "<ul style='list-style: none; padding: 0; display: flex;'>";
            while ($row = $searchResults->fetch_assoc()) {
                $id = $row['id'];
                $fileName = htmlspecialchars($row['file_original_name']);
                $filePath = "../uploads/assets/" . $fileName;

                echo "<li style='margin-bottom: 10px;'>";
                echo "<div class='gallery-item' id='item-{$id}' style='display: flex; flex-direction: column; align-items: center;'>";
                echo "<img src='{$filePath}' alt='{$fileName}' style='width: 100px; height: auto; display: block; margin-bottom: 5px;'>";
                echo "<div class='gallery-buttons'>";
                echo "<button class='details-btn' onclick='viewDetails({$id})'>Details</button>";
                echo "<button class='delete-btn' onclick='deleteItem({$id})'>Delete</button>";
                echo "</div>";
                echo "</div>";
                echo "</li>";
            }
            echo "</ul>";
        } else {
            echo "<p>No files found matching '$searchQuery'</p>";
        }
    }
    ?>
</div>

    
    <!-- Modal for displaying duplicates -->
<div id="duplicatesModal" style="display:none; position:fixed; top:10%; left:10%; background:white; padding:20px; border:1px solid black; z-index:1000; width:80%; height:80%; overflow:auto;">
    <h3>Duplicate Files</h3>
    <table border="1" style="width:100%; border-collapse:collapse;">
        <thead>
            <tr>
                <th>File Name</th>
                <th>Count</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Populate the table with duplicate file names
            if ($duplicateCount > 0) {
                while ($row = $duplicateCountQuery->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['file_original_name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['count']) . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='2'>No duplicate files found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
    <button onclick="closeModal()">Close</button>
</div>


    <style>
        /* Popup styling */
        .popup {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .popup-content {
            background: white;
            padding: 20px;
            border-radius: 5px;
            width: 50%;
            max-height: 80%;
            overflow-y: auto;
            position: relative;
        }

        .popup-content .close-btn {
            position: absolute;
            top: 10px;
            right: 15px;
            font-size: 20px;
            cursor: pointer;
            color: red;
        }

    </style>
    <!-- Popup for Details -->
    <div id="detailsPopup" class="popup" style="display: none;">
        <div class="popup-content">
            <span class="close-btn" onclick="closePopup()">&times;</span>
            <div id="popupDetails"></div>
        </div>
    </div>

    <!-- Image Gallery -->
    <div class="gallery">
        <?php
            // Fetch images from the database
            $result = $conn->query("SELECT * FROM upload WHERE deleted_at IS NULL ORDER BY created_at DESC");
            while ($row = $result->fetch_assoc()) {
                $id = $row['id'];
                $fileName = htmlspecialchars($row['file_original_name']);
                $filePath = "../uploads/assets/" . $fileName;
                echo '<div class="gallery-item" id="item-' . $id . '">';
                echo '<img src="' . $filePath . '" alt="' . $fileName . '">';
                echo '<div class="gallery-buttons">';
                echo '<button class="details-btn" onclick="viewDetails(' . $id . ')">Details</button>';
                echo '<button class="delete-btn" onclick="deleteItem(' . $id . ')">Delete</button>';
                echo '</div>';
                echo '</div>';
            }
        ?>
    </div>
</div>

<script>
    // JavaScript to handle modal display
    function showDuplicates() {
        document.getElementById('duplicatesModal').style.display = 'block';
    }

    function closeModal() {
        document.getElementById('duplicatesModal').style.display = 'none';
    }
</script>

<script>
    const uploadArea = document.getElementById('uploadArea');
    const fileInput = document.getElementById('fileInput');

    // Drag and Drop Events
    uploadArea.addEventListener('click', () => fileInput.click());
    uploadArea.addEventListener('dragover', (e) => {
        e.preventDefault();
        uploadArea.classList.add('dragover');
    });
    uploadArea.addEventListener('dragleave', () => uploadArea.classList.remove('dragover'));
    uploadArea.addEventListener('drop', (e) => {
        e.preventDefault();
        uploadArea.classList.remove('dragover');
        const files = e.dataTransfer.files;
        fileInput.files = files;
        document.querySelector('.upload-form').submit();
    });
</script>

<script>
    // Delete Function
    function deleteItem(id) {
        if (confirm("Are you sure you want to delete this item?")) {
            fetch('delete_up_file.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById(`item-${id}`).remove();
                    alert("Item deleted successfully!");
                } else {
                    alert("Failed to delete item.");
                }
            })
            .catch(error => console.error("Error:", error));
        }
    }

    // View Details Function
    function viewDetails(id) {
        fetch('upload_details.php?id=' + id)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const details = data.details;
                    document.getElementById('popupDetails').innerHTML = `
                        <h2>Details</h2>
                        <p><strong>ID:</strong> ${details.id}</p>
                        <p><strong>File Name:</strong> ${details.file_original_name}</p>
                        <p><strong>File Path:</strong> ${details.image_link}</p>
                        <p><strong>File Size:</strong> ${details.file_size} KB</p>
                        <p><strong>Type:</strong> ${details.type}</p>
                        <p><strong>Uploaded At:</strong> ${details.created_at}</p>
                    `;
                    document.getElementById('detailsPopup').style.display = 'flex';
                } else {
                    alert("Failed to fetch details.");
                }
            })
            .catch(error => console.error("Error:", error));
    }

    // Close Popup
    function closePopup() {
        document.getElementById('detailsPopup').style.display = 'none';
    }

</script>

</body>
</html>


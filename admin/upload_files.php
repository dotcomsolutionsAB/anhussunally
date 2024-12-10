<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Database configuration
$host = 'localhost';
$dbname = 'anh';
$username = 'anh';
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
            gap: 20px;
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
                $duplicateCount = $conn->query("SELECT COUNT(*) AS count FROM upload GROUP BY file_original_name HAVING COUNT(file_original_name) > 1")->num_rows;
                echo $duplicateCount;
                ?>
            </p>
        </div>
        <div class="dashboard-card">
            <h3>Set Upload Path</h3>
            <form method="POST">
                <input type="text" name="upload_path" placeholder="Set new upload path" required>
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

    

    <!-- Image Gallery -->
    <div class="gallery">
        <?php
        // Fetch images from the database
        $result = $conn->query("SELECT * FROM upload WHERE deleted_at IS NULL ORDER BY created_at DESC");
        while ($row = $result->fetch_assoc()) {
            echo '<div class="gallery-item">';
            echo '<img src="../uploads/assets/' . htmlspecialchars($row['file_original_name']) . '" alt="' . htmlspecialchars($row['file_original_name']) . '">';
            echo '<div class="gallery-buttons">';
            echo '<button class="details-btn">Details</button>';
            echo '<button class="delete-btn">Delete</button>';
            echo '</div>';
            echo '</div>';
        }
        ?>
    </div>
</div>

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

</body>
</html>


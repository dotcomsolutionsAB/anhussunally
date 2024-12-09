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
    $uploadDir = "uploads/";
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    foreach ($_FILES['image']['tmp_name'] as $key => $tmpName) {
        $originalName = $_FILES['image']['name'][$key];
        $uniqueName = uniqid() . "_" . basename($originalName);
        $targetFile = $uploadDir . $uniqueName;

        if (move_uploaded_file($tmpName, $targetFile)) {
            $fileSize = $_FILES['image']['size'][$key];
            $extension = pathinfo($originalName, PATHINFO_EXTENSION);
            $type = mime_content_type($targetFile);
            $userId = 1; // Replace with the current user's ID if available

            // Insert file metadata into the database
            $stmt = $conn->prepare("INSERT INTO files (file_original_name, image_link, user_id, file_size, extension, type, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, NOW(), NOW())");
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
    <style>
        .gallery {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }
        .gallery img {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .upload-area {
            border: 2px dashed #ccc;
            border-radius: 5px;
            padding: 20px;
            text-align: center;
            margin-bottom: 20px;
            cursor: pointer;
        }
        .upload-area.dragover {
            background-color: #f0f8ff;
        }
        .upload-form input[type="file"] {
            display: none;
        }
        button {
            padding: 10px 20px;
            background-color: #007BFF;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
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
    <h1>Product Image Gallery</h1>

    <!-- Upload Form -->
    <div class="upload-area" id="uploadArea">
        Drag & Drop Images Here or Click to Upload
    </div>
    <form class="upload-form" method="POST" enctype="multipart/form-data">
        <input type="file" name="image[]" id="fileInput" multiple>
        <button type="submit">Upload Images</button>
    </form>

    <!-- Image Gallery -->
    <div class="gallery">
        <?php
        // Fetch images from the database
        $result = $conn->query("SELECT * FROM files WHERE deleted_at IS NULL ORDER BY created_at DESC");
        while ($row = $result->fetch_assoc()) {
            echo '<img src="' ."../uploads/assets/". $row['file_original_name']. '" alt="' . htmlspecialchars($row['file_original_name']) . '">';
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

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
    
    include("../connection/db_connect.php");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Brnad</title>
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

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            /// Handle form submission
            $message = '';
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $name = $conn->real_escape_string($_POST['name']);
                $specifications = $conn->real_escape_string($_POST['specifications']);
                $logo = '';
                $extension = '';

                // Check if brand already exists
                $query = "SELECT * FROM brand WHERE name = '$name'";
                $result = $conn->query($query);

                if ($result->num_rows > 0) {
                    $message = "Brand with name '$name' already exists!";
                } else {
                    // Handle logo upload
                    if (isset($_FILES['logo']) && $_FILES['logo']['error'] === UPLOAD_ERR_OK) {
                        // Get original file name and extension
                        $originalFileName = pathinfo($_FILES['logo']['name'], PATHINFO_FILENAME); // File name without extension
                        $extension = pathinfo($_FILES['logo']['name'], PATHINFO_EXTENSION); // File extension

                        // Rename the logo file with a timestamp to avoid conflicts
                        $uniqueFileName = time() . '_' . $originalFileName;
                        $logoName = $uniqueFileName . '.' . $extension; // Full file name with extension
                        $targetDir = "../uploads/assets/logos/";
                        if (!file_exists($targetDir)) {
                            mkdir($targetDir, 0777, true);
                        }
                        $targetFile = $targetDir . $logoName;

                        // Move uploaded file
                        if (move_uploaded_file($_FILES['logo']['tmp_name'], $targetFile)) {
                            $logo = $uniqueFileName; // Save the unique file name (without extension) in the database
                        } else {
                            $message = "Failed to upload logo.";
                        }
                    }

                    // Insert the new brand
                    if ($logo !== '' || empty($_FILES['logo']['name'])) {
                        $sql = "INSERT INTO brand (name, specifications, logo, extension) VALUES ('$name', '$specifications', '$logo', '$extension')";
                        if ($conn->query($sql) === TRUE) {
                            $message = "Brand added successfully!";
                            header("location:brand.php");
                        } else {
                            $message = "Error: " . $conn->error;
                        }
                    }
                }
            }

        ?>

        <div class="container mt-5">
                <h2>Add Brand</h2>

                <!-- Flash Message -->
                <?php if (!empty($message)): ?>
                    <div class="alert alert-info">
                        <?php echo $message; ?>
                    </div>
                <?php endif; ?>

                <!-- Search Form -->
                <form method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="name" class="form-label">Brand Name</label>
                        <input type="text" name="name" id="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="specifications" class="form-label">Specifications</label>
                        <textarea name="specifications" id="specifications" class="form-control"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="logo" class="form-label">Brand Logo</label>
                        <input type="file" name="logo" id="logo" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Brand</button>
                </form>
        </div>

    </div>
</body>
</html>
<?php
// Close connection
$conn->close();
?>

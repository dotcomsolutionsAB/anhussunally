<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Ensure the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: index.php');
    exit;
}

// Include the database connection
include("../connection/db_connect.php");
  $conn = mysqli_connect($host, $username, $password, $dbname);

// Check if the connection is established
if (!$conn) {
    die("Database connection failed.");
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $productId = $_POST['id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $brandId = $_POST['brand_id'];
    $categoryId = $_POST['category_id'];
    $weight = $_POST['weight'];
    $length = $_POST['length'];
    $breadth = $_POST['breadth'];
    $height = $_POST['height'];
    $newImageIds = [];
    $retainImages = true;

    // Handle image upload if provided
    if (isset($_FILES['images']) && $_FILES['images']['error'][0] === UPLOAD_ERR_OK) {
        $retainImages = false; // New images will replace old ones

        // Fetch existing images to delete
        $query = $conn->prepare("SELECT images FROM products WHERE id = ?");
        $query->bind_param("i", $productId);
        $query->execute();
        $result = $query->get_result();

        if ($result && $result->num_rows > 0) {
            $product = $result->fetch_assoc();
            $existingImageIds = explode(',', $product['images']);

            // Delete old images
            foreach ($existingImageIds as $imageId) {
                $fileQuery = $conn->prepare("SELECT file_original_name FROM upload WHERE id = ?");
                $fileQuery->bind_param("i", $imageId);
                $fileQuery->execute();
                $fileResult = $fileQuery->get_result();

                if ($fileResult && $fileResult->num_rows > 0) {
                    $fileData = $fileResult->fetch_assoc();
                    $filePath = "../uploads/assets/" . $fileData['file_original_name'];
                    if (file_exists($filePath)) {
                        unlink($filePath);
                    }
                }

                // Remove the image record
                $deleteImageStmt = $conn->prepare("DELETE FROM upload WHERE id = ?");
                $deleteImageStmt->bind_param("i", $imageId);
                $deleteImageStmt->execute();
            }
        }

        // Upload new images
        $uploadDir = "../uploads/assets/";
        foreach ($_FILES['images']['tmp_name'] as $index => $tmpName) {
            $originalName = $_FILES['images']['name'][$index];
            $filePath = $uploadDir . basename($originalName);

            if (move_uploaded_file($tmpName, $filePath)) {
    // Prepare the required fields for the `upload` table
    $fileOriginalName = $originalName; // Name of the file
    $imageLink = $filePath; // Path where the file is stored
    $userId = $_SESSION['user_id'] ?? 1; // Assuming the user's ID is stored in the session
    $fileSize = $_FILES['images']['size'][$index]; // File size
    $extension = pathinfo($fileOriginalName, PATHINFO_EXTENSION); // File extension
    $type = mime_content_type($filePath); // MIME type of the file
    $externalLink = null; // Assuming no external link is provided
    $createdAt = date('Y-m-d H:i:s'); // Current timestamp

    // Insert into the `upload` table
    $insertImageQuery = $conn->prepare("
        INSERT INTO upload (file_original_name, image_link, user_id, file_size, extension, type, external_link, created_at) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)
    ");
    $insertImageQuery->bind_param(
        "ssisssss",
        $fileOriginalName,
        $imageLink,
        $userId,
        $fileSize,
        $extension,
        $type,
        $externalLink,
        $createdAt
    );

    if ($insertImageQuery->execute()) {
        $newImageIds[] = $conn->insert_id; // Store the new image ID
    } else {
        die("Error inserting image into database: " . $conn->error);
    }
}
        }
    }

    // Determine the images to save in the database
    if ($retainImages) {
        // Retain existing images
        $query = $conn->prepare("SELECT images FROM products WHERE id = ?");
        $query->bind_param("i", $productId);
        $query->execute();
        $result = $query->get_result();

        if ($result && $result->num_rows > 0) {
            $product = $result->fetch_assoc();
            $imageIdsString = $product['images'];
        } else {
            $imageIdsString = ''; // No images found
        }
    } else {
        // Use new image IDs
        $imageIdsString = implode(',', $newImageIds);
    }

    // Update product details
    $stmt = $conn->prepare("UPDATE products SET name = ?, descriptions = ?, brand_id = ?, category_id = ?, weight = ?, length = ?, breadth = ?, height = ?, images = ? WHERE id = ?");
    $stmt->bind_param("ssiiiiisii", $name, $description, $brandId, $categoryId, $weight, $length, $breadth, $height, $imageIdsString, $productId);

    if ($stmt->execute()) {
        header('Location: product.php?msg=Product updated successfully');
    } else {
        header('Location: product.php?error=Failed to update the product');
    }

    $stmt->close();
}

// Fetch product details
$productId = $_GET['id'] ?? null;
if ($productId && is_numeric($productId)) {
    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
    } else {
        die("Product not found.");
    }
} else {
    die("Invalid product ID.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Product</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f9f9f9;
        }
        h2 {
            color: #333;
        }
        form {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: auto;
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }
        input, textarea, select, button {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        button {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
        .image-preview {
            display: block;
            max-width: 100px;
            margin-bottom: 10px;
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
        <h2>Update Product</h2>
        <form method="post" action="update_product.php" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= htmlspecialchars($product['id']); ?>">

            <label>Name:</label>
            <input type="text" name="name" value="<?= htmlspecialchars($product['name']); ?>" required><br>

            <label>Description:</label>
            <textarea name="description" required><?= htmlspecialchars($product['descriptions']); ?></textarea><br>

            <label>Brand:</label>
            <select name="brand_id" required>
                <?php
                $brands = $conn->query("SELECT id, name FROM brand");
                while ($brand = $brands->fetch_assoc()) {
                    $selected = $product['brand_id'] == $brand['id'] ? 'selected' : '';
                    echo "<option value='{$brand['id']}' $selected>{$brand['name']}</option>";
                }
                ?>
            </select><br>

            <label>Category:</label>
            <select name="category_id" required>
                <?php
                $categories = $conn->query("SELECT id, name FROM categories");
                while ($category = $categories->fetch_assoc()) {
                    $selected = $product['category_id'] == $category['id'] ? 'selected' : '';
                    echo "<option value='{$category['id']}' $selected>{$category['name']}</option>";
                }
                ?>
            </select><br>

            <label>Current Images:</label>
            <?php
            $existingImageIds = explode(',', $product['images']);
            foreach ($existingImageIds as $imageId) {
                $imageQuery = $conn->prepare("SELECT file_original_name FROM upload WHERE id = ?");
                $imageQuery->bind_param("i", $imageId);
                $imageQuery->execute();
                $imageResult = $imageQuery->get_result();
                if ($imageResult && $imageResult->num_rows > 0) {
                    $imageData = $imageResult->fetch_assoc();
                    echo '<img src="../uploads/assets/' . htmlspecialchars($imageData['file_original_name']) . '" width="100" alt="Product Image"><br>';
                }
            }
            ?><br>

            <label>Upload New Images:</label>
            <input type="file" name="images[]" multiple><br>

            <label>Weight (Kgs):</label>
            <input type="number" name="weight" value="<?= htmlspecialchars($product['weight']); ?>" step="0.01" required><br>

            <label>Dimensions (L x B x H cm):</label>
            <input type="number" name="length" value="<?= htmlspecialchars($product['length']); ?>" step="0.01" required>
            <input type="number" name="breadth" value="<?= htmlspecialchars($product['breadth']); ?>" step="0.01" required>
            <input type="number" name="height" value="<?= htmlspecialchars($product['height']); ?>" step="0.01" required><br>

            <button type="submit">Update Product</button>
        </form>
    </div>
</body>
</html>

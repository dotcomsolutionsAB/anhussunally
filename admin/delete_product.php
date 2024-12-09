<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: index.php');
    exit;
}

include("../connection/db_connect.php");

// Check if the product ID is passed
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $productId = $_GET['id'];

    // Fetch associated images from the database
    $imageQuery = $conn->prepare("SELECT images FROM products WHERE id = ?");
    $imageQuery->bind_param("i", $productId);
    $imageQuery->execute();
    $imageResult = $imageQuery->get_result();

    if ($imageResult && $imageResult->num_rows > 0) {
        $product = $imageResult->fetch_assoc();
        $images = explode(',', $product['images']); // Split image IDs

        // Loop through each image ID and delete the corresponding file
        foreach ($images as $imageId) {
            $fileQuery = $conn->prepare("SELECT file_original_name FROM upload WHERE id = ?");
            $fileQuery->bind_param("i", $imageId);
            $fileQuery->execute();
            $fileResult = $fileQuery->get_result();

            if ($fileResult && $fileResult->num_rows > 0) {
                $fileData = $fileResult->fetch_assoc();
                $filePath = "../uploads/assets/" . $fileData['file_original_name'];

                // Check if the file exists and delete it
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }

            // Delete the image record from the `upload` table
            $deleteImageStmt = $conn->prepare("DELETE FROM upload WHERE id = ?");
            $deleteImageStmt->bind_param("i", $imageId);
            $deleteImageStmt->execute();
        }
    }

    // Delete the product record from the `products` table
    $deleteProductStmt = $conn->prepare("DELETE FROM products WHERE id = ?");
    $deleteProductStmt->bind_param("i", $productId);

    if ($deleteProductStmt->execute()) {
        // Redirect to product list with success message
        header('Location: product.php?msg=Product and associated images deleted successfully');
    } else {
        // Redirect with an error message
        header('Location: product.php?error=Failed to delete the product');
    }

    $deleteProductStmt->close();
    $imageQuery->close();
} else {
    // Redirect with an error message
    header('Location: product.php?error=Invalid product ID');
}

$conn->close();
?>

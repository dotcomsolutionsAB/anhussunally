<?php
session_start();

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: index.php');
    exit;
}

include("../connection/db_connect.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['logo']) && isset($_POST['brand_id'])) {
    $brand_id = intval($_POST['brand_id']);
    $logo = $_FILES['logo'];

    // Validate the file
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
    if (!in_array($logo['type'], $allowed_types)) {
        die("Invalid file type. Only JPG, PNG, and GIF are allowed.");
    }

    if ($logo['size'] > 2 * 1024 * 1024) { // Limit to 2MB
        die("File is too large. Maximum size is 2MB.");
    }

    // Save the file
    $upload_dir = '../uploads/assets/logos/'; // Directory for uploads
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true); // Create directory if not exists
    }
    $unique_id = uniqid('logo_'); // Generate a unique ID for the logo
    $file_extension = pathinfo($logo['name'], PATHINFO_EXTENSION); // Extract the file extension
    $file_name = $unique_id . '.' . $file_extension;
    $upload_path = $upload_dir . $file_name;

    if (move_uploaded_file($logo['tmp_name'], $upload_path)) {
        // Save the unique ID and extension in the database
        $conn = mysqli_connect($host, $username, $password, $dbname);
        if (!$conn) {
            die("Database connection failed: " . mysqli_connect_error());
        }

        $update_query = "UPDATE brand SET logo = '$unique_id', extension = '$file_extension' WHERE id = $brand_id";
        if (mysqli_query($conn, $update_query)) {
            echo "Logo updated successfully.";
            header("Location: brand.php");
            exit;
        } else {
            die("Database error: " . mysqli_error($conn));
        }

        mysqli_close($conn);
    } else {
        die("Failed to upload the file.");
    }
} else {
    die("Invalid request.");
}
?>

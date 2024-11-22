<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit;
}

include("../api/db_connection.php");

// Check if a file is uploaded
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['logo']) && isset($_POST['brand_id'])) {
    $brand_id = intval($_POST['brand_id']);
    $logo = $_FILES['logo'];

    // Validate the file
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
    if (!in_array($logo['type'], $allowed_types)) {
        die("Invalid file type. Only JPG, PNG, and GIF are allowed.");
    }

    if ($logo['size'] > 2 * 1024 * 1024) { // 2MB limit
        die("File is too large. Maximum size is 2MB.");
    }

    // Save the file to the server
    $upload_dir = '../uploads/assets/logos';
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true); // Create the directory if it doesn't exist
    }
    $file_name = uniqid('logo_') . '.' . pathinfo($logo['name'], PATHINFO_EXTENSION);
    $upload_path = $upload_dir . $file_name;

    if (move_uploaded_file($logo['tmp_name'], $upload_path)) {
        // Update the database
        $conn = mysqli_connect($host, $username, $password, $dbname);
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $file_url = htmlspecialchars($upload_path); // Store the relative path
        $update_query = "UPDATE brand SET image = '$file_url' WHERE id = $brand_id";
        if (mysqli_query($conn, $update_query)) {
            echo "Logo updated successfully.";
            header("Location: brand.php"); // Redirect back to the brand page
        } else {
            echo "Error updating logo: " . mysqli_error($conn);
        }

        mysqli_close($conn);
    } else {
        echo "Failed to upload the file.";
    }
} else {
    echo "Invalid request.";
}
?>

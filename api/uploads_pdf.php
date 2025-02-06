<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database Connection
$host = 'localhost';
$user = 'anhuszzw_html';
$password = '9kCuzrb5tO53$xQtf';
$dbname = 'anhuszzw_html';

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Directory to store PDFs
$uploadDir = "../uploads/bro/";

// Fetch all products
$sql = "SELECT id, pdf FROM products";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $productId = $row['id'];
        $pdfValue = trim($row['pdf']);
        $pdfId = null;

        // Case 1: If PDF is a URL, download it
        if (filter_var($pdfValue, FILTER_VALIDATE_URL)) {
            $fileName = basename(parse_url($pdfValue, PHP_URL_PATH)); // Extract filename
            $filePath = $uploadDir . $fileName;

            if (downloadFile($pdfValue, $filePath)) {
                $pdfId = saveToUploads($conn, $fileName, $filePath, "pdf", $pdfValue);
            }
        }
        // Case 2: If PDF is a local filename (like 't19.pdf')
        elseif (!empty($pdfValue) && preg_match('/\w+\.pdf$/', $pdfValue)) {
            $oldPath = "../some_directory/" . $pdfValue; // Adjust source directory
            $newPath = $uploadDir . $pdfValue;

            if (file_exists($oldPath)) {
                rename($oldPath, $newPath);
                $pdfId = saveToUploads($conn, $pdfValue, $newPath, "pdf");
            }
        }
        // Case 3: If empty or null, set it as 'NA'
        else {
            $pdfValue = "NA";
        }

        // Update products table
        $updateSql = "UPDATE products SET pdf_id = ?, pdf = ? WHERE id = ?";
        $stmt = $conn->prepare($updateSql);
        $stmt->bind_param("isi", $pdfId, $pdfValue, $productId);
        $stmt->execute();
    }
} else {
    echo "No products found.";
}

$conn->close();


// Function to download a file from a URL
function downloadFile($url, $savePath)
{
    $fileContent = file_get_contents($url);
    if ($fileContent === false) {
        return false;
    }
    return file_put_contents($savePath, $fileContent) !== false;
}

// Function to save file details into the uploads table
function saveToUploads($conn, $originalName, $filePath, $type, $externalLink = null)
{
    $fileSize = filesize($filePath);
    $extension = pathinfo($filePath, PATHINFO_EXTENSION);
    $userId = 1; // Set the user ID dynamically if needed
    $createdAt = date('Y-m-d H:i:s');

    $insertSql = "INSERT INTO upload (file_original_name, image_link, user_id, file_size, extension, type, external_link, created_at) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($insertSql);
    $stmt->bind_param("ssiissss", $originalName, $filePath, $userId, $fileSize, $extension, $type, $externalLink, $createdAt);
    $stmt->execute();

    return $stmt->insert_id; // Return the ID of the inserted row
}

?>

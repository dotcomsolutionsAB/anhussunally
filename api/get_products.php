<?php
$host = 'localhost';
$user = 'anhuszzw_html';
$password = '9kCuzrb5tO53$xQtf';
$dbname = 'anhuszzw_html';

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die(json_encode([]));
}

$sql = "SELECT id FROM products WHERE (pdf_id IS NULL OR pdf_id = '') AND pdf IS NOT NULL";
$result = $conn->query($sql);
$productIds = [];

while ($row = $result->fetch_assoc()) {
    $productIds[] = $row['id'];
}

echo json_encode($productIds);
$conn->close();

<?php
// Include database connection
include("../db_connection.php");

// Establish database connection
$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to get sheets with status 0
$query = "SELECT id FROM google_sheet WHERE status = 0";
$result = $conn->query($query);

$sheets = [];
while ($row = $result->fetch_assoc()) {
    $sheets[] = $row;
}

// Return the result as JSON
echo json_encode($sheets);

$conn->close();
?>

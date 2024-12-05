<?php
function addCategory($categoryName) {
    global $conn;
    $categoryId = null;

    // Check if category exists in categories table
    $categoryQuery = "SELECT id FROM categories WHERE name = ? AND parent_id = 0 AND level = 0";
    $categoryStmt = $conn->prepare($categoryQuery);
    $categoryStmt->bind_param("s", $categoryName);
    $categoryStmt->execute();
    $categoryResult = $categoryStmt->get_result();

    if ($categoryResult->num_rows > 0) {
        // Category exists, return the id
        $categoryRow = $categoryResult->fetch_assoc();
        $categoryId = $categoryRow['id'];
    } else {
        // Insert new category (level 0)
        $categoryInsertQuery = "INSERT INTO categories (name, parent_id, level) VALUES (?, 0, 0)";
        $categoryStmt = $conn->prepare($categoryInsertQuery);
        $categoryStmt->bind_param("s", $categoryName);
        if ($categoryStmt->execute()) {
            $categoryId = $conn->insert_id;
        } else {
            echo "Failed to add category: " . $categoryName . "<br>";
        }
    }

    $categoryStmt->close();
    return $categoryId;
}
?>

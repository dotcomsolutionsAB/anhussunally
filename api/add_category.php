<?php
function addCategory($categoryName, $parentId = 0) {
    global $conn;
    $categoryId = null;

    // Check if the category exists under the given parent
    $categoryQuery = "SELECT id FROM categories WHERE name = ? AND parent_id = ?";
    $categoryStmt = $conn->prepare($categoryQuery);
    $categoryStmt->bind_param("si", $categoryName, $parentId);
    $categoryStmt->execute();
    $categoryResult = $categoryStmt->get_result();

    if ($categoryResult->num_rows > 0) {
        // Category exists, return its ID
        $categoryRow = $categoryResult->fetch_assoc();
        $categoryId = $categoryRow['id'];
    } else {
        // Insert the new category
        $categoryInsertQuery = "INSERT INTO categories (name, parent_id) VALUES (?, ?)";
        $categoryStmt = $conn->prepare($categoryInsertQuery);
        $categoryStmt->bind_param("si", $categoryName, $parentId);
        if ($categoryStmt->execute()) {
            $categoryId = $conn->insert_id;
        } else {
            echo "Failed to add category: $categoryName<br>";
        }
    }

    $categoryStmt->close();
    return $categoryId;
}
?>

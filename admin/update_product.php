<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: index.php');
    exit;
}

include("../connection/db_connect.php");

// Check if the form is submitted
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

    // Update query
    $stmt = $conn->prepare("UPDATE products SET name = ?, description = ?, brand_id = ?, category_id = ?, weight = ?, length = ?, breadth = ?, height = ? WHERE id = ?");
    $stmt->bind_param("ssiiiiiii", $name, $description, $brandId, $categoryId, $weight, $length, $breadth, $height, $productId);

    if ($stmt->execute()) {
        // Redirect to product list with success message
        header('Location: product.php?msg=Product updated successfully');
    } else {
        // Redirect with an error message
        header('Location: product.php?error=Failed to update the product');
    }

    $stmt->close();
} elseif (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $productId = $_GET['id'];

    // Fetch product details
    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
    } else {
        header('Location: product.php?error=Product not found');
        exit;
    }

    $stmt->close();
} else {
    header('Location: product.php?error=Invalid product ID');
    exit;
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Product</title>
</head>
<body>
    <h2>Update Product</h2>
    <form method="post" action="update_product.php">
        <input type="hidden" name="id" value="<?= htmlspecialchars($product['id']); ?>">
        <label>Name:</label>
        <input type="text" name="name" value="<?= htmlspecialchars($product['name']); ?>" required><br>

        <label>Description:</label>
        <textarea name="description" required><?= htmlspecialchars($product['description']); ?></textarea><br>

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

        <label>Weight (Kgs):</label>
        <input type="number" name="weight" value="<?= htmlspecialchars($product['weight']); ?>" step="0.01" required><br>

        <label>Dimensions (L x B x H cm):</label>
        <input type="number" name="length" value="<?= htmlspecialchars($product['length']); ?>" step="0.01" required>
        <input type="number" name="breadth" value="<?= htmlspecialchars($product['breadth']); ?>" step="0.01" required>
        <input type="number" name="height" value="<?= htmlspecialchars($product['height']); ?>" step="0.01" required><br>

        <button type="submit">Update Product</button>
    </form>
</body>
</html>

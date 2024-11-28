<?php
// db_connection.php - include your DB connection here
include("../api/db_connection.php");

// Query to fetch all brands and their details
$query = "SELECT * FROM brand ORDER BY name";
$result = $conn->query($query);

// Check if there are any brands in the database
if ($result->num_rows > 0):
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Brands List</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            width: 90%;
            margin: 0 auto;
        }
        h1 {
            text-align: center;
            margin: 20px 0;
        }
        .brand-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            margin-top: 30px;
        }
        .brand-card {
            border: 1px solid #ccc;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .brand-card img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
        }
        .brand-card h3 {
            font-size: 1.2em;
            margin: 10px 0;
        }
        .brand-card p {
            margin: 5px 0;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>All Brands</h1>
    
    <div class="brand-grid">
        <?php while ($brand = $result->fetch_assoc()): ?>
        <div class="brand-card">
            <?php if (!empty($brand['logo'])): ?>
                <img src="uploads/logos/<?= $brand['logo']; ?>" alt="<?= htmlspecialchars($brand['name']); ?>" />
            <?php endif; ?>
            <h3><?= htmlspecialchars($brand['name']); ?></h3>
            <p><strong>Specifications:</strong> <?= !empty($brand['specifications']) ? htmlspecialchars($brand['specifications']) : 'N/A'; ?></p>
            <p><strong>Extension:</strong> <?= !empty($brand['extension']) ? htmlspecialchars($brand['extension']) : 'N/A'; ?></p>
            <p><strong>Created At:</strong> <?= date('Y-m-d', strtotime($brand['created_at'])); ?></p>
            <p><strong>Updated At:</strong> <?= date('Y-m-d', strtotime($brand['updated_at'])); ?></p>
        </div>
        <?php endwhile; ?>
    </div>
</div>

</body>
</html>

<?php
else:
    echo "<p>No brands found in the database.</p>";
endif;

// Close the database connection
$conn->close();
?>

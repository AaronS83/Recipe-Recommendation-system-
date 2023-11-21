<?php
// Database connection details
try {
    // Create a new PDO instance
    $dsn = 'mysql:host=localhost;port=3307;dbname=recipe_sharing_platform';

    $pdo = new PDO($dsn, 'root', '');

    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Retrieve the selected category from the query string
    $category = $_GET['category'];

    // Prepare the SQL statement to fetch recipes by category
    $sql = "SELECT id, title
            FROM recipes
            WHERE category_id = (SELECT id FROM categories WHERE category_name = ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$category]);
    $recipes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Return the recipes as JSON response
    header('Content-Type: application/json');
    echo json_encode($recipes);
} catch (PDOException $e) {
    // Handle database connection errors
    echo "Connection failed: " . $e->getMessage();
}
?>
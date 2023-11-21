<?php

// Connect to the database
$dsn = 'mysql:host=localhost;port=3307;dbname=recipe_sharing_platform';
$pdo = new PDO($dsn, 'root', '');

// Get the recipe ID from the query string
$recipeId = $_GET['id'];

// Get the recipe from the database
$stmt = $pdo->prepare('SELECT * FROM recipes WHERE id = :id');
$stmt->bindParam(':id', $recipeId);
$stmt->execute();

$recipe = $stmt->fetch(PDO::FETCH_ASSOC);

// If the recipe is not found, return a 404 error
if (!$recipe) {
  header('HTTP/1.1 404 Not Found');
  exit;
}

// Convert the recipe to JSON format
$recipeJson = json_encode($recipe);

// Output the JSON response
header('Content-Type: application/json');
echo $recipeJson;

?>

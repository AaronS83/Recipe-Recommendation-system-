<?php

// Connect to the database
$dsn = 'mysql:host=localhost;port=3307;dbname=recipe_sharing_platform';
$pdo = new PDO($dsn, 'root', '');

// Get the recipe ID from the query string
$recipeId = $_GET['recipe_id'];

// Get the comments for the recipe from the database
$stmt = $pdo->prepare('SELECT * FROM comments WHERE recipe_id = :recipe_id ORDER BY created_at DESC');
$stmt->bindParam(':recipe_id', $recipeId);
$stmt->execute();

$comments = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Convert the comments to JSON format
$commentsJson = json_encode($comments);

// Output the JSON response
header('Content-Type: application/json');
echo $commentsJson;

?>

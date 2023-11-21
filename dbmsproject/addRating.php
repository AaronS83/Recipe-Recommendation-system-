<?php

session_start();
// Connect to the database
if (isset($_SESSION["user_id"])) {
$user_Id = $_SESSION["user_id"];
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "recipe_sharing_Platform";

$conn = new mysqli($servername, $username, $password, $dbname,3307);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get recipe ID and rating from the POST data
$recipeId = $_POST['recipe_id'];
$rating = $_POST['rating'];

// Insert the rating into the database
$sql = "INSERT INTO ratings (user_id, recipe_id, rating) VALUES ($user_Id, $recipeId, $rating)";
$result = $conn->query($sql);

// Check if the insertion was successful
if ($result) {
    echo "Rating added successfully.";
} else {
    echo "Error adding rating: " . $conn->error;
}

$conn->close();
}
?>

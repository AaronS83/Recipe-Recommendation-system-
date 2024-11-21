<?php


// Connect to the database 
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "recipe_sharing_Platform";

$conn = new mysqli($servername, $username, $password, $dbname, 3307);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get recipe ID from the query parameter
$recipeId = $_GET['recipe_id'];

// Call the GetRecipeRatings procedure
$sql = "CALL GetRecipeRatings($recipeId)";
$result = $conn->query($sql);

if ($result) {
    $ratingData = $result->fetch_assoc();

    // Send the rating data as JSON
    header('Content-Type: application/json');
    echo json_encode($ratingData);
} else {
    // Provide error information if the query fails
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>

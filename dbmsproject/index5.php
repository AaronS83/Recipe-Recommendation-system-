<!DOCTYPE html>
<html>
<head>
  <title>View Recipe</title>
  <link rel="stylesheet" href="index5.css">
  <script src="index5.js"></script>
</head>
<body>
  <div class="container">
    <h1>View Recipe</h1>

    <div class="category-selector">
      <select id="category-selector">
        <option value="">All Categories</option>
        <?php
          // Connect to the database
          // $db = new PDO('mysql:host=localhost;dbname=Recipe_sharing_Platform', 'root', '');
          $dsn = 'mysql:host=localhost;port=3307;dbname=recipe_sharing_platform';
          $pdo = new PDO($dsn, 'root', '');
          // Get all categories from the database
          $categories = $pdo->query('SELECT * FROM categories')->fetchAll(PDO::FETCH_ASSOC);

          // Display each category in the dropdown menu
          foreach ($categories as $category) {
            echo '<option value="' . $category['id'] . '">' . $category['category_name'] . '</option>';
          }
        ?>
      </select>
    </div>

    <ul id="recipe-list"></ul>

    <div id="recipe-details"></div>
  </div>
</body>
</html>

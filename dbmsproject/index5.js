const recipeList = document.querySelector('#recipe-list');
const recipeDetails = document.querySelector('#recipe-details');

// Get all recipes from the backend
async function getRecipes() {
  const response = await fetch('/recipes.php');
  const recipes = await response.json();

  return recipes;
}

// Get all recipes for a specific category
async function getRecipesForCategory(categoryId) {
  const response = await fetch(`/recipes.php?category_id=${categoryId}`);
  const recipes = await response.json();

  return recipes;
}

// Display the list of recipes
function displayRecipes(recipes) {
  var recipeListDiv = document.getElementById("recipe-list");
  recipeListDiv.innerHTML = "";

  recipes.forEach(function (recipe) {
    var recipeDiv = document.createElement("div");
    recipeDiv.classList.add("recipe-item");

    var title = document.createElement("h2");
    title.innerText = recipe.title;
    recipeDiv.appendChild(title);

    var avgRating = document.createElement("p");
    avgRating.innerText = "Average Rating: " + (typeof recipe.avg_rating === 'number' ? recipe.avg_rating.toFixed(1) : "N/A");
    recipeDiv.appendChild(avgRating);

    var viewButton = document.createElement("button");
    viewButton.innerText = "View Recipe";
    viewButton.addEventListener("click", function () {
      viewRecipeDetails(recipe.id);
    });
    recipeDiv.appendChild(viewButton);

    recipeListDiv.appendChild(recipeDiv);
  });
}

// Display the recipe details
async function displayRecipeDetails(recipeId) {
  const response = await fetch(`/recipe.php?id=${recipeId}`);
  const recipe = await response.json();

  recipeDetails.innerHTML = '';

  const recipeTitle = document.createElement('h2');
  recipeTitle.textContent = recipe.title;

  recipeDetails.appendChild(recipeTitle);

  const recipeCookingTime = document.createElement('p');
  recipeCookingTime.textContent = `Cooking time: ${recipe.cooking_time} minutes`;

  recipeDetails.appendChild(recipeCookingTime);

  const recipeImage = document.createElement('img');
  recipeImage.src = recipe.photo;

  recipeDetails.appendChild(recipeImage);

  const recipeVideo = document.createElement('video');
  recipeVideo.src = recipe.video_link;

  recipeDetails.appendChild(recipeVideo);

  const recipeIngredients = document.createElement('ul');
  recipeIngredients.textContent = 'Ingredients:';

  recipe.ingredients.forEach(ingredient => {
    const ingredientItem = document.createElement('li');
    ingredientItem.textContent = `${ingredient.ingredient_name} - ${ingredient.quantity} ${ingredient.unit}`;

    recipeIngredients.appendChild(ingredientItem);
  });

  recipeDetails.appendChild(recipeIngredients);

  // Get the recipe comments
  const recipeComments = await getRecipeComments(recipeId);

  // Display the recipe comments
  const recipeCommentsElement = document.createElement('ul');
  recipeCommentsElement.textContent = 'Comments:';

  recipeComments.forEach(comment => {
    const commentElement = document.createElement('li');
    commentElement.textContent = `${comment.user.name}: ${comment.content}`;

    recipeCommentsElement.appendChild(commentElement);
  });

  recipeDetails.appendChild(recipeCommentsElement);
}

// Get all comments for a specific recipe
async function getRecipeComments(recipeId) {
  const response = await fetch(`/recipe_comments.php?recipe_id=${recipeId}`);
  const comments = await response.json();

  return comments;
}

// Display the recipe list on page load
await displayRecipes();

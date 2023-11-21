CREATE DATABASE Recipe_sharing_Platform;

USE Recipe_sharing_Platform;

CREATE TABLE users (
  id INT NOT NULL AUTO_INCREMENT,
  name VARCHAR(255) NOT NULL,
  email VARCHAR(255) NOT NULL,
  password VARCHAR(255) NOT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE categories (
  id INT NOT NULL AUTO_INCREMENT,
  category_name VARCHAR(255) NOT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE recipes (
  id INT NOT NULL AUTO_INCREMENT,
  title VARCHAR(255) NOT NULL,
  cooking_time INT NOT NULL,
  recipe TEXT NOT NULL,
  type VARCHAR(255) NOT NULL,
  category_id INT NOT NULL,
  description VARCHAR(255) NULL,
  instructions VARCHAR(255) NULL,
  user_id INT NOT NULL,
  uploaded_at DATETIME NOT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (category_id) REFERENCES categories(id),
  FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE ratings (
  id INT NOT NULL AUTO_INCREMENT,
  user_id INT NOT NULL,
  recipe_id INT NOT NULL,
  rating DECIMAL(2,1) NOT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (user_id) REFERENCES users(id),
  FOREIGN KEY (recipe_id) REFERENCES recipes(id) ON DELETE CASCADE
);

CREATE TABLE comments (
  id INT NOT NULL AUTO_INCREMENT,
  recipe_id INT NOT NULL,
  user_id INT NOT NULL,
  content TEXT NOT NULL,
  created_at DATETIME NOT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (recipe_id) REFERENCES recipes(id),
  FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE ingredients (
    id INT NOT NULL AUTO_INCREMENT,
    recipe_id INT NOT NULL,
    ingredient_name VARCHAR(255) NOT NULL,
    quantity DECIMAL(10,2) NOT NULL,
    unit VARCHAR(255) NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (recipe_id) REFERENCES recipes(id) ON DELETE CASCADE
);


CREATE TABLE recipe_ingredients (
  recipe_id INT NOT NULL,
  ingredient_id INT NOT NULL,
  PRIMARY KEY (recipe_id, ingredient_id),
  FOREIGN KEY (recipe_id) REFERENCES recipes(id),
  FOREIGN KEY (ingredient_id) REFERENCES ingredients(id)
);

-- Alter the table
ALTER TABLE recipes
ADD COLUMN photo VARCHAR(255) NULL AFTER instructions,
ADD COLUMN video_link VARCHAR(255) NULL AFTER photo;


-- Triggers

DELIMITER // 
CREATE TRIGGER check_password_length 
BEFORE INSERT ON users 
FOR EACH ROW 
BEGIN 
 IF LENGTH(NEW.password) < 4 OR LENGTH(NEW.password) > 10 THEN 
 SIGNAL SQLSTATE '45000' 
 SET MESSAGE_TEXT = 'Password length must be between 4 and 10 characters.'; 
END IF; 
END; 
// 
DELIMITER ; 


-- Procedures

DELIMITER // 
CREATE PROCEDURE GetRecipeRatings(IN recipeID INT) 
BEGIN 
 DECLARE totalRatings INT; 
 DECLARE avgRating DECIMAL(3,2); 
 SELECT COUNT(*) INTO totalRatings 
 FROM Ratings 
 WHERE RecipeID = recipeID; 
 IF totalRatings > 0 THEN 
 SELECT AVG(Rating) INTO avgRating 
 FROM Ratings 
 WHERE RecipeID = recipeID; 
 SELECT avgRating AS AverageRating, totalRatings AS TotalRatings; 
 ELSE 
 SELECT NULL AS AverageRating, 0 AS TotalRatings; 
 END IF; 
END // 
DELIMITER








<?php
// Include the backend functions file
require_once '../authors_recipes.php';

// Database connection
$connection = get_db_connection();

// Process form submissions (delete author, delete recipe, or add recipe)
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["action"])) {
        if ($_POST["action"] === "delete_author" && isset($_POST["author_id"]) && is_numeric($_POST["author_id"])) {
            $author_id = $_POST["author_id"];
            delete_author($connection, $author_id);
        } elseif ($_POST["action"] === "delete_recipe" && isset($_POST["recipe_id"]) && is_numeric($_POST["recipe_id"])) {
            $recipe_id = $_POST["recipe_id"];
            delete_recipe($connection, $recipe_id);
        }
    }

    // Handle form submission for adding a new recipe
    if (isset($_POST["action"]) && $_POST["action"] === "add_recipe") {
        $name = $_POST["name"];
        $ingredients = $_POST["ingredients"];
        $procedure = $_POST["procedure"];

        save_recipe($connection, $name, $ingredient, $procedure);
    }

    if (isset($_POST["action"]) && $_POST["action"] === "add_author") {
        $username = $_POST["username"];
        $sirname = $_POST["sirname"];
        $email = $_POST["email"];
        $password = $_POST["password"];

        save_author($connection, $username, $sirname, $email, $password);
    }
}

// Fetch all authors and recipes from the database
$authors = get_authors($connection);
$recipes = get_recipes($connection);

// Close the database connection
$connection->close();


//require_once '../parts/connect.php';

// Database connection
$connection = get_db_connection();

// Process form submissions (delete author, delete recipe, or add recipe)
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["action"])) {
        if ($_POST["action"] === "delete_author" && isset($_POST["author_id"]) && is_numeric($_POST["author_id"])) {
            $author_id = $_POST["author_id"];
            delete_author($connection, $author_id);
        } elseif ($_POST["action"] === "delete_recipe" && isset($_POST["recipe_id"]) && is_numeric($_POST["recipe_id"])) {
            $recipe_id = $_POST["recipe_id"];
            delete_recipe($connection, $recipe_id);
        }
    }

    // Handle form submission for adding a new recipe
    if (isset($_POST["action"]) && $_POST["action"] === "add_recipe") {
        $name = $_POST["name"];
        $ingredients = $_POST["ingredients"];
        $procedure = $_POST["procedure"];

        save_recipe($connection, $name, $ingredient, $procedure);
    }
}

// Fetch all authors and recipes from the database
$authors = get_authors($connection);
$recipes = get_recipes($connection);

// Close the database connection
$connection->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Authors and Recipes</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body style="background-image: url('../category/istockphoto-1312307362-1024x1024.jpg'); background-height:100%; background-size: cover; background-repeat: no-repeat;">
<div class="header">
        <ul>
        <li class="left"><image src="../category/avo.jpg" height="60px" width="70px"/></li>
        <li class="left"><h3>ZACK FOODS AND BAKEYS</h3></li>
            <li>
                <div class="dropbtn">Sign In as:</div>
                <div class="dropdwn">
                    <a href="http://localhost:8080/Recipes/admin/login.php">Admin</a><br/>
                    <a href="http://localhost:8080/Recipes/author/login.php">Author</a>
                </div>
            </li>
            <li>
                <div class="dropbtn">Register as:</div>
                <div class="dropdwn">
                    <a href="http://localhost:8080/Recipes/admin/signup.php">Admin</a><br/>
                    <a href="http://localhost:8080/Recipes/author/signup.php">Author</a>
                </div>
            </li>
            <li><a href="http://localhost:8080/Recipes/view.php">RECIPES</a></li>
            <li><a href="http://localhost:8080/Recipes/recipe.php">MANAGE RECIPES</a></li>
        </ul>
    </div>
        <div class="right">
    <h1>Manage Authors</h1>
    <table>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Sirname</th>
                <th>Email</th>
                <th>Password</th>
                <th>Actions</th>
            </tr>
            <?php foreach ($authors as $author): ?>
                <tr>
                    <td><?php echo $author['id']; ?></td>
                    <td><?php echo $author['username']; ?></td>
                    <td><?php echo $author['sirname']; ?></td>
                    <td><?php echo $author['email']; ?></td>
                    <td>
                        <?php
                            // Display each step of the procedure as a separate list item
                            $procedure_steps = explode(",", $author['password']);
                            echo "<ul>";
                            foreach ($procedure_steps as $step) {
                                echo "<li>$step</li>";
                            }
                            echo "</ul>";
                        ?>
                    </td>
                    <td>
                        <form action="" method="post">
                        <input type="hidden" name="action" value="delete_author">
                        <input type="hidden" name="author_id" value="<?php echo $author['id']; ?>">
                        <input type="submit" value="Delete">
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
        <h2>You Can Now Add A New Author</h2>
        <table style="background-image: ;";>
        <th colspan="5"><h2>Add New Author</h2></th>
    <form action="" method="post">
    <input type="hidden" name="action" value="add_author">        <tr>
            <th>Username</th>
            <th>Sirname</th>
            <th>Email</th>
            <th>Password</th>
            <th>Actions</th>
        </tr>
            <tr>
                <td><input type="text" name="username" required></td>
                <td><input type="text" name="sirname" required></td>
                <td><input type="text" name="email" required></td>
                <td><input type="password" name="password" required></td>
                <td><input type="submit" value="Add Author"></td>
            </tr>
        </table>
    </form>
        </div>
</body>
</html>


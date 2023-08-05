<?php
// Include the backend functions file
require_once 'authors_recipes.php';

// Start a new or resume an existing session
session_start();

// Check if the user is logged in as an author
if (!isset($_SESSION['author_id'])) {
    header("Location: authors_login.html");
    exit;
}

// Database connection
$connection = get_db_connection();

// Get the author's ID from the session
$author_id = $_SESSION['author_id'];

// Process form submissions (delete recipe or add recipe)
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["action"])) {
        // Handle form submission for deleting a recipe
        if ($_POST["action"] === "delete_recipe" && isset($_POST["recipe_id"]) && is_numeric($_POST["recipe_id"])) {
            $recipe_id = $_POST["recipe_id"];
            delete_recipe($connection, $recipe_id);
        }
    }

    // Handle form submission for adding a new recipe
    if (isset($_POST["action"]) && $_POST["action"] === "add_recipe") {
        $title = $_POST["title"];
        $ingredients = $_POST["ingredients"];
        $procedure = $_POST["procedure"];

        // Add the new recipe to the database
        $recipe_added = add_recipe($connection, $title, $ingredients, $procedure);

        if ($recipe_added) {
            // Redirect to avoid form resubmission
            header("Location: recipe.php");
            exit;
        } else {
            echo "Failed to add recipe.";
        }
    }
}

// Fetch the recipes owned by the logged-in author
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
    <title>Authors Panel</title>
    <link rel="stylesheet" href="admin/admin.css">
    <style>
        table{
            width: 90%;
        }
        tr{
            padding-left: 10%;
        }
    </style>
</head>
<body style="background-image: url('category/table.jpg');">
<?php require_once'parts/header.php'; ?>
    <div class="">
        <table class="recipes">
            <tr><th colspan="5"><h1>Authors Panel</h1></th></tr>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Ingredients</th>
                <th>Procedure</th>
                <th>Actions</th>
            </tr>
            <?php 
            foreach ($recipes as $recipe): ?>
                <tr>
                    <td><?php echo $recipe['id']; ?></td>
                    <td><?php echo $recipe['title']; ?></td>
                    <td><?php echo $recipe['ingredients']; ?></td>
                    <td>
                        <?php
                            // Display each step of the procedure as a separate list item
                            $procedure_steps = explode(",", $recipe['instructions']);
                            echo "<p>";
                            foreach ($procedure_steps as $step) {
                                echo "$step<br/>";
                            }
                            echo "</p>";
                        ?>
                    </td>
                    <td>
                        <form action="recipe.php" method="post">
                            <input type="hidden" name="action" value="delete_recipe">
                            <input type="hidden" name="recipe_id" value="<?php echo $recipe['id']; ?>">
                            <input type="submit" value="Delete">
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>

        <form action="recipe.php" method="post">
            <input type="hidden" name="action" value="add_recipe">
            <table class="small">
                <tr>
                    <td colspan=""><h2>Add New Recipe</h2></td>
                </tr>
                <tr>
                    <td>
                        <label for="title">Title:</label>
                        <input type="text" name="title" required>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="ingredients">Ingredients:</label><br/>
                        <textarea name="ingredients" id="ingredients" cols="50" rows="3"></textarea><br/>
                        <label for="procedure">Procedure:</label><br/>
                        <textarea name="procedure" id="procedure" cols="50" rows="5"></textarea>
                    </td>
                </tr>
                <tr>
                    <td><input type="submit" value="Add Recipe"></td>
                </tr>
            </table>
        </form>
    </div>
</body>
</html>


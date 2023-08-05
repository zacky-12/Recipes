<?php 
require_once 'authors_recipes.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View</title>
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
<body style="background-image:url('category/table.jpg');">
   <?php require_once"parts/header.php"; ?> 
       <table class='recipes'>
            <tr><td colspan ='3'><h4>Recipes</h4></td></tr>
            <tr>
            <th><strong>Title:</strong></th>
            <th><strong>Ingredients:</strong></th>
            <th><strong>Procedure:</strong></th>
        </tr>
        <?php
        // Fetch all recipes from the database
        $connection = get_db_connection();
        $recipes = get_recipes($connection);
        close_db_connection($connection);

        shuffle($recipes);

        foreach ($recipes as $recipe) {
            echo "<tr>
            <td>".$recipe['title']."</td>
            <td>".$recipe['ingredients']."</td>
            <td>".$recipe['instructions']."</td>
        </tr>";
    }
    ?>
    </table>
</body>
</html>
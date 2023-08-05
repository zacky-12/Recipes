<?php
$hostname = "localhost";
$db_username = "root";
$db_password = "";
$database = "foods";

// Function to establish a database connection
function get_db_connection() {
    global $hostname, $db_username, $db_password, $database;
    $connection = new mysqli($hostname, $db_username, $db_password, $database);
    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }
    return $connection;
}

// Function to fetch all authors from the database
function get_authors($connection) {
    $query = "SELECT * FROM authors";
    $result = $connection->query($query);

    if ($result && $result->num_rows > 0) {
        return $result->fetch_all(MYSQLI_ASSOC);
    } else {
        return array();
    }
}

// Function to delete an author from the database
function delete_author($connection, $author_id) {
    $delete_query = "DELETE FROM authors WHERE id = ?";
    $statement = $connection->prepare($delete_query);
    $statement->bind_param("i", $author_id);
    $statement->execute();
}
function save_author($connection, $username, $sirname, $email, $password) {
    // Check if the username already exists
    $check_query = "SELECT id FROM authors WHERE username = ?";
    $check_statement = $connection->prepare($check_query);
    $check_statement->bind_param("s", $username);
    $check_statement->execute();
    $check_result = $check_statement->get_result();

    if ($check_result->num_rows > 0) {
        // Username already exists
        return "Username already exists";
    }

    // Insert new author
    $insert_query = "INSERT INTO authors (username, sirname, email, password) VALUES (?, ?, ?, ?)";
    $insert_statement = $connection->prepare($insert_query);
    $insert_statement->bind_param("ssss", $username, $sirname, $email, $password);

    if ($insert_statement->execute()) {
        return true;
    } else {
        return false;
    }
}

// Function to fetch all recipes from the database
function get_recipes($connection) {
    $query = "SELECT * FROM recipes";
    $result = $connection->query($query);

    if ($result && $result->num_rows > 0) {
        return $result->fetch_all(MYSQLI_ASSOC);
    } else {
        return array();
    }
}

// Function to delete a recipe from the database
function delete_recipe($connection, $recipe_id) {
    $delete_query = "DELETE FROM recipes WHERE id = ?";
    $statement = $connection->prepare($delete_query);
    $statement->bind_param("i", $recipe_id);
    $statement->execute();
}

// Function to add a recipe to the database
// Function to add a recipe to the database
function add_recipe($connection, $title, $ingredients, $instructions) {
    $insert_query = "INSERT INTO recipes (title, ingredients, instructions) VALUES (?, ?, ?)";
    $statement = $connection->prepare($insert_query);
    $statement->bind_param("sss", $title, $ingredients, $instructions);

    if ($statement->execute()) {
        return $statement->insert_id;
    } else {
        return false;
    }
}


// Function to close the database connection
function close_db_connection($connection) {
    $connection->close();
}
?>



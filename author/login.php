<?php
session_start();

function login_author($username, $password) {
    $hostname = "localhost";
    $username_db = "root";
    $password_db = "";
    $database = "foods";
    $connection = new mysqli($hostname, $username_db, $password_db, $database);

    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }

    $query = "SELECT id, username, password FROM authors WHERE username = ?";
    $statement = $connection->prepare($query);
    $statement->bind_param("s", $username);
    $statement->execute();
    $result = $statement->get_result();

  // Inside the login_author function
if ($result->num_rows === 1) {
    $author = $result->fetch_assoc();
    if (password_verify($password, $author['password'])) {
        $_SESSION['author_id'] = $author['id'];
        $_SESSION['author_username'] = $author['username'];
        header("refresh:1; url=../recipe.php");
        exit;
    } else {
        echo "Invalid Password"; // Debugging output
    }
} else {
    echo "No Author Found"; // Debugging output
}

    $statement->close();
    $connection->close();
}
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["action"]) && $_POST["action"] === "login") {
        $username = $_POST["username"];
        $password = $_POST["password"];

        login_author($username, $password);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../admin/admin.css">
</head>
<body style="background-image:url('../category/rice.jpg');">
<?php require_once'../parts/header.php'; ?>
    <div class="main">   
    <form action="" method="post">
    <input type="hidden" name="action" value="login">
        <table class="">
            <tr><th colspan="2"><h1>Auther Login</h1></th></tr>
            <tr>
                <td>Username:</td>
                <td><input type="text" name="username" id="" required/></td>
            </tr>
            <tr>
                <td>Password:</td>
                <td><input type="password" name="password" id="" required/></td>
            </tr>
            <tr><td><input type="submit" value="Signin"/></td></tr>
        </table>
    </form>
    </div>
</body>
</html>
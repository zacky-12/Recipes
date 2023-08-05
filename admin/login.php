<?php
session_start();
// Start the session (assuming this code is in a file where session management is needed)
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $hostname = "localhost";
    $username_db = "root";
    $password_db = "";
    $database = "foods";

    $connection = new mysqli($hostname, $username_db, $password_db, $database);
    $username = $_POST["username"];
    $password = $_POST["password"];

    $query = "SELECT id, username, password FROM admins WHERE username = ?";
    $statement = $connection->prepare($query);
    $statement->bind_param("s", $username);
    $statement->execute();
    $result = $statement->get_result();

    if ($result->num_rows === 1) {
        $admin = $result->fetch_assoc();
        if (password_verify($password, $admin['password'])) {
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_username'] = $admin['username'];
            header("refresh:1; url=authors.php");
            exit;
        } else {
            $text= "Invalid password or username. Please try again!!";
            echo '<p class ="text">'.$text.'</p>';
        }

    $statement->close();
    $connection->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body style="background-image:url('../category/chop.jpg');">
<?php require_once'../parts/header.php'; ?>
<div class="main" style="padding-top:10%;">    
    <form action="" method="post"> <!-- Set the action attribute to the correct PHP script URL -->
        <table>
            <tr><td colspan="2"><h1>Admin Login</h1></td></tr>
            <tr>
                <td colspan="2"><input type="hidden" name="action" value="login"/></td>
            </tr>
            <tr>
                <td><label for="username">Username:</label></td>
                <td><input type="text" name="username" required></td>
            </tr>
            <tr>
                <td><label for="password">Password:</label></td>
                <td><input type="password" name="password" required></td>
            </tr>
            <tr>
                <td><input type="submit" class="button" value="Sign In"></td>
            </tr>
        </table>
    </form>
</div>
</body>
</html>


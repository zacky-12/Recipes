<?php
function create_admin($fname, $sirname, $email, $phone, $username, $password) {
    $hostname = "localhost";
    $username_db = "root";
    $password_db = "";
    $database = "foods";

    $connection = new mysqli($hostname, $username_db, $password_db, $database);

    $check_query = "SELECT id FROM admins WHERE username = ?";
    $check_statement = $connection->prepare($check_query);
    $check_statement->bind_param("s", $username);
    $check_statement->execute();
    $result = $check_statement->get_result();

    if ($result->num_rows > 0) {
        echo "<p>Username already exists. <br/> 
        Please choose a different username.</p>";
        $check_statement->close();
        $connection->close();
        return; 
    }
        $insert_query = "INSERT INTO admins(fname, sirname, email, phone, username, password) VALUES (?,?,?,?,?,?)";
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $insert_statement = $connection->prepare($insert_query);
        $insert_statement->bind_param("ssssss", $fname, $sirname, $email, $phone, $username, $hashed_password);
    
        if ($insert_statement->execute()) {
            echo "<p>Hello ".$username.", you are now an admin</p>";
            header("refresh:2;url=login.php");
            exit;
        } else {
            echo "Error creating author account: " . $connection->error;
        }
        $insert_statement->close();
        $connection->close();
    }
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        if (isset($_POST["action"]) && $_POST["action"] === "register") {
            $fname    = $_POST["fname"];
            $sirname  = $_POST["sirname"];
            $email    = $_POST["email"];
            $phone    = $_POST["phone"];
            $username = $_POST["username"];
            $password = $_POST["password"];

            create_admin($fname, $sirname, $email, $phone, $username, $password);
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
<body style="background-image: url('../category/tamanna-rumee-DoUgSMezLp0-unsplash.jpg'); background-repeat: no-repeat; background-size:cover;">
<?php require_once'../parts/header.php'; ?>
<div class="form">       
    <form action="" method="post" onsubmit="return checkPasswords()">
        <table style="background-image: image('');">
            <tr><th colspan="2"> <h2>Admin Sign Up</h2> </th></tr>
            <tr>
                <td colspan="2"><input type="hidden" name="action" value="register"></td>
            </tr>
            <tr>
                <td><label for="fname">First Name:</label></td>
                <td><input type="text" name="fname" id="" required/></td>
            </tr>
            <tr>
                <td><label for="sirname">Sirname:</label></td>
                <td><input type="text" name="sirname" id="" required/></td>
            </tr>
            <tr>
                <td><label for="email">Email:</label></td>
                <td><input type="email" name="email" id="" required/></td>
            </tr>
            <tr>
                <td><label for="phone">Phone Number:</label></td>
                <td><input type="text" name="phone" id="" pattern="[+0-9]{10,13}" required/></td>
            </tr>
            <tr>
                <td><label for="username">Username:</label></td>
                <td><input type="text" name="username" required></td>
            </tr>
            <tr>
                <td><label for="password">Password:</label></td>
                <td><input type="password" name="password" id="password" required></td>
            </tr>
            <tr>
                <td><label for="confirm_password">Confirm Password:</label></td>
                <td><input type="password" name="confirm_password" id="confirm_password" required></td>
            </tr>
            <tr><td colspan="2"><div id="password_match_message" style="font-weight: bold;"></div></td></tr>
            <tr><td colspan="2"><a href="http://">Continue as guest</a></td></tr>
            <tr><td><input type="submit" class="button" value="REGISTER"/></td></tr>
        </table>
    </form>

    <script>
        function checkPasswords() {
            const password = document.getElementById('password').value;
            const confirm_password = document.getElementById('confirm_password').value;
            const message = document.getElementById('password_match_message');

            if (password !== confirm_password) {
                message.innerHTML = "PASSWORDS DO NOT MATCH!!";
                return false; 
            } else {
                message.innerHTML = ""; 
                return true; 
            }
        }
    </script>
    </div>
</body>
</html>
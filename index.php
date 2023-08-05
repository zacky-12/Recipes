<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="admin/admin.css">
    <style>
        strong{
            font-size:50px;
        }
        .form{
            width: 30%;
        }
        table{
            
        }
    </style>
</head>
<body style="background-image: url('category/breakfast.jpg');">
    <?php require_once 'parts/header.php'; ?>
    <div class="form">
    <table class="contain">
        <tr>
            <th><strong>Log In <a href="http://localhost:8080/Recipes/admin/login.php">as Admin</a> or <a href="http://localhost:8080/Recipes/author/login.php">as Author</a></strong></th>
        </tr>
        <tr>
            <th><strong>Dont have an account?<br/>
            Register <a href="http://localhost:8080/Recipes/admin/signup.php">as Admin</a> or <a href="http://localhost:8080/Recipes/author/signup.php">as Author</a></strong></th>
        </tr>
        <tr>
            <th><strong>Continue <a href="http://localhost:8080/Recipes/view.php">as Guest</a></strong></th>
        </tr>
    </table>
</div>
</body>
</html>
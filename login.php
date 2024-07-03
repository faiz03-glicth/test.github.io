<?php
session_start();
include("config.php");
include("function.php");


$user_data = check_login($conn);

if($_SERVER['REQUEST_METHOD'] == "POST")
    {
        //something was posted
        $username = $_POST['username'];
        $password = $_POST['password'];

        if(!empty($username) && !empty($password) && !is_numeric($username))
        {
            //read from database
            $query = "select * from user where username = '$username' limit 1";

            $result = mysqli_query($conn, $query);

            if($result)
            {
                if($result && mysqli_num_rows($result) > 0)
                {
                    $user_data = mysqli_fetch_assoc($result);
                    
                    if($user_data['password'] === $password)
                    {
                        $_SESSION['userid'] = $user_data['userid'];
                        header("Location: index.php");
                        die;   
                    }
                }
            }
            echo "Wrong username/password!";
        }else
        {
            echo "Wrong username/password!";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body> 
    <div class="auth-container">
        <h2>User Login</h2>
        <form method="POST"  action = "login.php">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
        <p>Don't have an account? <a href="register.php">Register here</a></p>
        <p>Admin? <a href="admin_login.php">Login here</a></p>
    </div>
</body>
</html>

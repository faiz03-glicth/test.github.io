<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
include("config.php");

if($_SERVER['REQUEST_METHOD'] == "POST")
    {
        //something was posted
        $username = $_POST['username'];
        $password = $_POST['password'];

        if(!empty($username) && !empty($password) && !is_numeric($username))
        {
            //read from database
            $query = "select * from admin where username = '$username' limit 1";

            $result = mysqli_query($conn, $query);

            if($result)
            {
                if($result && mysqli_num_rows($result) > 0)
                {
                    $user_data = mysqli_fetch_assoc($result);
                    
                    if($user_data['password'] === $password)
                    {
                        $_SESSION['userid'] = $user_data['userid'];
                        header("Location: admin.php");
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
    <title>Admin Login</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="auth-container">
        <h2>Admin Login</h2>
        <form method="POST" action="admin_login.php">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
            <p>Dont have admin account? <a href = "admin_register.php">Register here</a></p>
        </form>
    </div>
</body>

</html>

<?php include('./config/constants.php'); ?>

<html>
    <head>
        <title>Login - Food Order System</title>
        <link rel="stylesheet" href="../css/admin.css">
    </head>

    <body>
        
        <div class="login">
            <h1 class="text-center">Login</h1>
            <br><br>

            <?php
                    if(isset($_SESSION['login']))
                    {
                        echo $_SESSION['login'];
                        unset($_SESSION['login']);
                    }

                    if(isset($_SESSION['no-login-message']))
                    {
                        echo $_SESSION['no-login-message'];
                        unset($_SESSION['no-login-message']);
                    }
            ?>
            <br><br>

            <!-- Login Form Start Here -->
            <form action="" method="POST" class="text-center">
            Username: <br>
            <input type="text" name="username" placeholder="Enter username"> <br><br>

            Password: <br>
            <input type="password" name="password" placeholder="Enter password"> <br><br>
                

            <br><br>
            <input type="submit" name="submit" value="Login" class="btn-add">
            </form>
            <!-- Login Form End Here -->

            <br><br><br>
            <p class="text-center">Created by - Group 5</p>
        </div>
    </body>
</html>

<?php

    if(isset($_POST['submit']))
    {
        echo $username = $_POST['username'];
        echo $password = $_POST['password'];

        $sql = "SELECT * FROM admin WHERE username = '$username' AND password = '$password'";

        $res = mysqli_query($conn, $sql);

        $count = mysqli_num_rows($res);

        if($count == 1)
        {
            $_SESSION['login'] = "<div class='success'>Login Successful.</div>";
            $_SESSION['user'] = $username;
            header('location:'.SITEURL.'admin/');
        }
        else
        {
            $_SESSION['login'] = "<div class='error text-center'>Username or Password did not match.</div>";
            header('location:'.SITEURL.'admin/login.php');
        }
    }

?>
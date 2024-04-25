<?php include('../admin/config/constants.php'); ?>

<html>
    <head>
        <title>Login</title>
        <link rel="stylesheet" href="../css/customer.css">
    </head>

    <body>
        
        <div class="login">
            <h1 class="text-center">Login - Customer</h1>
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
            <input type="submit" name="submit" value="Login" class="btn-confirm"> <br><br>

            <input type="submit" name="sign-up" value="Sign Up" class="btn-confirm">

            <input type="submit" name="admin" value="I'm Admin" class="btn-confirm">
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
        $username = $_POST['username'];
        $password = $_POST['password'];

        $sql = "SELECT * FROM customer WHERE username = '$username' AND password = '$password'";

        $res = mysqli_query($conn, $sql);

        $count = mysqli_num_rows($res);
        if(isset($_POST['submit'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];
    
            $sql = "SELECT * FROM customer WHERE username = '$username' AND password = '$password'";
            $res = mysqli_query($conn, $sql);
    
            if(mysqli_num_rows($res) == 1) {
                $row = mysqli_fetch_assoc($res);
                $status = $row['status'];
                if($status == 1) {
                    $_SESSION['login'] = "<div class='success'>Login Successful.</div>";
                    $_SESSION['user'] = $username;
    
                    // Get user ID
                    $user_id = $row['ID'];
                    
                    // Redirect with user ID
                    header('location:'.SITEURL.'customer/index.php?id='.$user_id);
                    exit();
                } else {
                    $_SESSION['login'] = "<div class='error text-center'>Account has been locked.</div>";
                    header('location:'.SITEURL.'customer/login.php');
                    exit();
                }   
            } else {
                $_SESSION['login'] = "<div class='error text-center'>Username or Password did not match.</div>";
                header('location:'.SITEURL.'customer/login.php');
                exit();
            }
        }
    }

    if(isset($_POST['sign-up']))
    {
        header('location:'.SITEURL.'customer/sign-up.php');
    }

    if(isset($_POST['admin']))
    {
        header('location:'.SITEURL.'admin/login.php');
    }

?>
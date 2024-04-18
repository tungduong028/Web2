<?php include('../admin/config/constants.php'); ?>

<html>
    <head>
        <title>Sign Up</title>
        <link rel="stylesheet" href="../css/customer.css">
    </head>

    <body>
        
        <div class="sign-up">
            <h1 class="text-center">Sign Up</h1>
            <br><br>
            <?php
                    if(isset($_SESSION['signup']))
                    {
                        echo $_SESSION['signup'];
                        unset($_SESSION['signup']);
                    }
            ?>
            <br><br>

            <!-- Sign up Form Start Here -->
            <form action="" method="POST" class="text-center">
            Username: <br>
            <input type="text" name="username" placeholder="Enter username"> <br><br>

            Password: <br>
            <input type="password" name="password" placeholder="Enter password"> <br><br>

            Confirm Password: <br>
            <input type="password" name="confirm-password" placeholder="Enter password again"> <br><br>

            Name: <br>
            <input type="text" name="name" placeholder="Enter name"> <br><br>
            
            Address: <br>
            <input type="text" name="address" placeholder="Enter address"> <br><br>

            Phone: <br>
            <input type="text" name="phone" placeholder="Enter phone number"> <br><br>

            <br><br>
            <input type="submit" name="submit" value="Sign Up" class="btn-confirm">

            <br><br>
            <input type="submit" name="login" value="Already have account. Login" class="btn-confirm">

            </form>
            <!-- Sign up Form End Here -->

            <br><br>
            <p class="text-center">Created by - Group 5</p>
        </div>
    </body>
</html>

<?php

    if(isset($_POST['submit']))
    {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm-password'];
        $name = $_POST['name'];
        $address = $_POST['address'];
        $phone = $_POST['phone'];

        # Kiem tra co tai khoan nay chua
        $sql = "SELECT * FROM customer WHERE username = '$username'";

        $res = mysqli_query($conn, $sql);

        $count = mysqli_num_rows($res);

        # Kiem tra tat ca truong co duoc nhap khong
        if($username == "" || $password == "" || $name == "" || $address == "" || $phone == "")
        {
            $_SESSION['signup'] = "<div class='error text-center'>Please Enter All Field.</div>";
            header('location:'.SITEURL.'customer/sign-up.php');
        }
        else
        {
            # Kiem tra mat khau
            if($password != $confirm_password)
            {
                $_SESSION['signup'] = "<div class='error text-center'>Password is Incorrect.</div>";
                header('location:'.SITEURL.'customer/sign-up.php');
            }
            else
            {
                # Kiem tra so dien thoai
                if(ctype_digit($phone) == FALSE)
                {
                    $_SESSION['signup'] = "<div class='error text-center'>Phone must be number.</div>";
                    header('location:'.SITEURL.'customer/sign-up.php');
                }
                else
                {
                    # Neu tai khoan khong ton tai thi dang ki
                    if($count == 0)
                    {
                        $sql = "INSERT INTO customer SET
                        username='$username' ,
                        password='$password' ,
                        name='$name' ,
                        address='$address' ,
                        phone='$phone' ,
                        status=1
                        ";

                        $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));

                        # Kiem tra
                        if($res == TRUE)
                        {
                        $_SESSION['signup'] = "<div class='success'>Sign Up Successful.</div>";
                        header('location:'.SITEURL.'customer/');
                        }
                        else
                        {
                            $_SESSION['signup'] = "<div class='error text-center'>Sign Up Failed. Try Again Later.</div>";
                            header('location:'.SITEURL.'customer/sign-up.php');
                        }
                    }
                    else
                    {
                        $_SESSION['signup'] = "<div class='error text-center'>Account Already Exists.</div>";
                        header('location:'.SITEURL.'customer/sign-up.php');
                    }
                }
            }
        }  
    }

    if(isset($_POST['login']))
    {
        header('location:'.SITEURL.'customer/login.php');
    }

?>
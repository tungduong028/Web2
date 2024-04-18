<?php

    if(!isset($_SESSION['user']))
    {
        $_SESSION['no-login-message'] = "<div class='error text-center'>Please login to use service.</div>";
        header('location:'.SITEURL.'customer/login.php');
    }

?>
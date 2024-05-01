<?php
    include('config/constants.php');
    include('login-check.php');
?>

<html>
    <head>
        <title>FastFood PHP - Manage Pages</title>

        <link rel="stylesheet" href="../css/admin.css">
    </head>

    <body>
        <!-- Menu -->
        <div class="menu">
            <div class="wrapper">
                <ul class="ul">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="manage-admin.php">Admin</a></li>
                    <li><a href="manage-customer.php">Customer</a></li>
                    <li><a href="manage-category.php">Category</a></li>
                    <li><a href="manage-food.php">Food</a></li>
                    <li><a href="manage-order.php">Order</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
<?php
    include('../admin/config/constants.php');
    include('login-check.php');
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!-- Responsive -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant Website</title>

    <!-- Link CSS file -->
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <!-- Header -->
    <section class="navbar">
        <div class="container">
            <div class="logo">
                <a href="#" title="Logo">
                    <img src="../images/logo4.png" alt="Restaurant Logo" class="img-responsive">
                </a>
            </div>

            <div class="menu text-right">
                <ul>
                    <li>
                        <a href="index.php">Trang chủ</a>
                    </li>
                    <li>
                        <a href="categories.php">Danh mục</a>
                    </li>
                    <li>
                        <a href="foods.php">Món ăn</a>
                    </li>
                    <li>
                        <a href="advanced-search.php">Tìm nâng cao</a>
                    </li>
                    <li>
                        <a href="infomation.php"><?php echo $_SESSION['user']; ?></a>
                    </li>
                    <li>
                        <a href="cart.php">Giỏ hàng</a>
                    </li>
                    <li>
                        <a href="history.php">Lịch sử mua hàng</a>
                    </li>
                    <li>
                        <a href="logout.php">Đăng xuất</a>
                    </li>
                </ul>
            </div>

            <div class="clearfix"></div>
        </div>
    </section>
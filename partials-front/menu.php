<?php include('admin/config/constants.php') ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!-- Responsive -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant Website</title>

    <!-- Link CSS file -->
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <!-- Header -->
    <section class="navbar">
        <div class="container">
            <div class="logo">
                <a href="#" title="Logo">
                    <img src="images/logo4.png" alt="Restaurant Logo" class="img-responsive">
                </a>
            </div>

            <div class="menu text-right">
                <ul>
                    <li>
                        <a href="<?php echo SITEURL; ?>">Trang chủ</a>
                    </li>
                    <li>
                        <a href="<?php echo SITEURL; ?>categories.php">Danh mục</a>
                    </li>
                    <li>
                        <a href="<?php echo SITEURL; ?>foods.php">Món ăn</a>
                    </li>
                    <li>
                        <a href="advanced-search.php">Tìm nâng cao</a>
                    </li>
                    <li>
                        <a href="<?php echo SITEURL; ?>customer/login.php">Đăng nhập</a>
                    </li>
                </ul>
            </div>

            <div class="clearfix"></div>
        </div>
    </section>
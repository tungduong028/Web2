<?php
    include('../admin/config/constants.php');
    include('login-check.php');
?>

<html>
    <head>


        <link rel="stylesheet" href="../css/customer.css">
    </head>

    <body>
        <!-- Menu -->
        <div class="menu">
            <div class="menu-item name">
                <a href="infomation.php"><?php echo $_SESSION['user']; ?></a>
            </div>

            <div class="wrapper menu-item">
                <ul class="ul">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="">Category</a></li>
                    <li><a href="">Food</a></li>
                    <li><a href="">Order</a></li>
                    <li><a href="">Contact</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </div>

            <div class="menu-item cart">
                <button type="button" onclick=goToCart()>Cart</button>
                <script>
                    function goToCart() {
                        location.assign("cart.php");
                    }
                </script>
            </div>
        </div>
</html>
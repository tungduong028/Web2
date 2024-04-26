<?php

include('patials/menu.php');
?>
<link rel="stylesheet" href="../css/cart.css">
<!-- Main content -->
<div class="main-content">
    <div class="wrapper">
        <h1>Giỏ hàng</h1>

        <?php
        // Kiểm tra xem giỏ hàng có sản phẩm hay không
        if(isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
        ?>
        <br>
        <table class="table-full">
            <tr>
                <th>Sản Phẩm</th>
                <th>Hình</th>
                <th>Giá</th>
                <th>Số lượng</th>
                <th>Thành Tiền</th>
                <th>Xóa</th>
            </tr>
            <?php
            $total_price = 0; // Biến tổng giá trị đặt hàng
            foreach($_SESSION['cart'] as $key => $item) {
                $product_title = $item['title'];
                $product_price = $item['price'];
                $product_quantity = $item['quantity'];
                $product_total = $product_price * $product_quantity;
                $total_price += $product_total;
                ?>
                <tr>
                    <td><?php echo $product_title; ?></td>
                    <td>image</td>
                    <td><?php echo number_format($product_price, 0, ",", "."); ?> VNĐ</td>
                    <td><?php echo $product_quantity; ?></td>
                    <td><?php echo number_format($product_total, 0, ",", "."); ?> VNĐ</td>
                    <td><a href="remove-from-cart.php?food_id=<?php echo $key; ?>" class="btn-danger">Xóa</a></td>
                </tr>
                <?php
            }
            ?>
            <tr>
                <td colspan="4" class="text-right"><strong>Tổng cộng</strong></td>
                <td colspan="2"><strong><?php echo number_format($total_price, 0, ",", "."); ?> VNĐ</strong></td>
            </tr>
        </table>
        <a href="checkout.php" class="btn btn-primary">Thanh toán</a>
        <?php
        } else {
            // Nếu giỏ hàng trống, hiển thị thông báo
            echo "<p>Giỏ hàng của bạn đang trống.</p>";
        }
        ?>
    </div>
</div>

<?php include('patials/footer.php'); ?>

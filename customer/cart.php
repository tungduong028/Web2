<?php

include('patials/menu.php');
?>

<!-- Main content -->
<div class="main-content">
    <div class="wrapper">
        <h1 style="margin-left: 80px; margin-top: 30px">Giỏ hàng</h1>

        <?php
        // Kiểm tra xem giỏ hàng có sản phẩm hay không
        if(isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
        ?>
        <br>
        <table class="table-full">
            <tr>
                <th>Sản Phẩm</th>
                <th>Ảnh sản phẩm</th>
                <th>Giá</th>
                <th>Số lượng</th>
                <th>Thành Tiền</th>
                <th>Xóa</th>
            </tr>
            <?php
            $total_price = 0; // Biến tổng giá trị đặt hàng
            foreach($_SESSION['cart'] as $key => $item) {
                $food_title = $item['title'];
                $food_image = $item['image'];
                $food_price = $item['price'];
                $food_quantity = $item['quantity'];
                $food_total = $food_price * $food_quantity;
                $total_price += $food_total;
                ?>
                <tr>
                    <td><?php echo $food_title; ?></td>
                    <td><?php 
                        if($food_image=="")
                        {
                            echo "<div class='error'>Image not added.</div>";
                        }
                        else
                        {
                            ?>
                                <img src="<?php echo SITEURL; ?>images/food/<?php echo $food_image; ?>" width="100px">
                            <?php
                        }
                        ?></td>
                    <td><?php echo number_format($food_price, 0, ",", "."); ?> VNĐ</td>
                    <td><?php echo $food_quantity; ?></td>
                    <td><?php echo number_format($food_total, 0, ",", "."); ?> VNĐ</td>
                    <td><a href="remove-from-cart.php?food_id=<?php echo $key; ?>" class="error">Xóa</a></td>
                </tr>
                <?php
            }
            ?>
            <tr>
                <td colspan="4" class="text-right"><strong>Tổng cộng</strong></td>
                <td colspan="2"><strong><?php echo number_format($total_price, 0, ",", "."); ?> VNĐ</strong></td>
            </tr>
        </table>
        <a style="margin-left: 80px;" href="select-address.php" class="btn btn-primary">Thanh toán</a>
        <?php
        // Lưu tổng giá trị đơn hàng vào session
        $_SESSION['total_order'] = $total_price;
        } else {
            // Nếu giỏ hàng trống, hiển thị thông báo
            echo "<p>Giỏ hàng của bạn đang trống.</p>";
        }
        ?>
    </div>
</div>
<br>
<br>

<?php include('patials/footer.php'); ?>

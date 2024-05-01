<?php
include('patials/menu.php');
?>
<link rel="stylesheet" href="../css/cart.css">
<!-- Main content -->
<div class="main-content">
    <div class="wrapper">
        <h1>Details order</h1>

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
                </tr>
                <?php
            }
            ?>
            <tr>
                <td colspan="5" style="border-bottom: 1px solid black;"></td>
            </tr>

            <tr>
                <td colspan="4" class="text-right"><strong>Tổng cộng</strong></td>
                <td colspan="2"><strong><?php echo number_format($total_price, 0, ",", "."); ?> VNĐ</strong></td>
            </tr>
        </table>
        <!-- <a href="select-address.php" class="btn btn-primary">Thanh toán</a> -->
        <?php
        } else {
            // Nếu giỏ hàng trống, hiển thị thông báo
            echo "<p>Không tồn tại hóa đơn</p>";
        }
        ?>
    </div>
</div>

<?php include('patials/footer.php'); ?>

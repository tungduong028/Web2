<?php include('patials/menu.php'); ?>

<?php 
    // Kiểm tra xem ID của sản phẩm đã được truyền từ URL chưa
    if(isset($_GET['id'])) {
        $id = $_GET['id'];

        // Truy vấn thông tin của sản phẩm dựa trên ID
        $sql = "SELECT * FROM food WHERE id = $id AND active = 'Yes'";
        $res = mysqli_query($conn, $sql);
        $count = mysqli_num_rows($res);

        if($count == 1) {
            // Hiển thị chi tiết của sản phẩm
            $row = mysqli_fetch_assoc($res);
            $title = $row['name'];
            $price = $row['price'];
            $description = $row['description'];
            $image = $row['image'];
            ?>
            <!-- Food Detail Section -->
            <section class="food-search">
                <div class="container">
                    <form action="add-to-cart.php" method="POST" class="order background-order">
                        <br>
                        <h2 class="text-center">Chi tiết sản phẩm</h2>
                        <fieldset>
                            <div class="food-menu-img">
                                <img src="<?php echo SITEURL; ?>images/food/<?php echo $image; ?>" alt="<?php echo $title; ?>" class="img-responsive img-curve">
                            </div>
        
                            <div class="food-menu-desc">
                                <h3 style="text-transform: uppercase;"><?php echo $title; ?></h3>
                                <p class="food-price">Giá: <?php echo number_format($price); ?> VNĐ</p>
                                <p>Mô tả: <?php echo $description; ?></p>
                                <br>

                                <form action="add-to-cart.php" method="POST">
                                <input type="hidden" name="food_id" value="<?php echo $id; ?>">
                                <input type="hidden" name="image" value="<?php echo $image; ?>">
                                <input type="hidden" name="food_title" value="<?php echo $title; ?>">
                                <input type="hidden" name="food_price" value="<?php echo $price; ?>">
                                <input type="number" name="quantity" value="1" min="1">
                                <input type="submit" name="add_to_cart" class="btn btn-primary" value="Thêm vào giỏ hàng">
                            </form>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </section>
            <!-- End Food Detail Section -->
            <?php
        } else {
            // Hiển thị thông báo lỗi nếu không tìm thấy sản phẩm
            echo "<div class='error'>Không tìm thấy sản phẩm.</div>";
        }
    } else {
        // Nếu không có ID được truyền, chuyển hướng người dùng về trang chính
        header('location: index.php');
    }
?>

<?php include('patials/footer.php'); ?>

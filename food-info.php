<?php include('partials-front/menu.php'); ?>

<?php 
    // Kiểm tra xem ID của sản phẩm đã được truyền từ URL chưa
    if(isset($_GET['id'])) {
        $food_id = $_GET['id'];

        // Truy vấn thông tin của sản phẩm dựa trên ID
        $sql = "SELECT * FROM food WHERE id = $food_id AND active = 'Yes'";
        $res = mysqli_query($conn, $sql);
        $count = mysqli_num_rows($res);

        if($count == 1) {
            // Hiển thị chi tiết của sản phẩm
            $row = mysqli_fetch_assoc($res);
            $food_title = $row['name'];
            $food_price = $row['price'];
            $food_description = $row['description'];
            $food_image = $row['image'];
            ?>
            <!-- Food Detail Section -->
            <section class="food-search">
                <div class="container">
                    <form action="#" class="order background-order">
                        <br>
                        <h2 class="text-center">Chi tiết sản phẩm</h2>
                        <fieldset>

                            <div class="food-menu-img">
                                <img src="<?php echo SITEURL; ?>images/food/<?php echo $food_image; ?>" alt="<?php echo $food_title; ?>" class="img-responsive img-curve">
                            </div>
        
                            <div class="food-menu-desc">
                                <h3 style="text-transform: uppercase;"><?php echo $food_title; ?></h3>
                                <p class="food-price">Giá: <?php echo number_format($food_price); ?> VNĐ</p>
                                <p>Mô tả: <?php echo $food_description; ?></p>
                                <br>
                                <a href="<?php echo SITEURL; ?>customer/login.php" class="btn btn-primary">Đặt món</a>
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

<?php include('partials-front/footer.php'); ?>

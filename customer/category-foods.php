<?php include('patials/menu.php'); ?>

<section class="food-search text-center">
    <div class="container">
        <?php
        // Kiểm tra xem ID của danh mục được chọn có tồn tại không
        if(isset($_GET['id'])) {
            $category_id = $_GET['id'];
            $sql_category = "SELECT title FROM category WHERE id = $category_id AND active = 'Yes'";
            $res_category = mysqli_query($conn, $sql_category);
            $count_category = mysqli_num_rows($res_category);

            if($count_category > 0) {
                $row_category = mysqli_fetch_assoc($res_category);
                $category_title = $row_category['title'];
                ?>
                <h2 style="color: white;">Món ăn trong danh mục "<?php echo $category_title; ?>"</h2>
                <?php
            } else {
                // Nếu ID không hợp lệ, hiển thị thông báo lỗi và kết thúc kịch bản
                $_SESSION['error'] = "Danh mục không tồn tại.";
                header('location: categories.php');
                exit;
            }
        } else {
            // Nếu không có ID được chọn, chuyển hướng người dùng về trang danh mục
            header('location: categories.php');
            exit;
        }
        ?>
    </div>
</section>

<!-- Food -->
<section class="food-menu">
    <div class="container">
        <h2 class="text-center">Menu món ăn</h2>

        <?php 
        // Số món ăn trên mỗi trang
        $per_page = 2;

        // Truy vấn tổng số món ăn thuộc danh mục được chọn
        $sql_count = "SELECT COUNT(*) AS total FROM food WHERE category_id = $category_id AND active='Yes'";
        $res_count = mysqli_query($conn, $sql_count);
        $row_count = mysqli_fetch_assoc($res_count);
        $total_records = $row_count['total'];

        // Tính tổng số trang
        $total_pages = ceil($total_records / $per_page);

        // Xác định trang hiện tại
        $current_page = isset($_GET['page']) ? $_GET['page'] : 1;

        // Tính offset
        $offset = ($current_page - 1) * $per_page;

        // Truy vấn danh sách món ăn theo trang
        $sql_foods = "SELECT * FROM food WHERE category_id = $category_id AND active='Yes' LIMIT $offset, $per_page";
        $res_foods = mysqli_query($conn, $sql_foods);
        $count_foods = mysqli_num_rows($res_foods);

        if($count_foods > 0) {
            while($row_food = mysqli_fetch_assoc($res_foods)) {
                $id = $row_food['id'];
                $title = $row_food['name'];
                $price = $row_food['price'];
                $description = $row_food['description'];
                $image = $row_food['image'];
                ?>
                <div class="food-menu-box">
                    <div class="food-menu-img">
                        <?php
                        if($image == ""){
                            echo "<div class='error'>Image not available.</div>";
                        }
                        else{
                        ?>
                            <img src="<?php echo SITEURL; ?>images/food/<?php echo $image; ?>" alt="Pizza" class="img-responsive img-curve">
                        <?php
                        }
                        ?>
                    </div>

                    <div class="food-menu-desc">
                        <h4><?php echo $title; ?></h4>
                        <p class="food-price"><?php echo $price; ?> VNĐ</p>
                        <p class="food-detail">
                            <?php echo $description; ?>
                        </p>
                        <br>

                        <!-- Form thêm vào giỏ hàng -->
                        <form action="add-to-cart.php" method="POST">
                            <input type="hidden" name="food_id" value="<?php echo $id; ?>">
                            <input type="hidden" name="image" value="<?php echo $image; ?>">
                            <input type="hidden" name="food_title" value="<?php echo $title; ?>">
                            <input type="hidden" name="food_price" value="<?php echo $price; ?>">
                            <input type="number" name="quantity" value="1" min="1">
                            <input type="submit" name="add_to_cart" class="btn btn-primary" value="Thêm vào giỏ hàng">
                        </form>
                    </div>
                </div>
                <?php
            }
        } else {
            echo "<div class='error'>Không có món ăn nào trong danh mục này.</div>";
        }
        ?>

        <div class="clearfix"></div>
    </div>
    <!-- Phân trang -->
    <div class="pagination">
            <?php if($current_page > 1) : ?>
                <a href="?id=<?php echo $category_id; ?>&page=1"><<</a>
                <a href="?id=<?php echo $category_id; ?>&page=<?php echo $current_page - 1; ?>"><</a>
            <?php endif; ?>
            
            <?php for($i = 1; $i <= $total_pages; $i++) : ?>
                <a <?php if($i == $current_page) echo 'class="active"'; ?> href="?id=<?php echo $category_id; ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a>
            <?php endfor; ?>
            
            <?php if($current_page < $total_pages) : ?>
                <a href="?id=<?php echo $category_id; ?>&page=<?php echo $current_page + 1; ?>">></a>
                <a href="?id=<?php echo $category_id; ?>&page=<?php echo $total_pages; ?>">>></a>
            <?php endif; ?>
        </div>
</section>

<?php include('patials/footer.php'); ?>

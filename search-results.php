<?php include('partials-front/menu.php'); ?>

<section style="height: 430px;" class="main-content food-menu">
    <div class="container">
        <h2 class="text-center">Kết quả tìm kiếm</h2>

        <?php
        // Lấy dữ liệu từ biểu mẫu tìm kiếm nâng cao
        $search = isset($_GET['search']) ? $_GET['search'] : '';
        $category_id = isset($_GET['category']) ? $_GET['category'] : '';
        $price_min = isset($_GET['price_min']) ? $_GET['price_min'] : '';
        $price_max = isset($_GET['price_max']) ? $_GET['price_max'] : '';

        // Xây dựng câu truy vấn SQL dựa trên các điều kiện tìm kiếm
        $sql = "SELECT * FROM food WHERE active='Yes'";
        if (!empty($search)) {
            $sql .= " AND (name LIKE '%$search%' OR description LIKE '%$search%')";
        }
        if (!empty($category_id)) {
            $sql .= " AND category_id = $category_id";
        }
        if (!empty($price_min) && !empty($price_max)) {
            $sql .= " AND price BETWEEN $price_min AND $price_max";
        } elseif (!empty($price_min)) {
            $sql .= " AND price >= $price_min";
        } elseif (!empty($price_max)) {
            $sql .= " AND price <= $price_max";
        }

        // Số sản phẩm mỗi trang
        $products_per_page = 2;

        // Lấy trang hiện tại từ URL
        $current_page = isset($_GET['page']) ? $_GET['page'] : 1;

        // Tính offset
        $offset = ($current_page - 1) * $products_per_page;

        // Thực hiện truy vấn để lấy tổng số sản phẩm
        $result_total = mysqli_query($conn, $sql);
        $total_products = mysqli_num_rows($result_total);

        // Tính tổng số trang
        $total_pages = ceil($total_products / $products_per_page);

        // Thêm LIMIT và OFFSET vào câu truy vấn
        $sql .= " LIMIT $offset, $products_per_page";

        // Thực hiện truy vấn
        $result = mysqli_query($conn, $sql);
        $count = mysqli_num_rows($result);

        if ($count > 0) {
            // Hiển thị kết quả tìm kiếm
            while ($row = mysqli_fetch_assoc($result)) {
                $id = $row['id'];
                $title = $row['name'];
                $price = $row['price'];
                $description = $row['description'];
                $image = $row['image'];
                ?>

                    <div class="food-menu-box">
                        <a class="food-menu-img" href="food-info.php?id=<?php echo $id; ?>">
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
                        </a>

                        <div class="food-menu-desc">
                            <h4><a style="color: black;text-transform: uppercase;" href="food-info.php?id=<?php echo $id; ?>"><?php echo $title; ?></a></h4>
                            <p class="food-price">Giá: <?php echo $price; ?> VNĐ</p>
                            <p class="food-detail">Mô tả: <?php echo $description; ?></p>
                            <br>
                            <a href="<?php echo SITEURL; ?>customer/login.php" class="btn btn-primary">Đặt món</a>
                        </div>
                    </div>
                <?php
            }
        } else {
            echo "<div class='error'>Không tìm thấy kết quả nào.</div>";
        }
        ?>
        <div class="clearfix"></div>
    </div>
    <!-- Phân trang -->
<div class="pagination">
    <?php if ($total_pages > 1) : ?>
        <?php if ($current_page > 1) : ?>
            <a href="?page=1&search=<?php echo $search; ?>&category=<?php echo $category_id; ?>&price_min=<?php echo $price_min; ?>&price_max=<?php echo $price_max; ?>"><<</a>
            <a href="?page=<?php echo $current_page - 1; ?>&search=<?php echo $search; ?>&category=<?php echo $category_id; ?>&price_min=<?php echo $price_min; ?>&price_max=<?php echo $price_max; ?>"><</a>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
            <a <?php if ($i == $current_page) echo 'class="active"'; ?> href="?page=<?php echo $i; ?>&search=<?php echo $search; ?>&category=<?php echo $category_id; ?>&price_min=<?php echo $price_min; ?>&price_max=<?php echo $price_max; ?>"><?php echo $i; ?></a>
        <?php endfor; ?>

        <?php if ($current_page < $total_pages) : ?>
            <a href="?page=<?php echo $current_page + 1; ?>&search=<?php echo $search; ?>&category=<?php echo $category_id; ?>&price_min=<?php echo $price_min; ?>&price_max=<?php echo $price_max; ?>">></a>
            <a href="?page=<?php echo $total_pages; ?>&search=<?php echo $search; ?>&category=<?php echo $category_id; ?>&price_min=<?php echo $price_min; ?>&price_max=<?php echo $price_max; ?>">>></a>
        <?php endif; ?>
    <?php endif; ?>
</div>
</section>

<?php include('partials-front/footer.php'); ?>
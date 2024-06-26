<?php include('partials-front/menu.php'); ?>

<section class="food-search text-center">
    <div class="container">
        
        <form action="food-search.php" method="POST">
            <input type="search" name="search" placeholder="Món ăn cần tìm..." required>
            <input type="submit" name="submit" value="Tìm kiếm" class="btn btn-primary">
        </form>

    </div>
</section>

<!-- Food -->
<section class="food-menu">
    <div class="container">
        <h2 class="text-center">Kết quả tìm kiếm</h2>

        <?php 
        // Số sản phẩm mỗi trang
        $products_per_page = 2;

        // Lấy từ khóa tìm kiếm từ form
        if(isset($_POST['submit'])) {
            $search = $_POST['search'];
        }
        else if(isset($_GET['search'])) {
            $search = $_GET['search'];
        }
        else {
            $search = ""; // Nếu không có từ khóa tìm kiếm, gán là chuỗi rỗng
        }

        // Lấy trang hiện tại từ URL
        $current_page = isset($_GET['page']) ? $_GET['page'] : 1;

        // Tính offset
        $offset = ($current_page - 1) * $products_per_page;

        // Truy vấn để lấy tổng số sản phẩm
        $sql_total = "SELECT COUNT(*) AS total FROM food WHERE active='Yes' AND (name LIKE '%$search%' OR description LIKE '%$search%')";
        $res_total = mysqli_query($conn, $sql_total);
        $row_total = mysqli_fetch_assoc($res_total);
        $total_products = $row_total['total'];

        // Tính tổng số trang
        $total_pages = ceil($total_products / $products_per_page);

        // Truy vấn để lấy danh sách sản phẩm
        $sql = "SELECT * FROM food WHERE active='Yes' AND (name LIKE '%$search%' OR description LIKE '%$search%') LIMIT $offset, $products_per_page";
        $res = mysqli_query($conn, $sql);
        $count = mysqli_num_rows($res);

        if($count > 0){
            while($row = mysqli_fetch_assoc($res))
            {
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
        }
        else{
            echo "<div class='error'>Không tìm thấy kết quả nào.</div>";
        }
        ?>

        <div class="clearfix"></div>


    </div>

<!-- Phân trang -->
<div class="container">
    <div class="pagination">
        <?php if($total_pages > 1): ?>
            <?php if($current_page > 1): ?>
                <a href="?page=1&search=<?php echo $search; ?>"><<</a>
                <a href="?page=<?php echo $current_page - 1; ?>&search=<?php echo $search; ?>"><</a>
            <?php endif; ?>
            
            <?php for($i = 1; $i <= $total_pages; $i++): ?>
                <a <?php if($i == $current_page) echo 'class="active"'; ?> href="?page=<?php echo $i; ?>&search=<?php echo $search; ?>"><?php echo $i; ?></a>
            <?php endfor; ?>
            
            <?php if($current_page < $total_pages): ?>
                <a href="?page=<?php echo $current_page + 1; ?>&search=<?php echo $search; ?>">></a>
                <a href="?page=<?php echo $total_pages; ?>&search=<?php echo $search; ?>">>></a>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>
</section>



<?php include('partials-front/footer.php'); ?>

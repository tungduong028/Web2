<?php include('patials/menu.php'); ?>

<!-- Search -->
<section class="food-search text-center">
    <div class="container">
        
        <form action="food-search.php" method="POST">
            <input type="search" name="search" placeholder="Món ăn cần tìm..." required>
            <input type="submit" name="submit" value="Tìm kiếm" class="btn btn-primary">
        </form>

    </div>
</section>

<!-- Category -->
<section class="categories">
    <div class="container">
        <h2 class="text-center">Khám phá</h2>

        <?php 
            //Hiển categories từ database
            $sql = "SELECT * FROM category WHERE active='Yes' AND show_on_home='Yes' LIMIT 3";
            $res = mysqli_query($conn, $sql);
            $count = mysqli_num_rows($res);
            if($count > 0){
                while($row=mysqli_fetch_assoc($res)){
                    $id = $row['id'];
                    $title = $row['title'];
                    $image_name = $row['image'];
        ?>
                    
                    <a href="category-foods.php?id=<?php echo $id; ?>">
                        <div class="box-3 float-container">
                        <?php
                        if($image_name==""){
                            echo "div class='error'>Image not available</div>";
                        }
                        else{
                        ?>
                            <img src="<?php echo SITEURL; ?>images/category/<?php echo $image_name ?>" alt="Pizza" class="img-responsive img-curve">
                        <?php
                        }
                        ?>
                        

                        <h3 class="float-text text-white"><?php echo $title; ?></h3>
                        </div>
                    </a>

                <?php
                }   
            }
            else{
                echo "<div class ='error'>Category not added.</div>";
            }
        
        ?>

        

        <div class="clearfix"></div>
    </div>
</section>

<!-- Food -->
<section class="food-menu">
    <div class="container">
        <h2 class="text-center">Menu món ăn</h2>

        <?php 
            // Số sản phẩm trên mỗi trang
            $per_page = 6;

            // Tính tổng số sản phẩm
            $sql_count = "SELECT COUNT(*) AS total FROM food WHERE active='Yes'";
            $res_count = mysqli_query($conn, $sql_count);
            $row_count = mysqli_fetch_assoc($res_count);
            $total_records = $row_count['total'];

            // Tính tổng số trang
            $total_pages = ceil($total_records / $per_page);

            // Xác định trang hiện tại
            $current_page = isset($_GET['page']) ? $_GET['page'] : 1;

            // Tính offset
            $offset = ($current_page - 1) * $per_page;

            $sql2 = "SELECT * FROM food WHERE active='Yes' LIMIT $offset, $per_page";
            $res2 = mysqli_query($conn, $sql2);
            $count2 = mysqli_num_rows($res2);

            if($count2 > 0){
                while($row = mysqli_fetch_assoc($res2))
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
                            <p class="food-detail">Mô tả: 
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
            }
            else{
                echo "<div class='error'>Food not available.</div>";
            }
        ?>
            
        <div class="clearfix"></div>

        
    </div>
    <!-- Phân trang -->
    <div class="pagination">
            <?php if($current_page > 1) : ?>
                <a href="?page=1"><<</a>
                <a href="?page=<?php echo $current_page - 1; ?>"><</a>
            <?php endif; ?>
            
            <?php for($i = 1; $i <= $total_pages; $i++) : ?>
                <a <?php if($i == $current_page) echo 'class="active"'; ?> href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
            <?php endfor; ?>
            
            <?php if($current_page < $total_pages) : ?>
                <a href="?page=<?php echo $current_page + 1; ?>">></a>
                <a href="?page=<?php echo $total_pages; ?>">>></a>
            <?php endif; ?>
        </div>
</section>

<?php include('patials/footer.php'); ?>

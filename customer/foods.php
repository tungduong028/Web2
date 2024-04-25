<?php include('patials/menu.php'); ?>

<section class="food-search text-center">
    <div class="container">
        
        <form action="" method="POST">
            <input type="search" name="search" placeholder="Món ăn cần tìm..." required>
            <input type="submit" name="submit" value="Tìm kiếm" class="btn btn-primary">
        </form>

    </div>
</section>

<!-- Food -->
<section class="food-menu">
    <div class="container">
        <h2 class="text-center">Menu món ăn</h2>

        <?php 
            $sql2 = "SELECT * FROM food WHERE active='Yes'";
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

    <p class="text-center">
        <a href="#">Xem thêm món ăn</a>
    </p>
</section>

<?php include('patials/footer.php'); ?>

<?php include('partials-front/menu.php'); ?>

    <section class="food-search text-center">
        <div class="container">
            
            <form action="food-search.html" method="POST">
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

                                    <a href="<?php echo SITEURL; ?>customer/login.php" class="btn btn-primary">Đặt món</a>
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

    <?php include('partials-front/footer.php'); ?>
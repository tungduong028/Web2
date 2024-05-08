<?php include('patials/menu.php'); ?>

<!-- Category -->
<section class="categories">
    <div class="container">
        <h2 class="text-center">Danh mục</h2>

        <?php 
            // Số danh mục trên mỗi trang
            $per_page = 2;

            // Tính tổng số danh mục
            $sql_count = "SELECT COUNT(*) AS total FROM category WHERE active='Yes'";
            $res_count = mysqli_query($conn, $sql_count);
            $row_count = mysqli_fetch_assoc($res_count);
            $total_records = $row_count['total'];

            // Tính tổng số trang
            $total_pages = ceil($total_records / $per_page);

            // Xác định trang hiện tại
            $current_page = isset($_GET['page']) ? $_GET['page'] : 1;

            // Tính offset
            $offset = ($current_page - 1) * $per_page;

            $sql = "SELECT * FROM category WHERE active='Yes' LIMIT $offset, $per_page";
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

<?php include('patials/menu.php'); ?>

<section style="height: 550px; margin-top: 10px;" class="main-content">

<div class="container">

    <h2 class="text-center">TÌM KIẾM NÂNG CAO</h2>

    <form action="search-results.php" method="GET">

        <div class="row">
            <div class="col-md-4">
                <label for="search">Tên sản phẩm:</label>
                <input style="font-size: 16px;width: 420px;" type="text" name="search" id="search" placeholder="Nhập tên sản phẩm...">
            </div>

            <div class="col-md-4">
                <label for="category">Chọn phân loại:</label>
                <select style="font-size: 16px;" name="category" id="category">
                    <option value="">Tất cả phân loại</option>
                    <?php
                    // Lấy danh sách các phân loại từ cơ sở dữ liệu
                    $sql = "SELECT * FROM category WHERE active='Yes'";
                    $result = mysqli_query($conn, $sql);
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<option value='" . $row['id'] . "'>" . $row['title'] . "</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="col-md-4">
                <label for="price_min">Giá từ:</label>
                <input style="font-size: 16px;" type="number" name="price_min" id="price_min" placeholder="0">
                <label for="price_max">VNĐ đến:</label>
                <input style="font-size: 16px;" type="number" name="price_max" id="price_max" placeholder="1000000"> VNĐ
            </div>
            
        </div>
        <br>
        <button style="margin-left: 20px;" type="submit" class="btn btn-primary">Tìm kiếm</button>
    </form>
</div>
</section>
<?php include('patials/footer.php'); ?>

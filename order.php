<?php include('partials-front/menu.php'); ?>

    <!-- Order Form -->
    <section class="food-search">
        <div class="container">
            
            

            <form action="#" class="order background-order">
                <br>
                <h2 class="text-center text-white">Nhập đầy đủ thông tin để đặt món</h2>
                <fieldset>
                    <legend>Món được chọn</legend>

                    <div class="food-menu-img">
                        <img src="images/pizza2.jpg" alt="Pizza" class="img-responsive img-curve">
                    </div>
    
                    <div class="food-menu-desc">
                        <h3>Food Title</h3>
                        <p class="food-price">25.000vnđ</p>

                        <div class="order-label">Số lượng</div>
                        <input type="number" name="qty" class="input-responsive" value="1" required>
                        
                    </div>

                </fieldset>
                
                <fieldset>
                    <legend>Thông tin khách hàng</legend>
                    <div class="order-label">Họ tên</div>
                    <input type="text" name="full-name" placeholder="Họ tên khách hàng" class="input-responsive" required>

                    <div class="order-label">Số điện thoại</div>
                    <input type="tel" name="contact" placeholder="0-xxx-xxx-xxx" class="input-responsive" required>

                    <div class="order-label">Email</div>
                    <input type="email" name="email" placeholder="email@gmail.com" class="input-responsive" required>

                    <div class="order-label">Địa chỉ</div>
                    <form>
                        <select class="select-address">
                            <?php
                                $username = $_SESSION['user'];

                                $sql = "SELECT a.ID AS address_ID, c.ID AS customer_ID, a.address AS find_address, a.phone AS address_phone FROM customer_address AS a JOIN customer AS c ON a.User_ID = c.ID WHERE c.username = '$username'";
                                $res = mysqli_query($conn, $sql);
        
                                if($res==TRUE){
                                    $i = 1;
                                    $count = mysqli_num_rows($res);
                                    if($count > 0){
                                        while($rows = mysqli_fetch_assoc($res)){
                                            $customerID = $rows['customer_ID'];
                                            $id = $rows['address_ID'];
                                            $address = $rows['find_address'];
                                            $phone = $rows['address_phone'];
                            ?>
                                            <option value=""><?php echo $address?></option>
                            <?php
                                        }
                                    }
                                }
                            ?>
                        </select>
                    </form>

                    <div class="order-label">Phương thức thanh toán</div>
                    <form action="">
                        <select class="select-address">
                            <option value="">Thanh toán khi nhận hàng</option>
                            <option value="">Thanh toán trực tuyến</option>
                        </select>
                    </form>

                    <input type="submit" name="submit" value="Đặt món" class="btn btn-primary">
                </fieldset>

            </form>

        </div>
    </section>

    <?php include('partials-front/footer.php'); ?>
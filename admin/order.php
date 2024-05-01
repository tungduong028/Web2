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
                    <textarea name="address" rows="10" placeholder="Địa chỉ khách hàng" class="input-responsive" required></textarea>

                    <input type="submit" name="submit" value="Đặt món" class="btn btn-primary">
                </fieldset>

            </form>

        </div>
    </section>

    <?php include('partials-front/footer.php'); ?>
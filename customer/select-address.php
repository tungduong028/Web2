<?php
include('patials/menu.php');
?>
<link rel="stylesheet" href="../css/cart.css">
<!-- Main content -->
<div class="main-content">
    <div class="wrapper">

    <?php

    // Kiểm tra người dùng đã đăng nhập chưa
    if(!isset($_SESSION['user'])) {
        $_SESSION['error'] = "Vui lòng đăng nhập trước khi chọn địa chỉ giao hàng.";
        header('location: login.php');
        exit;
    }

    // Lấy user_id từ session
    $username = $_SESSION['user'];

    $sql = "SELECT * FROM customer WHERE username = '$username'";
    $res = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($res);
    $user_id = $row['ID'];

    // Truy vấn để lấy danh sách địa chỉ của user
    $sql = "SELECT * FROM customer_address WHERE User_Id = '$user_id'";
    $result = mysqli_query($conn, $sql);

    // Truy vấn để lấy danh sách phương thức thanh toán
    $sql_payment = "SELECT * FROM payment_methods WHERE status = 1";
    $result_payment = mysqli_query($conn, $sql_payment);

    // Kiểm tra xem có địa chỉ nào tồn tại không
    if(mysqli_num_rows($result) > 0) {
        // Hiển thị danh sách địa chỉ giao hàng
        ?>
        <h2>Chọn địa chỉ giao hàng và phương thức thanh toán</h2>
        <form action="checkout.php" method="post">
            <div class="address-list">
                <?php while($row = mysqli_fetch_assoc($result)) { ?>
                    <div class="address-item">
                        <label>
                            <input type="radio" name="delivery_address" value="<?php echo $row['ID']; ?>" required>
                            Địa chỉ: <?php echo $row['address']; ?>  -  Số điện thoại: <?php echo $row['phone']; ?>
                        </label>
                    </div>
                <?php } ?>
            </div>
            <br>
            <div class="payment-method-list">
                <h3>Chọn phương thức thanh toán</h3>
                <?php while($row_payment = mysqli_fetch_assoc($result_payment)) { ?>
                    <div class="address-list">
                        <label>
                            <input type="radio" name="payment_method" value="<?php echo $row_payment['ID']; ?>" required>
                            <?php echo $row_payment['name_method']; ?>
                        </label>
                    </div>
                <?php } ?>
            </div>
            <input type="submit" name="confirm_address" class="btn btn-primary" style="margin-top: 10px;" value="Xác nhận">
        </form>
        <?php
    } else {
        // Nếu không có địa chỉ nào, hiển thị thông báo
        echo "Bạn chưa có địa chỉ giao hàng. Vui lòng thêm địa chỉ trước khi tiến hành thanh toán.";
    }
    ?>

    </div>
</div>

<?php include('patials/footer.php'); ?>

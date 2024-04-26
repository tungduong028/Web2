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

    // Kiểm tra xem có địa chỉ nào tồn tại không
    if(mysqli_num_rows($result) > 0) {
        // Hiển thị danh sách địa chỉ giao hàng
        ?>
        <h2>Chọn địa chỉ giao hàng</h2>
        <form action="checkout.php" method="post">
            <div class="address-list">
                <?php while($row = mysqli_fetch_assoc($result)) { ?>
                    <div class="address-item">
                        <label>
                            <input type="radio" name="delivery_address" value="<?php echo $row['ID']; ?>" required>
                            <?php echo $row['address']; ?>
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

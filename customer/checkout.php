<?php
// Kết nối CSDL
include('../admin/config/constants.php');

// Kiểm tra xem người dùng đã đăng nhập chưa
if(!isset($_SESSION['user'])) {
    // Nếu chưa đăng nhập, chuyển hướng người dùng đến trang đăng nhập
    $_SESSION['error'] = "Vui lòng đăng nhập trước khi thanh toán.";
    header('location: login.php');
    exit;
}

$delivery_address = $_POST['delivery_address'];
$payment_methods = $_POST['payment_method'];
// Kiểm tra giỏ hàng có sản phẩm hay không
if(isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    // Nhận thông tin người dùng từ session
    $username = $_SESSION['user'];

    $sql = "SELECT * FROM customer WHERE username = '$username'";
    $res = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($res);
    $user_id = $row['ID'];

    // Lấy tổng giá trị đơn hàng từ session
    $total_order = $_SESSION['total_order'];

    // Bắt đầu một giao dịch
    mysqli_autocommit($conn, false);
    $flag = true;

    // Thêm dữ liệu vào bảng "order_food"
    $order_date = date('Y-m-d H:i:s');
    $sql_order = "INSERT INTO `order_food` (order_date, customer_id, total_order, payment_methods, delivery_address) VALUES ('$order_date', '$user_id', '$total_order', '$payment_methods', '$delivery_address')";
    $result_order = mysqli_query($conn, $sql_order);

    if(!$result_order) {
        $flag = false;
    } else {
        // Lấy ID của đơn hàng vừa được thêm
        $order_id = mysqli_insert_id($conn);
    }

    // Lặp qua các mục trong giỏ hàng và thêm vào cơ sở dữ liệu
    foreach($_SESSION['cart'] as $food_id => $item) {
        $quantity = $item['quantity'];
        $food_price = $item['price'];
        $total = $food_price * $quantity;

        // Thêm đơn hàng vào bảng "cart"
        $sql_cart = "INSERT INTO cart (id, food_id, quantity, total) 
                     VALUES ('$order_id', '$food_id', '$quantity', '$total')";
        $result_cart = mysqli_query($conn, $sql_cart);

        if(!$result_cart) {
            $flag = false;
            break; // Thoát vòng lặp nếu có lỗi
        }
    }

    // Kiểm tra xem giao dịch đã thành công hay không
    if($flag) {
        mysqli_commit($conn);
        unset($_SESSION['cart']); // Xóa giỏ hàng sau khi thanh toán thành công
        unset($_SESSION['total_order']); // Xóa tổng giá trị đơn hàng sau khi thanh toán thành công
        $_SESSION['success'] = "Đơn hàng của bạn đã được đặt thành công.";
        header('location: bill-info.php?order_id=' . $order_id);
    } else {
        mysqli_rollback($conn);
        $_SESSION['error'] = "Đã xảy ra lỗi trong quá trình đặt hàng.";
        header('location: cart.php'); // Chuyển hướng người dùng đến trang giỏ hàng
    }

    // Đóng kết nối
    mysqli_close($conn);
} else {
    // Nếu giỏ hàng trống, chuyển hướng người dùng đến trang chính
    $_SESSION['error'] = "Giỏ hàng của bạn đang trống.";
    header('location: index.php');
    exit;
}
?>

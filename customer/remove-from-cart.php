<?php

// Kết nối CSDL
include('../admin/config/constants.php');

// Kiểm tra xem có tham số food_id được truyền qua URL không
if(isset($_GET['food_id']) && !empty($_GET['food_id'])) {
    // Lấy food_id từ URL
    $food_id = $_GET['food_id'];

    // Kiểm tra xem sản phẩm có tồn tại trong giỏ hàng không
    if(array_key_exists($food_id, $_SESSION['cart'])) {
        // Xóa sản phẩm khỏi giỏ hàng
        unset($_SESSION['cart'][$food_id]);
        // Hiển thị thông báo thành công
        $_SESSION['success'] = "Sản phẩm đã được xóa khỏi giỏ hàng.";
    } else {
        // Hiển thị thông báo lỗi nếu sản phẩm không tồn tại trong giỏ hàng
        $_SESSION['error'] = "Sản phẩm không tồn tại trong giỏ hàng.";
    }
} else {
    // Hiển thị thông báo lỗi nếu không có food_id được truyền qua URL
    $_SESSION['error'] = "Sản phẩm không tồn tại.";
}

// Chuyển hướng người dùng trở lại trang giỏ hàng
header('location: cart.php');
exit; // Dừng kịch bản sau khi chuyển hướng
?>

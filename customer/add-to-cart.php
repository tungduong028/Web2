<?php
session_start();

// Kết nối CSDL
include('config/constants.php');

// Kiểm tra xem form đã được gửi chưa
if(isset($_POST['add_to_cart'])) {
    // Nhận thông tin sản phẩm từ form
    $food_id = isset($_POST['food_id']) ? $_POST['food_id'] : null;
    $food_title = isset($_POST['food_title']) ? $_POST['food_title'] : null;
    $food_price = isset($_POST['food_price']) ? $_POST['food_price'] : null;
    $quantity = isset($_POST['quantity']) ? $_POST['quantity'] : 1;

    // Kiểm tra xem các biến POST có giá trị hợp lệ không
    if ($food_id && $food_title && $food_price && is_numeric($quantity)) {
        // Kiểm tra xem giỏ hàng đã được khởi tạo chưa
        if(!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = array();
        }

        // Kiểm tra xem sản phẩm đã tồn tại trong giỏ hàng chưa
        if(array_key_exists($food_id, $_SESSION['cart'])) {
            // Nếu đã tồn tại, tăng số lượng lên
            $_SESSION['cart'][$food_id]['quantity'] += $quantity;
        } else {
            // Nếu chưa tồn tại, thêm sản phẩm mới vào giỏ hàng
            $_SESSION['cart'][$food_id] = array(
                'title' => $food_title,
                'price' => $food_price,
                'quantity' => $quantity
            );
        }

        // Hiển thị thông báo thành công
        $_SESSION['success'] = "Sản phẩm đã được thêm vào giỏ hàng.";
    } else {
        // Hiển thị thông báo lỗi nếu có
        $_SESSION['error'] = "Có lỗi xảy ra khi thêm sản phẩm vào giỏ hàng.";
    }
    
    // Chuyển hướng người dùng trở lại trang trước đó
    header('location: ' . $_SERVER['HTTP_REFERER']);
    exit; // Dừng kịch bản sau khi chuyển hướng
} else {
    // Nếu form không được gửi, chuyển hướng về trang chính
    header('location: ' . SITEURL);
    exit; // Dừng kịch bản sau khi chuyển hướng
}
?>

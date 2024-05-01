<?php
include('../admin/config/constants.php');

// Kiểm tra xem ID và status được truyền qua URL hay không
if(isset($_GET['ID']) && isset($_GET['status'])) {
    // Lấy giá trị của ID và status từ URL
    $ID = $_GET['ID'];
    //$status = ($_GET['status'] == 0) ? 1 : 0;;
    if ($_GET['status'] == 0) {
        $status =1;
    }
    else {
        $status = 0;
    }

    // Update trạng thái của khách hàng trong cơ sở dữ liệu
    $sql = "UPDATE order_food SET status = '$status' WHERE ID = '$ID'"; 
    $res = mysqli_query($conn, $sql);

    // Kiểm tra xem truy vấn thực thi thành công hay không
    if($res == true)
    {
        // Trạng thái của khách hàng được cập nhật thành công
        $_SESSION['update_status_order'] = "<div class='success'> Status order Updated Successfully.</div>";
        header('location:'.SITEURL.'admin/manage-order.php');
        die();
    }
    else
    {
        // Cập nhật trạng thái của khách hàng thất bại
        $_SESSION['update_status_order'] = "<div class='error'>Failed to Update Status order.</div>";
        header('location:'.SITEURL.'admin/admin/manage-order.php');
        die();

    }
}
else
{
    // Nếu không có ID hoặc status được truyền qua URL
    $_SESSION['update_status_order'] = "<div class='error'>ID or Status Not Set.</div>";
    header('location:'.SITEURL.'admin/admin/manage-order.php');
    die();


}

// Redirect về trang quản lý khách hàng
?>

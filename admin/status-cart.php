<?php
include('../admin/config/constants.php');

// Kiểm tra xem ID và status được truyền qua URL hay không
if(isset($_GET['ID']) && isset($_GET['Status'])) {
    // Lấy giá trị của ID và status từ URL
    $ID = $_GET['ID'];
    //$status = ($_GET['status'] == 0) ? 1 : 0;;
    if ($_GET['Status'] == 0) {
        $Status = 1;
    }
    else {
        $Status = 0;
    }

    // Update trạng thái của khách hàng trong cơ sở dữ liệu
    $sql = "UPDATE cart SET Status = '$Status' WHERE ID = '$ID'"; 
    $res = mysqli_query($conn, $sql);
    if (!$res) {
        echo "Error: ".mysqli_error($conn);
        die();
    }

    // Kiểm tra xem truy vấn thực thi thành công hay không
    if($res == true)
    {
        // Trạng thái của khách hàng được cập nhật thành công
        $_SESSION['update_status_cart'] = "<div class='success'> Status cart Updated Successfully.</div>";
        header('location:'.SITEURL.'admin/manage-order.php');
        die();

    }
    else
    {
        // Cập nhật trạng thái của khách hàng thất bại
        $_SESSION['update_status_cart'] = "<div class='error'>Failed to Update Status cart.</div>";
        header('location:'.SITEURL.'admin/manage-order.php');
        die();

    }
}
else
{
    // Nếu không có ID hoặc status được truyền qua URL
    $_SESSION['update_status_cart'] = "<div class='error'>ID or Status Not Set.</div>";
    header('location:'.SITEURL.'admin/manage-order.php');
    die();

}

// Redirect về trang quản lý khách hàng
?>

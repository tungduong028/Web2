<?php
include('patials/menu.php');

// Kiểm tra xem người dùng đã đăng nhập chưa
if(!isset($_SESSION['user'])) {
    // Nếu chưa đăng nhập, chuyển hướng người dùng đến trang đăng nhập
    $_SESSION['error'] = "Vui lòng đăng nhập trước khi xem hóa đơn.";
    header('location: login.php');
    exit;
}

// Lấy order_id từ URL
$order_id = $_GET['order_id'];

// Truy vấn thông tin đơn hàng
$sql_order = "SELECT * FROM order_food WHERE id = '$order_id'";
$res_order = mysqli_query($conn, $sql_order);
$order = mysqli_fetch_assoc($res_order);

// Truy vấn thông tin các mặt hàng trong đơn hàng
$sql_cart = "SELECT food.name, price AS price, total AS total, quantity AS quantity FROM cart 
            JOIN food ON cart.Food_ID = food.id 
            WHERE cart.ID = '$order_id'";
$res_cart = mysqli_query($conn, $sql_cart);
?>

<div class="main-content">
    <div class="wrapper">
        <h1>Thông tin hóa đơn</h1>
        <p><strong>Mã đơn hàng:</strong> <?php echo $order['id']; ?></p>
        <p><strong>Ngày đặt hàng:</strong> <?php echo $order['order_date']; ?></p>
        <p><strong>Tổng giá trị đơn hàng:</strong> <?php echo number_format($order['total_order'], 0, ",", "."); ?> VNĐ</p>
        <p><strong>Địa chỉ giao hàng:</strong> <?php 
            $sql_address = "SELECT * FROM customer_address WHERE ID = '{$order['delivery_address']}'";
            $res_address = mysqli_query($conn, $sql_address);
            $address = mysqli_fetch_assoc($res_address);
            echo $address['address'] . " - " . $address['phone'];
        ?></p>
        <p><strong>Phương thức thanh toán:</strong> <?php 
            $sql_payment = "SELECT * FROM payment_methods WHERE id = '{$order['payment_methods']}'";
            $res_payment = mysqli_query($conn, $sql_payment);
            $payment = mysqli_fetch_assoc($res_payment);
            echo $payment['name_method'];
        ?></p>
        
        <h2>Chi tiết đơn hàng</h2>
        <table class="table-full">
            <tr>
                <th>Sản phẩm</th>
                <th>Giá</th>
                <th>Số lượng</th>
                <th>Thành tiền</th>
            </tr>
            <?php while($row = mysqli_fetch_assoc($res_cart)) { ?>
            <tr>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo number_format($row['price'], 0, ",", "."); ?> VNĐ</td>
                <td><?php echo $row['quantity']; ?></td>
                <td><?php echo number_format($row['total'], 0, ",", "."); ?> VNĐ</td>
            </tr>
            <?php } ?>
        </table>
    </div>
</div>

<?php include('patials/footer.php'); ?>

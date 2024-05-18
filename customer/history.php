<?php
include('patials/menu.php');
?>

<!-- Main content -->
<div class="main-content">
    <div class="wrapper">
        <h1 style="margin: 10px;">Lịch sử mua hàng</h1>

        <table class="table-full">
            <tr>
                <th>ID</th>
                <th>Ngày mua</th>
                <th>Tổng cộng</th>
                <th>Phương thức thanh toán</th>
                <th>Địa chỉ giao hàng</th>
                <th>Trạng thái</th>
                <th>Vận chuyển</th>
            </tr>

            <?php

            $username = $_SESSION['user'];

            $sql_user = "SELECT ID FROM customer WHERE username = '$username'";
            $res_user = mysqli_query($conn, $sql_user);

            if ($res_user == true) {
                $row_user = mysqli_fetch_assoc($res_user);
                $user_id = $row_user['ID'];

                $sql = "
                    SELECT o.id, o.order_date, o.total_order, pm.name_method, ca.address, ca.phone, o.status , o.status2
                    FROM order_food o
                    JOIN payment_methods pm ON o.payment_methods = pm.ID
                    JOIN customer_address ca ON o.delivery_address = ca.ID
                    WHERE o.Customer_ID = '$user_id'
                    ORDER BY o.order_date DESC
                ";

                $res = mysqli_query($conn, $sql);

                if ($res == true) {
                    $count = mysqli_num_rows($res);

                    if ($count > 0) {
                        while ($row = mysqli_fetch_assoc($res)) {
                            $id = $row['id'];
                            $order_date = $row['order_date'];
                            $total_order = $row['total_order'];
                            $name_method = $row['name_method'];
                            $delivery_address = $row['address'] . ', ' . $row['phone'];
                            $status = $row['status'] == 1 ? 'Đã xác nhận' : 'Hủy đơn';
                            $status2 = $row['status2'] == 1 ? 'Đã giao hàng' : 'Đang vận chuyển';
                            ?>
                            <tr>
                                <td><?php echo $id; ?></td>
                                <td><?php echo $order_date; ?></td>
                                <td><?php echo $total_order; ?> VNĐ</td>
                                <td><?php echo $name_method; ?></td>
                                <td><?php echo $delivery_address; ?></td>
                                <td><?php echo $status; ?></td>
                                <td><?php echo $status2; ?></td>
                            </tr>
                            <?php
                        }
                    } else {
                        echo "<tr><td colspan='6' class='error'>Không có lịch sử mua hàng.</td></tr>";
                    }
                } else {
                    echo "<tr><td colspan='6' class='error'>Không thể lấy dữ liệu từ cơ sở dữ liệu.</td></tr>";
                }
            } else {
                echo "<tr><td colspan='6' class='error'>Không thể lấy thông tin người dùng từ cơ sở dữ liệu.</td></tr>";
            }
            ?>
        </table>
    </div>
</div>
<br>
<br>

<?php include('patials/footer.php'); ?>

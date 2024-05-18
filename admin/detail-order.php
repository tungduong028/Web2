<?php
    include('patials/menu.php');

    // Nhận ID đơn hàng từ URL
    $order_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

    // Truy vấn lấy thông tin đơn hàng
    $order_sql = " SELECT 
    o.id as OrderID, o.order_date, o.total_order,
    c.username, c.phone, 
    ca.address as DeliveryAddress,
    ci.Quantity, ci.Total as ItemTotal,
    f.name as FoodName, f.price as PricePerItem, f.image,
    p.name_method as payment
FROM 
    order_food o
JOIN 
    cart ci ON o.id = ci.ID
JOIN 
    customer c ON o.Customer_ID = c.ID
JOIN 
    customer_address ca ON o.delivery_address = ca.ID
JOIN 
    food f ON ci.Food_ID = f.id
JOIN 
    payment_methods p ON o.payment_methods = p.ID
WHERE 
    o.id = $order_id;
 ";
    $result = $conn->query($order_sql);
    $data = $result->fetch_assoc();

    // Truy vấn lấy các mục trong giỏ hàng của đơn hàng
    $cart_sql = "SELECT 
      ci.*, f.name as food_name, 
      f.image as food_image, f.price as food_price 
    FROM cart ci 
    JOIN food f ON ci.Food_ID = f.id WHERE ci.ID = $order_id";
    $cart_result = $conn->query($cart_sql);
    

?>
<div class="main-content">
    <div class="wrapper">
    <h1>Chi Tiết Đơn Hàng</h1>
    <br><br>
    <h2>Khách Hàng: <?php echo ($data['username']); ?></h2>
    <br>
    <h3>Ngày mua hàng: <?php echo $data['order_date']; ?></h3>
    <br>
    <h3>Địa chỉ giao hàng: <?php echo $data['DeliveryAddress']; ?></h3>
    <br>
    <h3>Phương thức thanh toán: <?php echo $data['payment']; ?></h3>
    <br>
    <h3>Tổng tiền: <?php echo ($data['total_order']); ?>₫</h3>
    <br>

    <table class="table-full">
        <tr>
            <th>Sản phẩm</th>
            <th>Hình ảnh</th>
            <th>Số lượng</th>
            <th>Giá</th>
            <th>Đơn giá</th>
        </tr>
        <?php while ($data1 = $cart_result->fetch_array()) { ?>
        <tr>
            <td><?php echo htmlspecialchars($data1['food_name']); ?></td>
            <td><img src="<?php echo SITEURL; ?>/images/food/<?php echo htmlspecialchars($data1['food_image']); ?>" style="width:90px;"></td>
            <td><?php echo htmlspecialchars($data1['Quantity']); ?></td>
            <td><?php echo number_format($data1['food_price']); ?>₫</td>
            <td><?php echo number_format($data1['Total']); ?>₫</td>
        </tr>
        <?php } ?>
    </table>

<?php $conn->close(); ?>
    </div>
</div>

<?php include('patials/footer.php'); ?>
   
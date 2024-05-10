<?php
// Kết nối cơ sở dữ liệu
include('patials/menu.php');
// Xử lý khi người dùng gửi biểu mẫu
if (isset($_POST['submit'])) {
    $from_date = $_POST['from_date'];
    $to_date = $_POST['to_date'];

    // Câu truy vấn lấy 5 khách hàng mua nhiều nhất
    $sql = "SELECT User_ID, SUM(Total) as TotalSpent
            FROM cart
            WHERE ID IN (
                SELECT id_cart
                FROM order_food
                WHERE order_date BETWEEN '$from_date' AND '$to_date'
            )
            GROUP BY User_ID
            ORDER BY TotalSpent DESC
            LIMIT 5";

    $result = $conn->query($sql);
    // Tiếp tục xử lý kết quả truy vấn...
}
?>


    <h1>Thống kê đơn hàng</h1>

    <!-- Biểu mẫu để nhập khoảng thời gian thống kê -->
    <form action="" method="POST">
        <label for="from_date">Từ ngày:</label>
        <input type="date" id="from_date" name="from_date" required>

        <label for="to_date">Đến ngày:</label>
        <input type="date" id="to_date" name="to_date" required>

        <input type="submit" name="submit" value="Thống kê">
    </form>

    <!-- Bảng hiển thị kết quả thống kê -->
        <table class="table-full">
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>Tổng Chi Tiêu</th>
                    <th>Chi Tiết</th>
                </tr>
            </thead>
            <tbody>
                <?php if (isset($result) && $result->num_rows > 0): 

                 while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['User_ID']); ?></td>
                        <td><?= htmlspecialchars($row['TotalSpent']); ?></td>
                        <td><a href="<?php echo SITEURL;?>details.php?UserID=<?php $row['User_ID']; ?>">Xem chi tiết</a></td>
                    </tr>
                 <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                    <td cospan=3; class="error">Not found data </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        

<?php include('patials/footer.php'); ?>

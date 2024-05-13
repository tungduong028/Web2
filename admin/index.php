<?php
include('patials/menu.php');

$customerCount = 0;
$totalRevenue = 0;
$topCustomers = [];
$chartData = [];
$time_period = isset($_POST['time_period']) ? $_POST['time_period'] : 7; // Mặc định là 7 ngày
$endDate = date('Y-m-d'); // Ngày hiện tại
$startDate = date('Y-m-d', strtotime("-$time_period days"));

// Truy vấn để lấy top 5 khách hàng
$sql = "SELECT 
            customer.name, SUM(order_food.total_order) AS total_spent
        FROM customer
        JOIN cart ON customer.ID = cart.User_ID
        JOIN order_food ON cart.ID = order_food.ID
        WHERE order_food.order_date BETWEEN '$startDate' AND '$endDate'
        GROUP BY customer.ID
        ORDER BY total_spent DESC
        LIMIT 5;";
$result = $conn->query($sql);

// Truy vấn để lấy dữ liệu biểu đồ
$chartSql = "SELECT DATE_FORMAT(order_date, '%U') AS week_number, SUM(total_order) AS weekly_total 
             FROM order_food 
             WHERE order_date BETWEEN '$startDate' AND '$endDate' 
             GROUP BY week_number 
             ORDER BY week_number";
$chartResult = $conn->query($chartSql);
while ($row = $chartResult->fetch_assoc()) {
    $chartData[] = $row['weekly_total'];
}

$conn->close();
?>

<div class="main-content">
    <div class="wrapper">
        <h1>Dashboard</h1>
        <br>
        <?php
            if(isset($_SESSION['login'])) {
                echo $_SESSION['login'];
                unset($_SESSION['login']);
            }
        ?>

        <!-- Form lựa chọn khoảng thời gian -->
        <form action="" method="post">
            <select name="time_period">
                <option value="1" <?php if ($time_period == 1) echo 'selected'; ?>>Hôm nay</option>
                <option value="7" <?php if ($time_period == 7) echo 'selected'; ?>>7 ngày gần nhất</option>
                <option value="30" <?php if ($time_period == 30) echo 'selected'; ?>>30 ngày gần nhất</option>
                <option value="90" <?php if ($time_period == 90) echo 'selected'; ?>>90 ngày gần nhất</option>
                <option value="180" <?php if ($time_period == 180) echo 'selected'; ?>>180 ngày gần nhất</option>

            </select>
            <input type="submit" value="Thống kê">
        </form>

        <!-- Hiển thị top 5 khách hàng -->
        <div class="col-4 text-center">
            <h1>Top 5 Customers</h1>
            <br />
            <?php
                if ($result->num_rows > 0) {
                    echo "<table border='1'><tr><th>Customer Name</th><th>Total Spent</th></tr>";
                    while($row = $result->fetch_assoc()) {
                        echo "<tr><td>" . $row["name"] . "</td><td>" . number_format($row["total_spent"]) . "</td></tr>";
                    }
                    echo "</table>";
                } else {
                    echo "No results found";
                }
            ?>
        </div>

        <!-- Hiển thị biểu đồ bán hàng -->
        <div class="col-8 text-center">
            <canvas id="salesChart" width="400" height="400"></canvas>
        </div>

        <div class="clearfix"></div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var ctx = document.getElementById('salesChart').getContext('2d');
    var salesChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode(array_keys($chartData)); ?>,
            datasets: [{
                label: 'Weekly Sales',
                data: <?php echo json_encode(array_values($chartData)); ?>,
                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

<?php include('patials/footer.php'); ?>


<?php
include('patials/menu.php');

$customerCount = 0;
$totalRevenue = 0;
$topCustomers = [];
$chartData = [];
//set time
$time_period = isset($_POST['time_period']) ? $_POST['time_period'] : 7; // Mặc định là 7 ngày
$endDate = date('Y-m-d'); // Ngày hiện tại
$startDate = date('Y-m-d', strtotime("-$time_period days"));
//set food
$num_food = isset($_POST['num_food']) ? $_POST['num_food'] : 10; // Mặc định là top 10
$time_period_food = isset($_POST['time_period_food']) ? $_POST['time_period_food'] : 7; // Mặc định là 7 ngày
$endDate_food = date('Y-m-d'); // Ngày hiện tại
$startDate_food = date('Y-m-d', strtotime("-$time_period_food days"));
// Truy vấn để lấy top 5 khách hàng
$sql = "SELECT 
            customer.name, customer.username,
            SUM(order_food.total_order) AS total_spent
            FROM customer
            JOIN order_food ON customer.ID = order_food.customer_id
            WHERE order_food.order_date BETWEEN '$startDate' AND '$endDate'
            AND order_food.status = 1
            GROUP BY customer.ID
            ORDER BY total_spent DESC
            LIMIT 5;";
$result = $conn->query($sql);
//truy vấn sản phẩm bán chạy nhất
// $sql_food = "SELECT 
//             food.name as fname, food.image as fimg,
//             SUM(cart.Quantity) AS qua_food
            
//         FROM cart
//         JOIN food ON cart.Food_ID  = food.id
//         JOIN order_food ON cart.ID  = order_food.ID
//         WHERE order_food.order_date BETWEEN '$startDate_food' AND '$endDate_food'
//         AND order_food.status = 1
//         GROUP BY cart.ID
//         ORDER BY qua_food DESC
//         LIMIT $num_food;";
// $result_food = $conn->query($sql_food);

//////////////////

$sql_food = "SELECT 
            f.name AS fname,
            f.image AS fimg,
            SUM(c.Quantity) AS qua_food,
            MAX(o.order_date) AS nday
        FROM 
            food AS f
        JOIN 
            cart AS c ON f.id = c.Food_ID
        JOIN 
            order_food AS o ON c.ID = o.ID
        WHERE o.order_date BETWEEN '$startDate_food' AND '$endDate_food' AND o.status = 1 
        GROUP BY f.id, f.name, f.image
        ORDER BY qua_food DESC
        LIMIT $num_food; ";
$result_food = $conn->query($sql_food);


/////////////////
// Truy vấn để lấy dữ liệu biểu đồ
$chartSql = "SELECT DATE_FORMAT(order_date, '%U') AS week_number, SUM(total_order) AS weekly_total 
             FROM order_food 
             WHERE order_date BETWEEN '$startDate' AND '$endDate' 
             AND status = 1
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

        

        <!-- Hiển thị top 5 khách hàng -->
        <div class="col-dashboard text-center">
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
            <h1>Top 5 Customers</h1>
            <br />
        
            <?php
                if ($result->num_rows > 0) {
                    echo "<table border='1' width='400px'>
                    <tr>
                     <th>Customer Name</th>
                     <th>Total Spent</th>
                    </tr>";
                    while($row = $result->fetch_assoc()) {
                        echo "<tr><td>" . $row["name"] ."( ".$row["username"]." )". "</td><td>" . ($row["total_spent"]) . "</td></tr>";
                    }
                    echo "</table>";
                } else {
                    echo "No results found";
                }
            ?>
        <!-- Hiển thị biểu đồ bán hàng -->
        <div class="col-8 text-center">
                    <canvas id="salesChart" width="400" height="400"></canvas>
        </div>

                <div class="clearfix"></div>
                <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            var ctx = document.getElementById('salesChart').getContext('2d');
            var salesChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: <?php echo json_encode(array_keys($chartData)); ?>,
                    datasets: [{
                        label: 'Buys',
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
        </div>

        
        

        <!-- Hiển thị top foodd -->
        <div class="col-dashboard text-center">
        <!-- Form lựa chọn khoảng thời gian xếp hạng food-->
        <form action="" method="post">
                <select name="num_food">
                    <option value="5" <?php if ($num_food == 5) echo 'selected'; ?>>top 5</option>
                    <option value="10" <?php if ($num_food == 10) echo 'selected'; ?>>top 10</option>
                    <option value="30" <?php if ($num_food == 30) echo 'selected'; ?>>top 30</option>
                </select>
                <select name="time_period_food">
                    <option value="1" <?php if ($time_period_food == 1) echo 'selected'; ?>>Hôm nay</option>
                    <option value="7" <?php if ($time_period_food == 7) echo 'selected'; ?>>7 ngày gần nhất</option>
                    <option value="30" <?php if ($time_period_food == 30) echo 'selected'; ?>>30 ngày gần nhất</option>
                    <option value="90" <?php if ($time_period_food == 90) echo 'selected'; ?>>90 ngày gần nhất</option>
                </select>
        <input type="submit" value="Thống kê">
        </form>
            <h1>Top <?php echo  $num_food; ?> favorite products </h1>
            <br />
            <?php
                if ($result_food->num_rows > 0) {
                    echo "<table border='1' width='400px'>
                    <tr>
                     <th>Food Name</th>
                     <th>Image</th>
                     <th>Total product</th>
                    </tr>";
                    while($row_food = $result_food->fetch_assoc()) {
                        echo "<tr>
                               <td>" .$row_food["fname"]. "</td>
                               <td>
                               <img src='".SITEURL."/images/category/" . $row_food["fimg"] . "' width='100px'>
                               </td>
                               <td>" .($row_food["qua_food"]). "</td>
                              </tr>";
                    }
                    echo "</table>";
                } else {
                    echo "No results found";
                }
            ?>
        </div>
        <div class="clearfix"></div>
    </div>
</div>

<?php include('patials/footer.php'); ?>

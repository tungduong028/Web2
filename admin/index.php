<?php include('patials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Dashboard</h1>
        <br>
        <?php
            if(isset($_SESSION['login'])) {
                echo $_SESSION['login'];
                unset($_SESSION['login']);
            }

            // Truy vấn để lấy top 5 khách hàng
            $sql = "SELECT customer.name, SUM(order_food.total_order) AS total_spent
                    FROM customer
                    JOIN order_food ON customer.ID = cart.User_ID
                    WHERE order_food.order_date BETWEEN '2022-01-01' AND '2022-12-31'
                    GROUP BY customer.ID
                    ORDER BY total_spent DESC
                    LIMIT 5";

            $result = $conn->query($sql);

            // Truy vấn để lấy dữ liệu biểu đồ
            $chartData = [];
            $weeks = ["Week 1", "Week 2", "Week 3", "Week 4"];
            foreach ($weeks as $week) {
                $weekNum = explode(' ', $week)[1];
                $chartSql = "SELECT SUM(total_order) AS weekly_total FROM order_food WHERE WEEK(order_date) = $weekNum";
                $chartResult = $conn->query($chartSql);
                $row = $chartResult->fetch_assoc();
                $chartData[] = $row['weekly_total'] ?: 0;
            }
        ?>
        
        <!-- Displaying the top 5 customers -->
        <div class="col-4 text-center">
            <h1>Top 5 Customers</h1>
            <br />
            <?php
                if ($result->num_rows > 0) {
                    echo "<table><tr><th>Customer Name</th><th>Total Spent</th></tr>";
                    while($row = $result->fetch_assoc()) {
                        echo "<tr><td>" . $row["name"] . "</td><td>" . $row["total_spent"] . "</td></tr>";
                    }
                    echo "</table>";
                } else {
                    echo "No results found";
                }
            ?>
        </div>

        <!-- Displaying the sales chart -->
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
            labels: <?php echo json_encode($weeks); ?>,
            datasets: [{
                label: 'Weekly Sales',
                data: <?php echo json_encode($chartData); ?>,
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

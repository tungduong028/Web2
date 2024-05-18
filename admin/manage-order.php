<?php include('patials/menu.php'); ?>

    <!-- Main content -->
    <div class="main-content">
        <div class="wrapper">
            <h1>Manage Order</h1>
            <br /><br />
            <?php 
                    if(isset($_SESSION['update_status_order']))
                    {
                        echo $_SESSION['update_status_order'];
                        unset($_SESSION['update_status_order']);
                    }
                    if(isset($_SESSION['update_status_cart']))
                    {
                        echo $_SESSION['update_status_cart'];
                        unset($_SESSION['update_status_cart']);
                    }
                $sql_customer = "SELECT * FROM customer ";
                $res_customer = $conn->query($sql_customer);
            ?>        
            <!-- filter screent of order -->
            <form action="" method="POST">
                <label for="customer">customer: </label>
                <select name="customer">
                    <option value="all">Tất cả</option>
                    <?php while ($row = mysqli_fetch_assoc($res_customer)) { ?>
                    <option value="<?php echo $row['name']; ?>"><?php echo $row['name']; ?></option>
                    <?php } ?>
                </select>
                <label for="status">Status: </label>
                <select name="status">
                    <option value="all">Tất cả</option>
                    <option value="sucess">Thành công</option>
                    <option value="fail">Hủy đơn</option>
                </select>
                
                <label for="from_date">From: </label>
                <input type="date" name="from_date">
                <label for="to_date">To: </label>
                <input type="date" name="to_date">
                <br/><br/>
                <label for="adress">Address:</label>
                <input type="text" name="delivery_location" placeholder="Enter delivery location">
                <br/><br/>
                <input type="submit" name="filter" value="Filter Orders">
            </form>
            <br /><br />

            <!-- table screent of order -->

            <table class="table-full">
                <tr>
                    <th>STT</th>
                    <th>ID_Order</th>
                    <th>Date </th>
                    <th>Total</th>
                    <th>Transports</th>
                    <th>Status </th>
                    <th>Details </th>
                </tr>

                <?php

                if(isset($_POST['filter'])) {
                  // Xây dựng điều kiện WHERE dựa trên đầu vào của người dùng
                  $whereConditions = [];
                  if ($_POST['customer'] !='' && $_POST['customer'] != 'all') {
                    $customer = $conn->real_escape_string($_POST['customer']);
                    $whereConditions[] = "LOWER(customer.name) REGEXP '$customer'";
                  }
                  if($_POST['status'] != '' && $_POST['status'] != 'all') {
                      $status = $conn->real_escape_string($_POST['status']);
                      if ($status == 'sucess') {
                        $status = 1;
                      }
                      else {
                        $status = 0;
                      }
                      $whereConditions[] = "order_food.status = '$status'";
                  }
                  
                  if($_POST['from_date'] != '') {
                      $from_date = $conn->real_escape_string($_POST['from_date']);
                      $whereConditions[] = "order_food.order_date >= '$from_date'";
                  }
                  if($_POST['to_date'] != '') {
                      $to_date = $conn->real_escape_string($_POST['to_date']);
                      $to_date = date('Y-m-d', strtotime($to_date . ' +1 day'));  // Thêm 1 ngày vào to_date
                      $whereConditions[] = "order_food.order_date <= '$to_date'";
                  }
                  if($_POST['delivery_location'] != '') {
                      $delivery_location = $conn->real_escape_string($_POST['delivery_location']);
                      $delivery_location = strtolower($delivery_location);  // Chuyển đầu vào thành chữ thường
                      $whereConditions[] = "LOWER(customer_address.address) REGEXP '$delivery_location'";  // Sử dụng LOWER để so sánh không phân biệt chữ hoa chữ thường
                  }

                  // Tạo câu truy vấn với các điều kiện WHERE
                  $whereClause = implode(' AND ', $whereConditions);
                  if($whereClause != '') {
                      $whereClause = 'WHERE ' . $whereClause;
                  }

                  // $sql = "SELECT cart.ID as cartid, cart.Status as CartStatus, order_food.id as orderid, order_food.order_date, order_food.status as OrderStatus FROM cart INNER JOIN order_food ON cart.ID = order_food.id_cart $whereClause";
                  $sql = "SELECT 
                  order_food.id AS orderid, 
                  order_food.order_date, 
                  order_food.total_order, 
                  order_food.status AS ostatus, 
                  order_food.status2 AS transtatus, 
                  customer.name AS customer_name, 
                  customer_address.address AS delivery_address 
                  FROM order_food 
                  INNER JOIN customer ON order_food.Customer_ID = customer.ID 
                  INNER JOIN customer_address ON order_food.delivery_address = customer_address.ID
                  $whereClause ";
                  // Thực hiện truy vấn và hiển thị kết quả
                  //..............................................
                  $result = $conn->query($sql);
                $count = 1;
                
                if ($result->num_rows > 0) {
                  $id_sp = [];
                    while($row = $result->fetch_assoc()) {
                      $id_current = $row['orderid'];
                      if ($id_current != $id_sp) {

                        echo "<tr>";
                        echo "<td>".$count++."</td>";
                        echo "<td>".$row["orderid"]."</td>";
                        echo "<td>".$row["order_date"]."</td>";
                        echo "<td>".$row["total_order"].".vnd"."</td>";
                      
                      //status cart
                        echo "<td>";
                          if ( $row["transtatus"] == 1) {
                            $tran_active = "btn-update";
                            $active1 = "Đã giao hàng";

                          }
                          else {
                            $tran_active = "btn-delete";
                            $active1 = "Đang vận chuyển";
                          }
                          echo "<a href='" . SITEURL . "admin/status-cart.php?ID=".$row["orderid"]."&status=".$row["transtatus"]."' class='$tran_active'>$active1</a>";
                        echo  "</td>";
                       
                        // status order
                        echo "<td>";
                            
                            if ($row["ostatus"] == 1) {
                              $order_active = "btn-update";
                              $active2 = "Đã xác nhận";

                            }
                            else {
                              $order_active = "btn-delete";
                              $active2 = "Huỷ đơn";
                            }
                            echo "<a href='" . SITEURL . "admin/status-order.php?ID=".$row["orderid"]."&status=".$row["ostatus"]."' class='$order_active'>$active2</a>";
                        echo "</td>";

                        //details
                        echo "<td>
                                <a href='". SITEURL. "admin/detail-order.php?id=".$row["orderid"]."' class='btn-update'>View Details</a>
                              </td>";

                        

                        echo "</tr>";
                      }
                      $id_sp = $id_current;
                      
                    }
                } else {
                    echo "<tr><td colspan='6'><div class='error'>No Orders Available</div></td></tr>";
                }
                $conn->close();  
                // ......................................................................
                }
                else {
                $sql = "SELECT * FROM order_food";
                $result = $conn->query($sql);
                $count = 1;
                if ($result->num_rows > 0) {
                  $id_sp = [];
                    while($row = $result->fetch_assoc()) {
                      $id_current = $row['id'];
                      if ($id_current != $id_sp) {

                        echo "<tr>";
                        echo "<td>".$count++."</td>";
                        echo "<td>".$row["id"]."</td>";
                        echo "<td>".$row["order_date"]."</td>";
                        echo "<td>".$row["total_order"].".vnd"."</td>";

                      //status cart
                        echo "<td>";
                          if ( $row["status2"] == 1) {
                            $cart_active = "btn-update";
                            $active1 = "Đã giao hàng";

                          }
                          else {
                            $cart_active = "btn-delete";
                            $active1 = "Đang vận chuyển";
                          }
                          echo "<a href='" . SITEURL . "admin/status-cart.php?ID=".$row["id"]."&status=".$row["status2"]."' class='$cart_active'>$active1</a>";
                        echo  "</td>";
                       
                        // status order
                        echo "<td>";
                            
                            if ($row["status"] == 1) {
                              $order_active = "btn-update";
                              $active2 = "Đã xác nhận";

                            }
                            else {
                              $order_active = "btn-delete";
                              $active2 = "Huỷ đơn";
                            }
                            echo "<a href='" . SITEURL . "admin/status-order.php?ID=".$row["id"]."&status=".$row["status"]."' class='$order_active'>$active2</a>";
                        echo "</td>";

                        //details
                        echo "<td>
                                <a href='". SITEURL. "admin/detail-order.php?id=".$row["id"]."' class='btn-update'>View Details</a>
                              </td>";

                        

                        echo "</tr>";
                      }
                      $id_sp = $id_current;
                    }
                } else {
                    echo "<tr><td colspan='6'><div class='error'>No Orders Available</div></td></tr>";
                }
                $conn->close();  
                }
                
                
                ?>
            </table>

        </div>
    </div>

<?php include('patials/footer.php'); ?>

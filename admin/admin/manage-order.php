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
            ?>        
            <!-- filter screent of order -->
            <form action="" method="POST">
                <select name="status">
                    
                    <option value="Ordered">Ordered</option>
                    <option value="On Delivery">On Delivery</option>
                    <option value="Delivered">Delivered</option>
                    <option value="Cancelled">Cancelled</option>
                </select>
                <label for="from_date">Status: </label>
                <select name="status">
                    <option value="all">Tất cả</option>
                    <option value="sucess">Thành công</option>
                    <option value="fail">Hủy đơn</option>
                </select>
                <br/><br/>
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
                    <th>Actions</th>
                    <th>Status </th>
                    <th>Details </th>
                </tr>

                <?php

                if(isset($_POST['filter'])) {
                  // Xây dựng điều kiện WHERE dựa trên đầu vào của người dùng
                  $whereConditions = [];
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
                      $whereConditions[] = "customer_address.address LIKE '%$delivery_location%'";
                  }

                  // Tạo câu truy vấn với các điều kiện WHERE
                  $whereClause = implode(' AND ', $whereConditions);
                  if($whereClause != '') {
                      $whereClause = 'WHERE ' . $whereClause;
                  }

                  // $sql = "SELECT cart.ID as cartid, cart.Status as CartStatus, order_food.id as orderid, order_food.order_date, order_food.status as OrderStatus FROM cart INNER JOIN order_food ON cart.ID = order_food.id_cart $whereClause";
                  $sql = "SELECT cart.ID as cartid, cart.Status as CartStatus, 
                  order_food.id as orderid, order_food.order_date, order_food.status as OrderStatus, 
                  customer_address.address as DeliveryAddress 
                  FROM cart 
                  INNER JOIN order_food ON cart.ID = order_food.id_cart 
                  INNER JOIN customer_address ON cart.delivery_address = customer_address.ID 
                  $whereClause";
                  // Thực hiện truy vấn và hiển thị kết quả
                  //..............................................
                  $result = $conn->query($sql);
                $count = 1;
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>".$count++."</td>";
                        echo "<td>".$row["cartid"]."</td>";
                        echo "<td>".$row["order_date"]."</td>";
                      
                      //status cart
                        echo "<td>";
                          if ( $row["CartStatus"] == 1) {
                            $cart_active = "btn-update";
                            $active1 = "Đã xác nhận";

                          }
                          else {
                            $cart_active = "btn-delete";
                            $active1 = "Chưa xác nhận";
                          }
                          echo "<a href='" . SITEURL . "admin/status-cart.php?ID=".$row["cartid"]."&status=".$row["CartStatus"]."' class='$cart_active'>$active1</a>";
                        echo  "</td>";
                       
                        // status order
                        echo "<td>";
                            
                            if ($row["OrderStatus"] == 1) {
                              $order_active = "btn-update";
                              $active2 = "Thành công";

                            }
                            else {
                              $order_active = "btn-delete";
                              $active2 = "Huỷ đơn";
                            }
                            echo "<a href='" . SITEURL . "admin/status-order.php?ID=".$row["orderid"]."&status=".$row["OrderStatus"]."' class='$order_active'>$active2</a>";
                        echo "</td>";

                        //details
                        echo "<td>
                                <a href='". SITEURL. "admin/detail-order.php?id=".$row["orderid"]."' class='btn-update'>View Details</a>
                              </td>";

                        

                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'><div class='error'>No Orders Available</div></td></tr>";
                }
                $conn->close();  
                // ......................................................................
                }
                else {
                $sql = "SELECT cart.ID as cartid, cart.Status as CartStatus, order_food.id as orderid, order_food.order_date, order_food.status as OrderStatus FROM cart INNER JOIN order_food ON cart.ID = order_food.id_cart";
                $result = $conn->query($sql);
                $count = 1;
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>".$count++."</td>";
                        echo "<td>".$row["cartid"]."</td>";
                        echo "<td>".$row["order_date"]."</td>";
                      
                      //status cart
                        echo "<td>";
                          if ( $row["CartStatus"] == 1) {
                            $cart_active = "btn-update";
                            $active1 = "Đã xác nhận";

                          }
                          else {
                            $cart_active = "btn-delete";
                            $active1 = "Chưa xác nhận";
                          }
                          echo "<a href='" . SITEURL . "admin/status-cart.php?ID=".$row["cartid"]."&status=".$row["CartStatus"]."' class='$cart_active'>$active1</a>";
                        echo  "</td>";
                       
                        // status order
                        echo "<td>";
                            
                            if ($row["OrderStatus"] == 1) {
                              $order_active = "btn-update";
                              $active2 = "Thành công";

                            }
                            else {
                              $order_active = "btn-delete";
                              $active2 = "Huỷ đơn";
                            }
                            echo "<a href='" . SITEURL . "admin/status-order.php?ID=".$row["orderid"]."&status=".$row["OrderStatus"]."' class='$order_active'>$active2</a>";
                        echo "</td>";

                        //details
                        echo "<td>
                                <a href='". SITEURL. "admin/detail-order.php?id=".$row["orderid"]."' class='btn-update'>View Details</a>
                              </td>";

                        

                        echo "</tr>";
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

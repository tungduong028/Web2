<?php include('patials/menu.php'); ?>


        <!-- Main content -->
        <div class="main-content">
            <div class="wrapper">
                <h1>Manage Customer</h1>

                <br>
                <?php 
                    if(isset($_SESSION['add']))
                    {
                        echo $_SESSION['add'];
                        unset($_SESSION['add']);
                    }
                    if(isset($_SESSION['update_customer']))
                    {
                        echo $_SESSION['update_customer'];
                        unset($_SESSION['update_customer']);
                    }
                    if(isset($_SESSION['update_empty']))
                    {
                        echo $_SESSION['update_empty'];
                        unset($_SESSION['update_empty']);
                    }
                    if(isset($_SESSION['update_status']))
                    {
                        echo $_SESSION['update_status'];
                        unset($_SESSION['update_status']);
                    }
                ?>
                
                <br><br><br>

                <!-- Button to add customer -->
                <a href="add-customer.php" class="btn-add">Add Customer</a>

                <br /><br /><br />

                <table class="table-full">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Username</th>
                        <th>Password</th>
                        <th>Address</th>
                        <th>Phone</th>
                        <th>Status</th>
                    </tr>
                    <?php
                    $sql = "SELECT * FROM customer";
                    $res = mysqli_query($conn, $sql);

                    if($res==TRUE){
                        $count = mysqli_num_rows($res);
                        if($count > 0){
                            while($rows = mysqli_fetch_assoc($res)){
                                $ID = $rows['ID'];
                                $name = $rows['name'];
                                $username = $rows['username'];
                                $password = $rows['password'];
                                $address = $rows['address'];
                                $phone = $rows['phone'];
                                $status = $rows['status'];

                                ?>
                                <tr>
                                    <td><?php echo $ID ?></td>
                                    <td><?php echo $name ?></td>
                                    <td><?php echo $username ?></td>
                                    <td><?php echo $password ?></td>
                                    <td><?php echo $address ?></td>
                                    <td><?php echo $phone ?></td>
                                    <td>
                                        <?php
                                        //change status
                                         if ($status == 1) {
                                           $class_active = "btn-update";
                                           $active = "On";

                                         }
                                         else {
                                           $class_active = "btn-delete";
                                           $active = "Off";
                                         }
                                         echo "<a href='" . SITEURL . "admin/status-customer.php?ID=$ID&status=$status' class='$class_active'>$active</a>";

                                        ?>
                                    </td>
                                    <td>
                                        <a href="<?php echo SITEURL; ?>admin/update-customer.php?ID=<?php echo $ID; ?>" class="btn-update">Update</a>
                                    </td>
                                </tr>

                                <?php
                            }
                        }
                    }
                    else{
                        
                    }
                    
                    ?>
                    
                    
                </table>

            </div>
        </div>

        
        

<?php include('patials/footer.php'); ?>
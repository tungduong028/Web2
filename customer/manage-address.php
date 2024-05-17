<?php include('patials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Address List</h1>

        <br>

        <?php
            if(isset($_SESSION['address-delete']))
            {
                echo $_SESSION['address-delete'];
                unset($_SESSION['address-delete']);
            }

            if(isset($_SESSION['add-address']))
            {
                echo $_SESSION['add-address'];
                unset($_SESSION['add-address']);
            }
        
        ?>

        <br><br><br>

        <!-- Button to add admin -->
        <a href="<?php echo SITEURL; ?>customer/add-address.php" class="btn-confirm">Add New Address</a>

        <br /><br /><br />

        <form action="" method="POST">

            <table class="table-full">
                    <tr>
                        <th>STT</th>
                        <th>Address</th>
                        <th>Phone</th>
                        <th>Actions</th>
                    </tr>

                    <?php
                        $username = $_SESSION['user'];

                        $sql = "SELECT a.ID AS address_ID, c.ID AS customer_ID, a.address AS find_address, a.phone AS address_phone, a.status AS address_status FROM customer_address AS a JOIN customer AS c ON a.User_ID = c.ID WHERE c.username = '$username' AND a.status = 1";
                        $res = mysqli_query($conn, $sql);

                        if($res==TRUE){
                            $i = 1;
                            $count = mysqli_num_rows($res);
                            if($count > 0){
                                while($rows = mysqli_fetch_assoc($res)){
                                    $customerID = $rows['customer_ID'];
                                    $id = $rows['address_ID'];
                                    $address = $rows['find_address'];
                                    $phone = $rows['address_phone'];
                                    $status = $rows['address_status'];
                                    ?>
                                    <tr>
                                        <td><?php echo $i++?></td>
                                        <td><?php echo $address?></td>
                                        <td><?php echo $phone?></td>
                                        <td>
                                            <a href="<?php echo SITEURL; ?>customer/update-address.php?id=<?php echo $id; ?>" class="btn btn-primary">Update</a>
                                            <a href="<?php echo SITEURL; ?>customer/delete-address.php?id=<?php echo $id; ?>" class="btn btn-primary">Delete</a>
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

        </form>

    </div>
</div>

<?php include('patials/footer.php'); ?>
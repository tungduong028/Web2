<?php include('patials/menu.php'); ?>

<!-- Main content -->
<div class="main-content">
    <div class="wrapper">
            <h1>Add Customer</h1>
            <br />
            <?php
              if (isset( $_SESSION['check_empty'])) {
                echo  $_SESSION['check_empty'];
                unset ( $_SESSION['check_empty']);
              }
            ?>
            <br><br>
            <form action="" method="POST">

                <table class="table-30">
                    <tr>
                        <td> Name: </td>
                        <td>
                            <input type="text" name="name" placeholder="Enter Your Name">
                        </td>
                    </tr>

                    <tr>
                        <td>UserName: </td>
                        <td>
                            <input type="text" name="username" placeholder="Enter Your Username">
                        </td>
                    </tr>

                    <tr>
                        <td>Password: </td>
                        <td>
                            <input type="password" name="password" placeholder="Enter Your Password">
                        </td>
                    </tr>
                    <tr>
                        <td>Address: </td>
                        <td>
                            <input type="text" name="address" placeholder="Enter Your Address">
                        </td>
                    </tr>

                    <tr>
                        <td>Phone: </td>
                        <td>
                            <input type="number" name="phone" placeholder="Enter Your Phone">
                        </td>
                    </tr>
                    <tr>
                        <td>Status: </td>
                        <td>
                          <input type="radio" name="status" value="1"> 1
                          <input type="radio" name="status" value="0"> 0
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <input type="submit" name="submit" value="Add customer" class="btn-update">
                        </td>
                    </tr>
                    
                </table>

            </form>
            
    </div>
</div>

<?php include('patials/footer.php'); ?>

<?php 
    //Xử lí dữ liệu từ Form và lưu vào Database
    //Check xem button Submit có click hay không
    if(isset($_POST['submit'])){
        //button click
        //Lấy data từ form
        $name = $_POST['name'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $address = $_POST['address'];
        $phone = $_POST['phone'];
        $status = $_POST['status'];
        //kiêm tra dữ liệu nhâp vào
        if(empty($name) || empty($username) || empty($password) || empty($address) || empty($phone) || empty($status)){
            $_SESSION['check_empty'] = "<div class = 'error'>If information is missing, please add it</div>";
            header("location:".SITEURL.'admin/add-customer.php');
            die();
        }
        //SQL query để lưu data vào Database
        $sql = "INSERT INTO customer SET
            name = '$name' ,
            username = '$username' ,
            password = '$password',
            address = '$address' ,
            phone = '$phone',
            status = '$status' 
        ";

        //Lưu vào Database
        $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));

        //Kiểm tra xem đã lưu được hay không
        if($res==TRUE){
            $_SESSION['add'] = "customer Added Successfully";
            header("location:".SITEURL.'admin/manage-customer.php');
        }
        else{
            $_SESSION['add'] = "Failed To Add customer";
            header("location:".SITEURL.'admin/manage-customer.php');
        }
    }

?>
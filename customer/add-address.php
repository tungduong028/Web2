<?php include('patials/menu.php'); ?>

<!-- Main content -->
<div class="main-content">
    <div class="wrapper">
            <h1>Add New Address</h1>
            <br />
            <form action="" method="POST">

                <table class="table-30">
                    <tr>
                        <td>Address: </td>
                        <td>
                            <input type="text" name="address" placeholder="Enter Your Address">
                        </td>
                    </tr>

                    <tr>
                        <td>Phone: </td>
                        <td>
                            <input type="text" name="phone" placeholder="Enter Your Phone">
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2">
                            <input type="submit" name="submit" value="Add Address" class="btn-update">
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
        $address = $_POST['address'];
        $phone = $_POST['phone'];

        $username = $_SESSION['user'];
        $sql = "SELECT * FROM customer WHERE username = '$username'";
        $res = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($res);
        $userID = $row['ID'];

        //SQL query để lưu data vào Database
        $sql = "INSERT INTO customer_address SET
            User_ID ='$userID' ,
            address ='$address' ,
            phone ='$phone'
        ";

        //Lưu vào Database
        $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));

        //Kiểm tra xem đã lưu được hay không
        if($res==TRUE){
            $_SESSION['add-address'] = "<div class='success'>Address Added Successfully.</div>";
            header("location:".SITEURL.'customer/update-address.php');
        }
        else{
            $_SESSION['add-address'] = "<div class='error'>Failed To Add Address.</div>";
            header("location:".SITEURL.'customer/update-address.php');
        }
    }

?>
<?php include('patials/menu.php'); ?>

<!-- Main content -->
<div class="main-content">
    <div class="wrapper">
            <h1>Add Admin</h1>
            <br />
            <form action="" method="POST">

                <table class="table-30">
                    <tr>
                        <td>Full Name: </td>
                        <td>
                            <input type="text" name="full_name" placeholder="Enter Your Name">
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
                        <td colspan="2">
                            <input type="submit" name="submit" value="Add Admin" class="btn-update">
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
        $full_name = $_POST['full_name'];
        $username = $_POST['username'];
        $password = $_POST['password'];

        //SQL query để lưu data vào Database
        $sql = "INSERT INTO admin SET
            full_name='$full_name' ,
            username='$username' ,
            password='$password'
        ";

        //Lưu vào Database
        $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));

        //Kiểm tra xem đã lưu được hay không
        if($res==TRUE){
            $_SESSION['add'] = "Admin Added Successfully";
            header("location:".SITEURL.'admin/manage-admin.php');
        }
        else{
            $_SESSION['add'] = "Failed To Add Admin";
            header("location:".SITEURL.'admin/manage-admin.php');
        }
    }

?>
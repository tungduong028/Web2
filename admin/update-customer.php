<?php include('patials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Customer</h1>

        <br>
        
        
        <br><br>

        <?php
            
            // 1. Get the ID of selected admin
            $ID = $_GET['ID'];

            // 2. Create SQL query to get the details
            $sql = "SELECT * FROM customer WHERE ID = $ID";

            // Execute the query
            $res = mysqli_query($conn, $sql);

            // Check whether the query is execute or not
            if($res == true)
            {
                // Check whether the date is available or not
                $count = mysqli_num_rows($res);
                // Check whether we have admin data or not
                if($count == 1)
                {
                    // Get the details
                    //echo "Admin available";
                    $row = mysqli_fetch_assoc($res);

                    $name = $row['name'];
                    $username = $row['username'];
                    $password = $row['password'];
                    $address = $row['address'];
                    $phone = $row['phone'];

                }
                else
                {
                    // Redirect to Manage Admin Page
                    header('location:'.SITEURL.'admin/manage-customer.php');
                }
            }

        ?>
        

        <form action="" method="POST">

            <table class="table-30">
                <tr>
                    <td>Full Name: </td>
                    <td>
                        <input type="text" name="name" value="<?php echo $name; ?>">
                    </td>
                </tr>

                <tr>
                    <td>UserName: </td>
                    <td>
                        <input type="text" name="username" value="<?php echo $username; ?>">
                    </td>
                </tr>
                <tr>
                    <td>Password: </td>
                    <td>
                        <input type="text" name="password" value="<?php echo $password; ?>">
                    </td>
                </tr>
                <tr>
                    <td>Address: </td>
                    <td>
                        <input type="text" name="address" value="<?php echo $address; ?>">
                    </td>
                </tr>
                <tr>
                    <td>Phone: </td>
                    <td>
                        <input type="number" name="phone" value="<?php echo $phone; ?>">
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="hidden" name="ID" value="<?php echo $ID; ?>">
                        <input type="submit" name="submit" value="Update Customer" class="btn-update">
                    </td>
                </tr>

            </table>

        </form>
    </div>
</div>

<?php

    // Check whether the submit butotn is clicked or not
    if(isset($_POST['submit']))
    {
        //echo "Button Clicked";
        // Get all the value from form to update
        $ID = $_POST['ID'];
        $name = $_POST['name'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $address = $_POST['address'];
        $phone = $_POST['phone'];
        if(empty($name) || empty($username) || empty($password) || empty($address) || empty($phone) ){
            $_SESSION['update_empty'] = "<div class = 'error'>If information is missing, please add it, field cannot be left blank</div>";
            header("location:".SITEURL.'admin/manage-customer.php');
            die();
        }
        // Create a SQL query to update admin
        $sql = "UPDATE customer SET
        name = '$name',
        username = '$username',
        password = '$password',
        address = '$address',
        phone = '$phone'
        WHERE ID = '$ID'
        ";

        // Execute the query
        $res = mysqli_query($conn, $sql);

        // Check whether the query executte successfully or not
        if($res == true)
        {
            // Query exucute successfully and admin updated
            $_SESSION['update_customer'] = "<div class='success'>Customer Updated Successfully.</div>";
            // Redirect to manage admin page
            header('location:'.SITEURL.'admin/manage-customer.php');
        }
        else
        {
            // Failed to update admin
            $_SESSION['update_customer'] = "<div class='error'>Failed to Update Customer.</div>";
            // Redirect to manage admin page
            header('location:'.SITEURL.'admin/manage-customer.php');
        }
    }

?>


<?php include('patials/footer.php'); ?>
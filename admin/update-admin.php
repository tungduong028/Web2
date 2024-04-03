<?php include('patials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Admin</h1>

        <br><br>

        <?php
            // 1. Get the ID of selected admin
            $id = $_GET['id'];

            // 2. Create SQL query to get the details
            $sql = "SELECT * FROM admin WHERE id=$id";

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

                    $full_name = $row['full_name'];
                    $username = $row['username'];
                }
                else
                {
                    // Redirect to Manage Admin Page
                    header('location:'.SITEURL.'admin/manage-admin.php');
                }
            }

        ?>
        

        <form action="" method="POST">

            <table class="table-30">
                <tr>
                    <td>Full Name: </td>
                    <td>
                        <input type="text" name="full_name" value="<?php echo $full_name; ?>">
                    </td>
                </tr>

                <tr>
                    <td>UserName: </td>
                    <td>
                        <input type="text" name="username" value="<?php echo $username; ?>">
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Update Admin" class="btn-update">
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
        $id = $_POST['id'];
        $full_name = $_POST['full_name'];
        $username = $_POST['username'];

        // Create a SQL query to update admin
        $sql = "UPDATE admin SET
        full_name = '$full_name',
        username = '$username'
        WHERE id = '$id'
        ";

        // Execute the query
        $res = mysqli_query($conn, $sql);

        // Check whether the query executte successfully or not
        if($res == true)
        {
            // Query exucute successfully and admin updated
            $_SESSION['update'] = "<div class='success'>Admin Updated Successfully.</div>";
            // Redirect to manage admin page
            header('location:'.SITEURL.'admin/manage-admin.php');
        }
        else
        {
            // Failed to update admin
            $_SESSION['update'] = "<div class='error'>Failed to Update Admin.</div>";
            // Redirect to manage admin page
            header('location:'.SITEURL.'admin/manage-admin.php');
        }
    }

?>


<?php include('patials/footer.php'); ?>
<?php include('patials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Change Password</h1>
        <br><br>

        <?php
            if(isset($_GET['submit']))
            {
                $id = $_GET['id'];
            }
        ?>

        <form action="" method="POST">

            <table class="table-30">
                <tr>
                    <td>New Password: </td>
                    <td>
                        <input type="Password" name="new_password" placeholder="New Password">
                    </td>
                </tr>

                <tr>
                    <td>Confirm Password: </td>
                    <td>
                        <input type="Password" name="confirm_password" placeholder="Confirm Password">
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Change Password" class="btn-update">
                    </td>
                </tr>

            </table>

        </form>

    </div>
</div>

<?php

    // Check whether the submit button is clicked or not
    if(isset($_POST['submit']))
    {
        $new_password = md5($_POST['new_password']);
        $confirm_password = md5($_POST['confirm_password']);

        if($new_password == $confirm_password)
        {
            $sql = "UPDATE admin SET
            password = '$new_password',
            username = '$username'
            WHERE id = '$id'
            ";

            $res = mysqli_query($conn, $sql);

            if($res == true)
            {
                $_SESSION['change-pwd'] = "<div class='success'>Password Change Success.</div>";
                header('location:'.SITEURL.'admin/manage-admin.php');
            }
            else
            {
                $_SESSION['password-pwd'] = "<div class='error'>Failed to Change Password.</div>";
                header('location:'.SITEURL.'admin/manage-admin.php');
            }
        }
        else
        {
            $_SESSION['password-not-match'] = "<div class='error'>Password Did Not Match.</div>";
            header('location:'.SITEURL.'admin/manage-admin.php');
        }
    }

?>

<?php include('patials/footer.php'); ?>
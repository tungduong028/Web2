<?php include('patials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Infomation</h1>
        <br><br>

        <?php
        
            $username = $_SESSION['user'];

            $sql = "SELECT * FROM customer WHERE username = '$username'";

            $res = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($res);
            $name = $row['name'];
            $address = $row['address'];
            $phone = $row['phone'];

            if(isset($_SESSION['update']))
            {
                echo $_SESSION['update'];
                unset($_SESSION['update']);
            }

            if(isset($_SESSION['password-not-match']))
            {
                echo $_SESSION['password-not-match'];
                unset($_SESSION['password-not-match']);
            }

            if(isset($_SESSION['change-pwd']))
            {
                echo $_SESSION['change-pwd'];
                unset($_SESSION['change-pwd']);
            }

            if(isset($_SESSION['not-see-pwd']))
            {
                echo $_SESSION['not-see-pwd'];
                unset($_SESSION['not-see-pwd']);
            }

        ?>

        <br><br>

        <form action="" method="POST">

            <table class="table-30">
                <tr>
                    <td>Username: </td>
                    <td>
                        <?php echo $username; ?>
                    </td>
                </tr>

                <tr>
                    <td>Name: </td>
                    <td>
                        <?php echo $name; ?>
                    </td>
                </tr>

                <tr>
                    <td>Address: </td>
                    <td>
                        <?php echo $address; ?>
                    </td>
                </tr>

                <tr>
                    <td>Phone number: </td>
                    <td>
                        <?php echo $phone; ?>
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" name="change-info" value="Change Infomation" class="btn-confirm">
                        <input type="submit" name="change-pass" value="Change Password" class="btn-confirm">
                    </td>
                </tr>

            </table>

        </form>

    </div>
</div>

<?php

    if(isset($_POST['change-pass']))
    {
        header('location:'.SITEURL.'customer/update-password.php');
    }

    if(isset($_POST['change-info']))
    {
        header('location:'.SITEURL.'customer/update-infomation.php');
    }

?>

<?php include('patials/footer.php'); ?>
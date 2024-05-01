<?php include('patials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Change Information</h1>
        <br><br>

        <?php    
            $username = $_SESSION['user'];
    
            $sql = "SELECT * FROM customer WHERE username = '$username'";
    
            $res = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($res);

            $name = $row['name'];
            $address = $row['address'];
            $phone = $row['phone'];

    
        ?>

        <form action="" method="POST">

            <table class="table-30">
                <tr>
                    <td>Name: </td>
                    <td>
                        <input type="text" name="name" value="<?php echo $name ?>">
                    </td>
                </tr>

                <tr>
                    <td>Address: </td>
                    <td>
                        <input type="text" name="address" value="<?php echo $address ?>">
                    </td>
                </tr>

                <tr>
                    <td>Phone Number: </td>
                    <td>
                        <input type="text" name="phone" value="<?php echo $phone ?>">
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Change Infomation" class="btn-confirm">
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
        $name = $_POST['name'];
        $address= $_POST['address'];
        $phone= $_POST['phone'];

        $username = $_SESSION['user'];

        $sql = "UPDATE customer SET
        name = '$name',
        address = '$address',
        phone = '$phone'
        WHERE username = '$username'
        ";

        $res = mysqli_query($conn, $sql);

        if($res == true)
        {
            $_SESSION['update'] = "<div class='success'>Change Infomation Success.</div>";
            header('location:'.SITEURL.'customer/infomation.php');
        }
        else
        {
            $_SESSION['update'] = "<div class='error'>Failed to Change Infomation.</div>";
            header('location:'.SITEURL.'customer/infomation.php');
        }
        
    }

?>

<?php include('patials/footer.php'); ?>
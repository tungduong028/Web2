<?php
    include('patials/menu.php'); 

    if(isset($_GET['id'])) {
        $id = $_GET['id'];

        // Fetch the current details of the address
        $sql = "SELECT * FROM customer_address WHERE id=$id";
        $res = mysqli_query($conn, $sql);

        if($res==TRUE) {
            $count = mysqli_num_rows($res);
            if($count==1) {
                $row = mysqli_fetch_assoc($res);
                $address = $row['address'];
                $phone = $row['phone'];
            } else {
                // Redirect to address list with error message
                $_SESSION['no-address-found'] = "Address Not Found";
                header('location:'.SITEURL.'customer/address-list.php');
            }
        }
    } else {
        // Redirect to address list
        header('location:'.SITEURL.'customer/address-list.php');
    }
?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Address</h1>

        <br><br>

        <form action="" method="POST">
            <table class="table-30">
                <tr>
                    <td>Address:</td>
                    <td>
                        <input type="text" name="address" value="<?php echo $address; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Phone:</td>
                    <td>
                        <input type="text" name="phone" value="<?php echo $phone; ?>">
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Update Address" class="btn btn-primary">
                    </td>
                </tr>
            </table>
        </form>

        <?php
            if(isset($_POST['submit'])) {
                $id = $_POST['id'];
                $address = $_POST['address'];
                $phone = $_POST['phone'];

                $sql2 = "UPDATE customer_address SET
                    address = '$address',
                    phone = '$phone'
                    WHERE id=$id
                ";

                $res2 = mysqli_query($conn, $sql2);

                if($res2==TRUE) {
                    $_SESSION['update'] = "Address Updated Successfully";
                    header('location:'.SITEURL.'customer/manage-address.php');
                } else {
                    $_SESSION['update'] = "Failed to Update Address";
                    header('location:'.SITEURL.'customer/update-address.php?id='.$id);
                }
            }
        ?>

    </div>
</div>

<?php include('patials/footer.php'); ?>

<?php

    // Include constants.php file here
    include('../admin/config/constants.php');

    // 1. Get the ID of admin to be deleted
    $id = $_GET['id'];

    // 2. Create SQL query to delete admin
    $sql = "UPDATE customer_address SET status = '0' WHERE id = $id";

    // Execute the query
    $res = mysqli_query($conn, $sql);

    // Check whether the query executte successfully or not
    if($res == true)
    {
        // Query exucute successfully and admin deleted
        //echo "Admin deleted";
        //  Create session variable to display message
        $_SESSION['address-delete'] = "<div class='success'>Address Deleted Successfully.</div>";
        header('location:'.SITEURL.'customer/update-address.php');
    }
    else
    {
        // Failed to delete admin
        //echo("Failed to delete admin");

        $_SESSION['address-delete'] = "<div class='error'>Failed to Delete Address. Try Again Later.</div>";
        header('location:'.SITEURL.'customer/update-address.php');
    }

    // 3. Redirect to manage admin page with message (success/error)

?>
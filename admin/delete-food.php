<?php
    //echo "delete food page"
    include('../config/constants.php');

    if(isset($_GET['id']) && isset($_GET['image_name'])){ //either 'use' && or 'AND'
        //process to delete
        echo "Process to delete";

    }else{
        //redirect to manage food page
        //echo "redirect"
        $_SESSION['delete'] = "<div class='error'>Unauthorized Access</div>";
        header('location'.SITEURL.'admin/manage-food.php');
    }
?>